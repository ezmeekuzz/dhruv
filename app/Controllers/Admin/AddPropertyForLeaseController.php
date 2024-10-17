<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\SpacesModel;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;
use App\Models\Admin\ListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;

class AddPropertyForLeaseController extends SessionController
{
    public function index()
    {
        $statesModel = new StatesModel();
        $listingAgentsModel = new ListingAgentsModel();
        $SpacesModel = new SpacesModel();
        $stateList = $statesModel->findAll();
        $listingAgentList = $listingAgentsModel->findAll(); // Fixed typo from listinAgentList
        $SpacesList = $SpacesModel->findAll();
        $data = [
            'title' => 'DHRUV Realty | Add Property For Lease',
            'currentpage' => 'addpropertyforlease',
            'stateList' => $stateList,
            'listingAgentList' => $listingAgentList,
            'spacesList' => $SpacesList,
        ];
        return view('pages/admin/addpropertyforlease', $data);
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
            'purpose' => 'For Leasing',
            'property_name' => $propertyName,
            'slug' => strtolower(str_replace(
                [" ", "&", "!", ",", "?", ":", ";", "/", "'", "(", ")"], 
                ["-", "and", "", "", "", "", "", "-", "", ""], 
                htmlentities($propertyName, ENT_QUOTES, 'UTF-8')
            )) . '-' . $randomString,
            'anchor_tenant' => $this->request->getPost('anchor_tenant'),
            'space_id' => $this->request->getPost('space_id'),
            'listing_agent_id' => $this->request->getPost('listing_agent_id'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'zipcode' => $this->request->getPost('zipcode'),
            'buildingsize' => $this->request->getPost('buildingsize'),
            'yearbuilt' => $this->request->getPost('yearbuilt'),
            'location' => $this->request->getPost('location'),
            'leasestructure' => $this->request->getPost('leasestructure'),
            'rental_rate' => $this->request->getPost('rental_rate'),
            'size_sf' => $this->request->getPost('size_sf'),
            'addt' => $this->request->getPost('addt'),
            'starting_sf_yr' => $this->request->getPost('starting_sf_yr'),
            'ending_sf_yr' => $this->request->getPost('ending_sf_yr'),
            'sf_yr' => $this->request->getPost('sf_yr'),
            'publishstatus' => ($this->request->getPost('publishstatus') == 'Yes') ? 'Published' : 'Draft',
            'dateadded' => date('Y-m-d')
        ];
    
        // Handle file uploads
        $file = $this->request->getFile('backgroundimage');
        $file2 = $this->request->getFile('leasing_flyer');
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
            $uploadPath2 = FCPATH . 'uploads/leasing-flyer/';
            if (!is_dir($uploadPath2)) {
                mkdir($uploadPath2, 0755, true);
            }
            $newFileName2 = $file2->getRandomName();
            $file2->move($uploadPath2, $newFileName2);
            $propertyData['leasing_flyer'] = 'uploads/leasing-flyer/' . $newFileName2;
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
