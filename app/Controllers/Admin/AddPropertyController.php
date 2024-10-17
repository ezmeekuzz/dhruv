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

class AddPropertyController extends SessionController
{
    public function index()
    {
        $statesModel = new StatesModel();
        $listingAgentsModel = new ListingAgentsModel();
        $propertyTypesModel = new PropertyTypesModel();
        $stateList = $statesModel->findAll();
        $listingAgentList = $listingAgentsModel->findAll(); // Fixed typo from listinAgentList
        $propertyTypesList = $propertyTypesModel->findAll();
        $data = [
            'title' => 'DHRUV Realty | Add Property',
            'currentpage' => 'addproperty',
            'stateList' => $stateList,
            'listingAgentList' => $listingAgentList,
            'propertyTypesList' => $propertyTypesList,
        ];
        return view('pages/admin/addproperty', $data);
    }

    public function getCities($stateId)
    {
        error_log("getCities method called with stateId: " . $stateId); // Debug log

        $citiesModel = new CitiesModel();
        $cities = $citiesModel->where('state_id', $stateId)->findAll();

        return $this->response->setJSON($cities);
    }

    public function insert()
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleriesModel = new PropertyGalleriesModel();
        $files = $this->request->getFiles();
        $propertyName = $this->request->getPost('propertyname');
        $randomString = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
        $propertyData = [
            'purpose' => 'For Sale',
            'property_name' => $propertyName,
            'slug' => strtolower(str_replace(
                [" ", "&", "!", ",", "?", ":", ";", "/", "'", "(", ")"], 
                ["-", "and", "", "", "", "", "", "-", "", ""], 
                htmlentities($propertyName, ENT_QUOTES, 'UTF-8')
            )) . '-' . $randomString,
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
            'publishstatus' => ($this->request->getPost('publishstatus') == 'Yes') ? 'Published' : 'Draft',
            'dateadded' => date('Y-m-d')
        ];
    
        // Handle file uploads
        $file = $this->request->getFile('backgroundimage');
        $file2 = $this->request->getFile('offering_memorandum');
        $file3 = $this->request->getFiles(); // Multiple files
    
        // Validate single file uploads
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newFileName = $file->getRandomName();
            $file->move($uploadPath, $newFileName);
            $propertyData['backgroundimage'] = 'uploads/' . $newFileName;
        }
    
        if ($file2 && $file2->isValid() && !$file2->hasMoved()) {
            $uploadPath2 = FCPATH . 'uploads/offering-memorandum/';
            if (!is_dir($uploadPath2)) {
                mkdir($uploadPath2, 0755, true);
            }
            $newFileName2 = $file2->getRandomName();
            $file2->move($uploadPath2, $newFileName2);
            $propertyData['offering_memorandum'] = 'uploads/offering-memorandum/' . $newFileName2;
        }
    
        $propertyId = $propertiesModel->insert($propertyData);
    
        if ($propertyId) {
            if ($file3) {
                foreach ($file3['files'] as $index => $fileGallery) {
                    if ($fileGallery->isValid() && !$fileGallery->hasMoved()) {
                        $uploadPath3 = FCPATH . 'uploads/property-gallery/';
                        if (!is_dir($uploadPath3)) {
                            mkdir($uploadPath3, 0755, true);
                        }
                        $newFileName3 = $fileGallery->getRandomName();
                        $fileGallery->move($uploadPath3, $newFileName3);
                        $sequence = $index + 1;
                        $propertyGalleriesModel->insert([
                            'property_id' => $propertyId,
                            'location' => 'uploads/property-gallery/' . $newFileName3,
                            'file_name' => $newFileName3,
                            'original_name' => $fileGallery->getClientName(), // Save original file name
                            'order_sequence' => $sequence
                        ]);
                    }
                }
            }
    
            // Additional inserts
            $selectedListingAgents = $this->request->getPost('additional_listing_agent_id');
            $selectedContents = $this->request->getPost('content');
            
            if (!empty($selectedListingAgents)) {
                foreach ($selectedListingAgents as $listingAgentId) {
                    $additionalListingAgentsModel->insert([
                        'property_id' => $propertyId,
                        'listing_agent_id' => $listingAgentId
                    ]);
                }
            }
    
            if (!empty($selectedContents)) {
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
            }
            
            $this->dynamicRoutes();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Property added successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add property.'
            ]);
        }
    }    
    
    private function dynamicRoutes() {
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
}
