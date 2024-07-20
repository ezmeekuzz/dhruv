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

        $stateList = $statesModel->findAll();
        $listinAgentList = $listingAgentsModel->findAll();
        $propertyTypesList = $propertyTypesModel->findAll();
        $cityList = $citiesModel->findAll();
        $property = $propertiesModel->find($propertyId);
        $additionalListingAgents = $additionalListingAgentsModel->where('property_id', $propertyId)->findAll();
        $investmentHighlights = $investmentHighlightsModel->where('property_id', $propertyId)->findAll();

        $data = [
            'title' => 'DHRUV Realty | Edit Property',
            'currentpage' => 'propertymasterlist',
            'stateList' => $stateList,
            'cityList' => $cityList,
            'listinAgentList' => $listinAgentList,
            'propertyTypesList' => $propertyTypesList,
            'property' => $property,
            'additionalListingAgents' => $additionalListingAgents,
            'investmentHighlights' => $investmentHighlights
        ];
        return view('pages/admin/editproperty', $data);
    }

    public function getCities($stateId)
    {
        $citiesModel = new CitiesModel();
        $cities = $citiesModel->where('state_id', $stateId)->findAll();
        return $this->response->setJSON($cities);
    }

    public function update($propertyId)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();

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
            'price' => $this->request->getPost('price_per_sf'),
            'caprate' => $this->request->getPost('caprate'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'zipcode' => $this->request->getPost('zipcode'),
            'tenancy' => $this->request->getPost('tenancy'),
            'buildingsize' => $this->request->getPost('buildingsize'),
            'yearbuilt' => $this->request->getPost('yearbuilt'),
            'location' => $this->request->getPost('location'),
            'publishstatus' => ($this->request->getPost('publishstatus') == 'Yes') ? 'Published' : 'Draft'
        ];

        $file = $this->request->getFile('backgroundimage');
        $file2 = $this->request->getFile('offering_memorandum');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
    
            // Delete existing background image if it exists
            $existingProperty = $propertiesModel->find($propertyId);
            if (!empty($existingProperty['backgroundimage']) && file_exists(FCPATH . $existingProperty['backgroundimage'])) {
                unlink(FCPATH . $existingProperty['backgroundimage']);
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
    
            // Delete existing background image if it exists
            $existingProperty2 = $propertiesModel->find($propertyId);
            if (!empty($existingProperty2['offering_memorandum']) && file_exists(FCPATH . $existingProperty2['offering_memorandum'])) {
                unlink(FCPATH . $existingProperty2['offering_memorandum']);
            }
    
            $newFileName2 = $file2->getRandomName();
            $file2->move($uploadPath2, $newFileName2);
            $propertyData['offering_memorandum'] = 'uploads/offering-memorandum/' . $newFileName2;
        }

        $propertiesModel->update($propertyId, $propertyData);

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
}
