<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;
use App\Models\Admin\LeasingUnitsModel;
use App\Models\Admin\LeasingGalleriesModel;

class LeasedPropertyMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Leased Property Masterlist',
            'currentpage' => 'leasedpropertymasterlist'
        ];
        return view('pages/admin/leasedpropertymasterlist', $data);
    }
    public function getData()
    {
        return datatables('properties')
            ->join('spaces', 'spaces.space_id = properties.space_id', 'LEFT JOIN')
            ->join('listing_agents', 'listing_agents.listing_agent_id = properties.listing_agent_id', 'LEFT JOIN')
            ->join('states', 'states.state_id = properties.state_id', 'LEFT JOIN')
            ->join('cities', 'cities.city_id = properties.city_id', 'LEFT JOIN')
            ->where('properties.purpose', 'For Leasing')
            ->where('properties.soldstatus', 'sold')
            ->make();
    }
    public function delete($id)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleryModel = new PropertyGalleriesModel();
        $leasingGalleryModel = new LeasingGalleriesModel();
        $leasingUnitsModel = new LeasingUnitsModel();
    
        // Find the property
        $property = $propertiesModel->find($id);
        if (!$property) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Property not found']);
        }
    
        // Fetch property galleries
        $propertyGallery = $propertyGalleryModel->where('property_id', $id)->findAll();
        if ($propertyGallery) {
            foreach ($propertyGallery as $gallery) {
                if (file_exists($gallery['location'])) {
                    unlink($gallery['location']);
                }
            }
            $propertyGalleryModel->where('property_id', $id)->delete(); // Delete gallery records
        }
    
        // Fetch leasing units
        $leasingUnits = $leasingUnitsModel->where('property_id', $id)->findAll();
        if ($leasingUnits) {
            foreach ($leasingUnits as $unit) {
                // Fetch leasing galleries for each leasing unit
                $leasingGallery = $leasingGalleryModel->where('leasing_unit_id', $unit['leasing_unit_id'])->findAll();
                if ($leasingGallery) {
                    foreach ($leasingGallery as $gallery) {
                        if (file_exists($gallery['location'])) {
                            unlink($gallery['location']);
                        }
                    }
                    // Delete leasing gallery records
                    $leasingGalleryModel->where('leasing_unit_id', $unit['leasing_unit_id'])->delete();
                }
            }
        }
    
        // Delete additional data related to the property
        $additionalListingAgentsModel->where('property_id', $id)->delete();
        $investmentHighlightsModel->where('property_id', $id)->delete();
        $leasingUnitsModel->where('property_id', $id)->delete(); // Delete all leasing units
    
        // Delete the property record itself
        $deleted = $propertiesModel->delete($id);
    
        // Remove background image and leasing flyer files if they exist
        if ($deleted) {
            $backgroundImage = $property['backgroundimage'];
            $leasingFlyer = $property['leasing_flyer'];
    
            if ($backgroundImage && file_exists($backgroundImage)) {
                unlink($backgroundImage);
            }
            if ($leasingFlyer && file_exists($leasingFlyer)) {
                unlink($leasingFlyer);
            }
    
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the property from the database']);
        }
    }    
    public function propertyDetails()
    {
        $propertyId = $this->request->getVar('propertyId');
        
        $propertyModel = new propertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleryModel = new PropertyGalleriesModel();
        $leasingUnitsModel = new leasingUnitsModel();
        $leasingGalleriesModel = new leasingGalleriesModel();

        $propertyDetails = $propertyModel
        ->join('spaces', 'spaces.space_id=properties.space_id', 'left')
        ->join('listing_agents', 'listing_agents.listing_agent_id=properties.listing_agent_id', 'left')
        ->join('states', 'states.state_id=properties.state_id', 'left')
        ->join('cities', 'cities.city_id=properties.city_id', 'left')
        ->find($propertyId);

        $additionalListingAgents = $additionalListingAgentsModel
        ->join('listing_agents', 'listing_agents.listing_agent_id=additional_listing_agents.listing_agent_id', 'left')
        ->where('property_id', $propertyId)
        ->findAll();

        $investmentHighlights = $investmentHighlightsModel
        ->where('property_id', $propertyId)
        ->findAll();

        $propertyGalleries = $propertyGalleryModel
        ->where('property_id', $propertyId)
        ->orderBy('order_sequence', 'asc')
        ->findAll();
        
        $hasLeasingGalleries = $leasingGalleriesModel
        ->join('leasing_units', 'leasing_units.leasing_unit_id=leasing_galleries.leasing_unit_id', 'left')
        ->where('leasing_units.property_id', $propertyId)
        ->where('leasing_galleries.order_arrangement', 1)
        ->countAllResults() > 0;

        $query = $leasingUnitsModel->where('leasing_units.property_id', $propertyId)
                                ->orderBy('leasing_units.arrange_order', 'ASC');

        if ($hasLeasingGalleries) {
            $query->join('leasing_galleries', 'leasing_galleries.leasing_unit_id = leasing_units.leasing_unit_id AND leasing_galleries.order_arrangement = 1', 'left');
        }

        $leasingUnits = $query->findAll();


        $propertyDetails['additional_listing_agents'] = $additionalListingAgents;
        $propertyDetails['investment_highlights'] = $investmentHighlights;
        $propertyDetails['property_galleries'] = $propertyGalleries;
        $propertyDetails['leasing_units'] = $leasingUnits;
        
        return $this->response->setJSON($propertyDetails);
    } 
    public function Leasing($imageId)
    {
        $propertyGalleryModel = new PropertyGalleriesModel();

        // Find the image record by its ID
        $image = $propertyGalleryModel->find($imageId);

        if ($image) {
            // Delete the image file from the server
            $imagePath = FCPATH . $image['location']; // Adjust the path as needed
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the image record from the database
            if ($propertyGalleryModel->delete($imageId)) {
                return $this->response->setJSON(['status' => 'success']);
            }
        }

        return $this->response->setJSON(['status' => 'error']);
    }
    public function addLeasingUnit()
    {
        $leasingUnitsModel = new LeasingUnitsModel();
        $leasingGalleriesModel = new LeasingGalleriesModel();
    
        // Collect POST data
        $property_id = $this->request->getPost('property_id');
        $unit_number = $this->request->getPost('unit_number');
        $cam = $this->request->getPost('cam');
        $leasing_rental_rate = $this->request->getPost('leasing_rental_rate');
        $space_available = $this->request->getPost('space_available');
        $space_use = $this->request->getPost('space_use');
    
        // Handle file upload for site plan map
        $site_plan_maps = $this->request->getFileMultiple('site_plan_map');
    
        $existingUnitsCount = $leasingUnitsModel->where('property_id', $property_id)->countAllResults();
        $arrange_order = $existingUnitsCount + 1;
    
        // Prepare data for leasing unit
        $data = [
            'property_id' => $property_id,
            'unit_number' => $unit_number,
            'cam' => $cam,
            'leasing_rental_rate' => $leasing_rental_rate,
            'space_available' => $space_available,
            'space_use' => $space_use,
            'arrange_order' => $arrange_order,
        ];
    
        // Insert leasing unit data into the database
        $insertLeasingUnit = $leasingUnitsModel->insert($data);
    
        // Check if insert is successful
        if ($insertLeasingUnit) {
            $leasing_unit_id = $leasingUnitsModel->insertID(); // Get the ID of the newly created leasing unit
    
            // Loop through the uploaded site plan maps
            foreach ($site_plan_maps as $file) {
                // Validate the file
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the uploaded file to the desired location
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/site-plans', $newName);
    
                    // Prepare data for leasing galleries
                    $galleryData = [
                        'leasing_unit_id' => $leasing_unit_id,
                        'location' => 'uploads/site-plans/' . $newName, // Adjust this path as necessary
                        'order_arrangement' => 0, // Placeholder; will update the order later
                    ];
    
                    // Insert into the leasing galleries
                    if (!$leasingGalleriesModel->insert($galleryData)) {
                        // Optional: Log error if insert fails
                        log_message('error', 'Failed to insert gallery data: ' . json_encode($galleryData));
                    }
                } else {
                    // Optional: Log error if file validation fails
                    log_message('error', 'File validation failed for: ' . $file->getName());
                }
            }
    
            // After all files have been uploaded, update order arrangement
            $galleries = $leasingGalleriesModel->where('leasing_unit_id', $leasing_unit_id)->findAll();
            foreach ($galleries as $index => $gallery) {
                $leasingGalleriesModel->update($gallery['leasing_gallery_id'], [
                    'order_arrangement' => $index + 1 // Update the order arrangement based on the index
                ]);
            }
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Leasing Unit successfully added!',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add leasing unit!',
            ]);
        }
    }    
       
    public function deleteLeasingUnit()
    {
        $leasingUnitsModel = new LeasingUnitsModel();
        $leasingGalleriesModel = new LeasingGalleriesModel();
    
        $unitId = $this->request->getPost('id'); // Get the ID from the request
    
        // Fetch the unit details
        $unit = $leasingUnitsModel->find($unitId);
    
        if ($unit) {
            // Fetch associated galleries for the unit
            $galleries = $leasingGalleriesModel->where('leasing_unit_id', $unitId)->findAll();
    
            // Delete each gallery image file from the server
            foreach ($galleries as $gallery) {
                $filePath = FCPATH . $gallery['location']; // Assuming 'location' holds the file path
                if (file_exists($filePath)) {
                    unlink($filePath); // Delete the file from the server
                }
            }
    
            // Delete the galleries from the database
            $leasingGalleriesModel->where('leasing_unit_id', $unitId)->delete();
    
            // Delete the leasing unit record from the database
            if ($leasingUnitsModel->delete($unitId)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete leasing unit from database']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Leasing unit not found']);
        }
    }
    
    public function updateOrder()
    {
        $leasingUnitsModel = new LeasingUnitsModel();

        $order = $this->request->getPost('order'); // Array of material IDs in the new order

        if (!empty($order)) {
            foreach ($order as $index => $id) {
                $leasingUnitsModel->update($id, ['arrange_order' => $index + 1]);
            }

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                              ->setJSON(['status' => 'error', 'message' => 'Invalid order data']);
    }
    public function getLeasingUnitDetails() {
        $leasingUnitsModel = new LeasingUnitsModel();
        $leasingGalleriesModel = new LeasingGalleriesModel();
        $unitId = $this->request->getVar('unitId');
    
        // Fetch leasing unit details from the database
        $leasingUnit = $leasingUnitsModel->find($unitId);
        $leasingGallery = $leasingGalleriesModel
        ->where('leasing_unit_id', $leasingUnit['leasing_unit_id'])
        ->orderBy('order_arrangement', 'ASC')
        ->findAll();
    
        if ($leasingUnit) {
            // Include the 'status' key in the response
            return $this->response->setJSON(['data' => $leasingUnit, 'gallery' => $leasingGallery]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Leasing unit not found']);
        }
    }  
    public function updateImageOrder() {

        $leasingGalleriesModel = new LeasingGalleriesModel();

        $order = $this->request->getPost('order');
    
        if ($order && is_array($order)) {
            foreach ($order as $item) {
                // Assuming you have an 'id' for each image and a corresponding 'order' value
                $leasingGalleriesModel->update($item['id'], ['order_arrangement' => $item['order']]);  // Update the order in the database
            }
    
            return $this->response->setJSON(['success' => true]);
        }
    
        return $this->response->setJSON(['success' => false]);
    }
    public function deleteImageLeasing() {

        // Initialize the model
        $leasingGalleriesModel = new LeasingGalleriesModel();
    
        // Get the image ID from the POST request
        $imageId = $this->request->getPost('imageId');
    
        // Fetch the image details from the database
        $image = $leasingGalleriesModel->where('leasing_gallery_id', $imageId)->first();  // Use 'first()' to get a single row directly
    
        if ($image) {
            // Define the file path, assuming 'location' contains the relative path to the image
            $filePath = FCPATH . $image['location'];  // Adjust 'location' to match your column name
    
            // Check if the file exists on the server and delete it
            if (file_exists($filePath)) {
                unlink($filePath);  // Remove the image file from the server
            }
    
            // Delete the image record from the database
            $leasingGalleriesModel->delete($imageId);
    
            // Return success response
            return $this->response->setJSON(['success' => true, 'message' => 'Image deleted successfully']);
        } else {
            // Handle case where the image was not found in the database
            return $this->response->setJSON(['success' => false, 'message' => 'Image not found']);
        }
    }     
    public function uploadLeasingImage() {
        $leasingGalleriesModel = new LeasingGalleriesModel();
    
        // Check if the request has a file
        if ($this->request->getFile('file')) {
            $file = $this->request->getFile('file');
            $leasingUnitId = $this->request->getPost('leasing_unit_id');

            $existingUnitsCount = $leasingGalleriesModel->where('leasing_unit_id', $leasingUnitId)->countAllResults();
            $arrange_order = $existingUnitsCount + 1;
            // Validate the file (optional step)
            if ($file->isValid() && !$file->hasMoved()) {
                // Define the file path and move the file to the desired directory
                $newFileName = $file->getRandomName();  // Generate a unique file name
                $file->move(FCPATH . 'uploads/site-plans', $newFileName);
    
                // Prepare the data for database insertion
                $data = [
                    'leasing_unit_id' => $leasingUnitId,
                    'location' => 'uploads/site-plans/' . $newFileName,
                    'order_arrangement' => $arrange_order
                ];
    
                // Insert the file information into the database
                if ($leasingGalleriesModel->insert($data)) {
                    return $this->response->setJSON(['success' => true]);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Failed to insert image data into database']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid file or upload error']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No file provided']);
        }
    }    
    public function getLeasingImages() {
        $leasingGalleriesModel = new LeasingGalleriesModel();
        
        $leasingUnitId = $this->request->getGet('leasing_unit_id');
    
        // Fetch all images associated with the leasing unit
        $images = $leasingGalleriesModel
            ->where('leasing_unit_id', $leasingUnitId)
            ->findAll();
    
        if ($images) {
            return $this->response->setJSON(['success' => true, 'images' => $images]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No images found']);
        }
    }      
    public function editLeasingUnit()
    {
        $leasingUnitsModel = new LeasingUnitsModel();
        $leasingGalleriesModel = new LeasingGalleriesModel();
    
        // Collect POST data
        $leasing_unit_id = $this->request->getPost('leasing_unit_id');
        $property_id = $this->request->getPost('property_id');
        $unit_number = $this->request->getPost('unit_number');
        $cam = $this->request->getPost('cam');
        $leasing_rental_rate = $this->request->getPost('leasing_rental_rate');
        $space_available = $this->request->getPost('space_available');
        $space_use = $this->request->getPost('space_use');
    
        // Prepare data for leasing unit
        $data = [
            'property_id' => $property_id,
            'unit_number' => $unit_number,
            'cam' => $cam,
            'leasing_rental_rate' => $leasing_rental_rate,
            'space_available' => $space_available,
            'space_use' => $space_use,
        ];
        
        // Insert leasing unit data into the database
        $updateLeasingUnit = $leasingUnitsModel->update($leasing_unit_id, $data);
    
        // Check if insert is successful
        if ($updateLeasingUnit) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Leasing Unit successfully updated!',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update leasing unit!',
            ]);
        }
    }  
    public function unLeased()
    {
        // Load the PropertyModel
        $propertyModel = new PropertiesModel();

        // Get the property_id from the POST request
        $propertyId = $this->request->getPost('property_id');

        // Validate that the property ID is provided
        if (!$propertyId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Property ID is missing.'
            ]);
        }

        // Find the property in the database
        $property = $propertyModel->find($propertyId);

        // Check if the property exists
        if (!$property) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Property not found.'
            ]);
        }

        // Update the property's status to "sold"
        $propertyModel->update($propertyId, ['soldstatus' => '']);

        // Return success response
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Property has been marked as sold.'
        ]);
    }
}
