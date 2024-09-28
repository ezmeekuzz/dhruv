<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;

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
            ->where('properties.purpose', 'For Sale')
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
        $offeringMemorandum = $property['offering_memorandum'];
        
        $additionalListingAgentsModel->where('property_id', $id)->delete();
        $investmentHighlightsModel->where('property_id', $id)->delete();
        $deleted = $propertiesModel->delete($id);
    
        if ($deleted) {
            $filePath1 = $backgroundImage;
            $filePath2 = $offeringMemorandum;
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

        $propertyGalleries = $propertyGalleryModel
        ->where('property_id', $propertyId)
        ->orderBy('order_sequence', 'asc')
        ->findAll();

        $propertyDetails['additional_listing_agents'] = $additionalListingAgents;
        $propertyDetails['investment_highlights'] = $investmentHighlights;
        $propertyDetails['property_galleries'] = $propertyGalleries;
        
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
    public function markAsSold()
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
        $propertyModel->update($propertyId, ['soldstatus' => 'sold']);

        // Return success response
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Property has been marked as sold.'
        ]);
    }
}
