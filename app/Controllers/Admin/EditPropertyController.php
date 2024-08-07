<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertyTypesModel;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;
use App\Models\Admin\ListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;

class EditPropertyController extends SessionController
{
    public function index($propertyId)
    {
        $statesModel = new StatesModel();
        $listingAgentsModel = new ListingAgentsModel();
        $propertyTypesModel = new PropertyTypesModel();
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $citiesModel = new CitiesModel();
        $propertyGalleriesModel = new PropertyGalleriesModel();

        $stateList = $statesModel->findAll();
        $listinAgentList = $listingAgentsModel->findAll();
        $propertyTypesList = $propertyTypesModel->findAll();
        $cityList = $citiesModel->findAll();
        $property = $propertiesModel->find($propertyId);
        $additionalListingAgents = $additionalListingAgentsModel->where('property_id', $propertyId)->findAll();
        $investmentHighlights = $investmentHighlightsModel->where('property_id', $propertyId)->findAll();
        $propertyGalleries = $propertyGalleriesModel
        ->where('property_id', $propertyId)
        ->orderBy('order_sequence', 'asc')
        ->findAll();

        $data = [
            'title' => 'DHRUV Realty | Edit Property',
            'currentpage' => 'propertymasterlist',
            'stateList' => $stateList,
            'cityList' => $cityList,
            'listinAgentList' => $listinAgentList,
            'propertyTypesList' => $propertyTypesList,
            'property' => $property,
            'propertyGalleries' => $propertyGalleries,
            'additionalListingAgents' => $additionalListingAgents,
            'investmentHighlights' => $investmentHighlights,
            'propertyId' => $propertyId,
        ];
        return view('pages/admin/editproperty', $data);
    }

    public function getCities($stateId)
    {
        $citiesModel = new CitiesModel();
        $cities = $citiesModel->where('state_id', $stateId)->findAll();
        return $this->response->setJSON($cities);
    }

    public function getGalleries($propertyId)
    {
        $propertyGalleriesModel = new PropertyGalleriesModel();
    
        // Fetch the galleries based on the property ID
        $galleries = $propertyGalleriesModel
            ->where('property_id', $propertyId)
            ->orderBy('order_sequence', 'asc')
            ->findAll();
    
        // Return the galleries as a JSON response
        return $this->response->setJSON($galleries);
    }

    public function update($propertyId)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleriesModel = new PropertyGalleriesModel();
        $files = $this->request->getFiles();
    
        // Handle form data
        $propertyName = $this->request->getPost('propertyname');
        $propertyData = [
            'property_name' => $propertyName,
            'slug' => strtolower(str_replace(
                [" ", "&", "!", ",", "?", ":", ";", "/", "'", "(", ")"],
                ["-", "and", "", "", "", "", "", "-", "", ""],
                htmlentities($propertyName, ENT_QUOTES, 'UTF-8')
            )),
            'real_estate_type' => $this->request->getPost('real_estate_type'),
            'property_type_id' => $this->request->getPost('property_type_id'),
            'listing_agent_id' => $this->request->getPost('listing_agent_id'),
            'price' => $this->request->getPost('price'),
            'price_per_sf' => $this->request->getPost('price_per_sf'),
            'caprate' => $this->request->getPost('caprate'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'zipcode' => $this->request->getPost('zipcode'),
            'tenancy' => $this->request->getPost('tenancy'),
            'buildingsize' => $this->request->getPost('buildingsize'),
            'yearbuilt' => $this->request->getPost('yearbuilt'),
            'location' => $this->request->getPost('location'),
            'askingcaprate' => $this->request->getPost('askingcaprate'),
            'noi' => $this->request->getPost('noi'),
            'leasestructure' => $this->request->getPost('leasestructure'),
            'occupancy' => $this->request->getPost('occupancy'),
            'publishstatus' => ($this->request->getPost('publishstatus') == 'Yes') ? 'Published' : 'Draft'
        ];
    
        // Handle background image upload
        $file = $this->request->getFile('backgroundimage');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
    
            $existingProperty = $propertiesModel->find($propertyId);
            if (!empty($existingProperty['backgroundimage']) && file_exists(FCPATH . $existingProperty['backgroundimage'])) {
                unlink(FCPATH . $existingProperty['backgroundimage']);
            }
    
            $newFileName = $file->getRandomName();
            $file->move($uploadPath, $newFileName);
            $propertyData['backgroundimage'] = 'uploads/' . $newFileName;
        }
    
        // Handle Offering Memorandum upload
        $file2 = $this->request->getFile('offering_memorandum');
        if ($file2 && $file2->isValid() && !$file2->hasMoved()) {
            $uploadPath2 = FCPATH . 'uploads/offering-memorandum/';
            if (!is_dir($uploadPath2)) {
                mkdir($uploadPath2, 0755, true);
            }
    
            $existingProperty2 = $propertiesModel->find($propertyId);
            if (!empty($existingProperty2['offering_memorandum']) && file_exists(FCPATH . $existingProperty2['offering_memorandum'])) {
                unlink(FCPATH . $existingProperty2['offering_memorandum']);
            }
    
            $newFileName2 = $file2->getRandomName();
            $file2->move($uploadPath2, $newFileName2);
            $propertyData['offering_memorandum'] = 'uploads/offering-memorandum/' . $newFileName2;
        }
    
        // Update the property data
        $propertiesModel->update($propertyId, $propertyData);     
    
        // Handle additional listing agents
        $additionalListingAgentsModel->where('property_id', $propertyId)->delete();
        $selectedListingAgents = $this->request->getPost('additional_listing_agent_id');
        if (!empty($selectedListingAgents)) {
            foreach ($selectedListingAgents as $listingAgentId) {
                $additionalListingAgentsModel->insert([
                    'property_id' => $propertyId,
                    'listing_agent_id' => $listingAgentId
                ]);
            }
        }
    
        // Handle investment highlights
        $investmentHighlightsModel->where('property_id', $propertyId)->delete();
        $titles = $this->request->getPost('title');
        $contents = $this->request->getPost('content');
        if (!empty($titles) && !empty($contents) && is_array($titles) && is_array($contents)) {
            foreach ($titles as $index => $title) {
                if (isset($contents[$index])) {
                    $investmentHighlightsModel->insert([
                        'property_id' => $propertyId,
                        'title' => $title,
                        'content' => $contents[$index]
                    ]);
                }
            }
        }
    
        // Update dynamic routes
        $this->dynamicRoutes();
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Property updated successfully.'
        ]);
    }    

    private function dynamicRoutes()
    {
        $model = new PropertiesModel();
        $result = $model->findAll();
        $data = [];

        if (count($result)) {
            foreach ($result as $route) {
                $data[$route['slug']] = 'PropertyDetailsController::index/' . $route['property_id'];
            }
        }

        $output = '<?php' . PHP_EOL;
        foreach ($data as $slug => $controllerMethod) {
            $output .= '$routes->get(\'' . $slug . '\', \'' . $controllerMethod . '\');' . PHP_EOL;
        }

        $filePath = ROOTPATH . 'app/Config/Propertyroutes.php';
        file_put_contents($filePath, $output);
    }
    public function updateGalleryOrder()
    {
        $propertyGalleriesModel = new PropertyGalleriesModel();
        
        // Get the sorted galleries data from the AJAX request
        $sortedGalleries = $this->request->getPost('sortedGalleries');
        
        if (!empty($sortedGalleries) && is_array($sortedGalleries)) {
            foreach ($sortedGalleries as $gallery) {
                // Update the order_sequence for each gallery item
                $propertyGalleriesModel->update($gallery['property_gallery_id'], [
                    'order_sequence' => $gallery['order_sequence']
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gallery order updated successfully.'
        ]);
    }
    public function deleteGalleryFile() {
        $propertyGalleriesModel = new PropertyGalleriesModel();
        $propertyGalleryId = $this->request->getPost('property_gallery_id');
        $fileLocation = $this->request->getPost('file_location');
    
        // Delete the file from the database
        $propertyGalleriesModel->where('property_gallery_id', $propertyGalleryId)->delete();
    
        // Delete the actual file from the folder
        $filePath = FCPATH . $fileLocation; // Adjust according to your file structure
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    
        // Return response
        return $this->response->setJSON(['success' => true]);
    }    
    public function uploadGalleryFile()
    {
        $propertyGalleriesModel = new PropertyGalleriesModel();
        $files = $this->request->getFiles();
        $response = ['files' => [], 'success' => false];
    
        // Ensure $files is an array
        if (!is_array($files)) {
            $response['error'] = 'No files received.';
            return $this->response->setJSON($response);
        }
    
        foreach ($files['files'] as $index => $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Generate a unique name for the file and move it
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property-gallery', $newName);
    
                // Save file details to the database
                $data = [
                    'property_id' => $this->request->getPost('property_id'),
                    'location' => 'uploads/property-gallery/' . $newName,
                    'file_name' => $newName,
                    'original_name' => $file->getClientName(), // Save original file name
                    'order_sequence' => $this->request->getPost('order_sequence')[$index]
                ];
    
                $galleryId = $propertyGalleriesModel->insert($data);
                $response['files'][] = [
                    'property_gallery_id' => $galleryId,
                    'location' => $data['location']
                ];
            } else {
                $response['error'] = 'File upload failed.';
                return $this->response->setJSON($response);
            }
        }
    
        $response['success'] = true;
        return $this->response->setJSON($response);
    }    
}
