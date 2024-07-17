<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;

class PropertyMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Property Masterlist',
            'currentpage' => 'propertymasterlist'
        ];
        return view('pages/admin/propertymasterlist', $data);
    }
    public function getData()
    {
        return datatables('properties')
            ->join('property_types', 'property_types.property_type_id = properties.property_type_id', 'LEFT JOIN')
            ->join('listing_agents', 'listing_agents.listing_agent_id = properties.listing_agent_id', 'LEFT JOIN')
            ->join('states', 'states.state_id = properties.state_id', 'LEFT JOIN')
            ->join('cities', 'cities.city_id = properties.city_id', 'LEFT JOIN')
            ->make();
    }
    public function delete($id)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();

        $property = $propertiesModel->find($id);
        if (!$property) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Property not found']);
        }

        $backgroundImage = $property['backgroundimage'];
        
        $additionalListingAgentsModel->where('property_id', $id)->delete();
        $investmentHighlightsModel->where('property_id', $id)->delete();
        $deleted = $propertiesModel->delete($id);
    
        if ($deleted) {
            $filePath = $backgroundImage;
            if (file_exists($filePath)) {
                unlink($filePath);
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

        $propertyDetails = $propertyModel
        ->join('property_types', 'property_types.property_type_id=properties.property_type_id', 'left')
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

        $propertyDetails['additional_listing_agents'] = $additionalListingAgents;
        $propertyDetails['investment_highlights'] = $investmentHighlights;
        
        return $this->response->setJSON($propertyDetails);
    } 
}
