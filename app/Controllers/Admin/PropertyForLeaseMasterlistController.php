<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;
use App\Models\Admin\LeasingUnitsModel;

class PropertyForLeaseMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Property For Lease Masterlist',
            'currentpage' => 'propertyforleasemasterlist'
        ];
        return view('pages/admin/propertyforleasemasterlist', $data);
    }
    public function getData()
    {
        return datatables('properties')
            ->join('spaces', 'spaces.space_id = properties.space_id', 'LEFT JOIN')
            ->join('listing_agents', 'listing_agents.listing_agent_id = properties.listing_agent_id', 'LEFT JOIN')
            ->join('states', 'states.state_id = properties.state_id', 'LEFT JOIN')
            ->join('cities', 'cities.city_id = properties.city_id', 'LEFT JOIN')
            ->where('properties.purpose', 'For Leasing')
            ->make();
    }
    public function delete($id)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleryModel = new PropertyGalleriesModel();

        $property = $propertiesModel->find($id);
        $propertyGallery = $propertyGalleryModel->where('property_id', $id)->findAll();
        if (!$property) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Property not found']);
        }

        if($propertyGallery) {
            foreach($propertyGallery as $gallery) {
                if (file_exists($gallery['location'])) {
                    unlink($gallery['location']);
                }
            }
            $propertyGalleryModel->where('property_id', $id)->delete();
        }

        $backgroundImage = $property['backgroundimage'];
        $leasingFlyer = $property['leasing_flyer'];
        
        $additionalListingAgentsModel->where('property_id', $id)->delete();
        $investmentHighlightsModel->where('property_id', $id)->delete();
        $deleted = $propertiesModel->delete($id);
    
        if ($deleted) {
            $filePath1 = $backgroundImage;
            $filePath2 = $leasingFlyer;
            if (file_exists($filePath1)) {
                unlink($filePath1);
            }
            if (file_exists($filePath2)) {
                unlink($filePath2);
            }
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the city from the database']);
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

        $leasingUnits = $leasingUnitsModel
        ->where('property_id', $propertyId)
        ->findAll();

        $propertyDetails['additional_listing_agents'] = $additionalListingAgents;
        $propertyDetails['investment_highlights'] = $investmentHighlights;
        $propertyDetails['property_galleries'] = $propertyGalleries;
        $propertyDetails['leasing_units'] = $leasingUnits;
        
        return $this->response->setJSON($propertyDetails);
    } 
    public function deleteImage($imageId)
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
    
        // Collect POST data
        $property_id = $this->request->getPost('property_id');
        $unit_number = $this->request->getPost('unit_number');
        $leasing_rental_rate = $this->request->getPost('leasing_rental_rate');
        $space_available = $this->request->getPost('space_available');
        $space_use = $this->request->getPost('space_use');
    
        // Handle file upload for site plan map
        $site_plan_map = $this->request->getFile('site_plan_map');
    
        // Validate the file (optional)
        if ($site_plan_map && $site_plan_map->isValid() && !$site_plan_map->hasMoved()) {
            // Move the uploaded file to the desired location
            $newName = $site_plan_map->getRandomName();
            $site_plan_map->move(FCPATH . 'uploads/site-plans', $newName);
    
            // Prepare data for the database
            $data = [
                'property_id' => $property_id,
                'unit_number' => $unit_number,
                'leasing_rental_rate' => $leasing_rental_rate,
                'space_available' => $space_available,
                'space_use' => $space_use,
                'site_plan_map' => 'uploads/site-plans/' . $newName,
            ];
    
            // Insert data into the database
            $insert = $leasingUnitsModel->insert($data);
    
            // Check if insert is successful
            if ($insert) {
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
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid file or file upload error.',
            ]);
        }
    }    
    public function deleteLeasingUnit()
    {
        
        $leasingUnitsModel = new LeasingUnitsModel();

        $unitId = $this->request->getPost('id'); // Get the ID from the request

        // Fetch the unit details to get the file path (Assuming 'site_plan_map' holds the file path)
        $unit = $leasingUnitsModel->find($unitId);

        if ($unit) {
            // Get the file path
            $filePath = FCPATH . $unit['site_plan_map']; // Adjust 'site_plan_map' to the correct column

            // Check if the file exists and delete it
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file from the server
            }

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
}
