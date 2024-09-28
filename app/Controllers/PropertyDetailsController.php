<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\ListingAgentsModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;
use App\Models\Admin\LeasingUnitsModel;
use App\Models\MessagesModel;
use App\Models\OmConsentModel;

class PropertyDetailsController extends BaseController
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = 'AIzaSyALqBsjd6GtBlG1JSn_Ux4c8t5QSTBf-0A';
    }
    public function index($id)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleryModel = new PropertyGalleriesModel();
        $leasingUnitsModel = new LeasingUnitsModel();
        $propertyDetails = $propertiesModel
        ->join('property_types', 'property_types.property_type_id=properties.property_type_id', 'left')
        ->join('spaces', 'spaces.space_id=properties.space_id', 'left')
        ->join('listing_agents', 'listing_agents.listing_agent_id=properties.listing_agent_id', 'left')
        ->join('states', 'states.state_id=properties.state_id', 'left')
        ->join('cities', 'cities.city_id=properties.city_id', 'left')
        ->where('properties.publishstatus', 'Published')
        ->find($id);

        $geocodedData = $this->geocodeState($propertyDetails['location']);
        
        $additionaListingAgentLists = $additionalListingAgentsModel
        ->join('listing_agents', 'listing_agents.listing_agent_id=additional_listing_agents.listing_agent_id', 'left')
        ->where('additional_listing_agents.property_id', $id)
        ->findAll();
        
        $investmentHighlightLists = $investmentHighlightsModel
        ->where('property_id', $id)
        ->findAll();
        
        $leasingUnitsList = $leasingUnitsModel
        ->join('leasing_galleries', 'leasing_galleries.leasing_unit_id = leasing_units.leasing_unit_id AND leasing_galleries.order_arrangement = 1', 'left')
        ->where('property_id', $id)
        ->findAll();
        
        $propertyGallery = $propertyGalleryModel
        ->where('property_id', $id)
        ->orderBy('order_sequence', 'asc')
        ->findAll();

        $locations = [
            'purpose' => $propertyDetails['purpose'],
            'location' => $propertyDetails['location'],
            'property_name' => $propertyDetails['property_name'], 
            'caprate' => $propertyDetails['caprate'], 
            'rental_rate' => $propertyDetails['rental_rate'], 
            'size_sf' => $propertyDetails['size_sf'], 
            'image_url' => $propertyDetails['backgroundimage'],
            'price' => $propertyDetails['price'],
            'latitude' => $geocodedData['lat'],
            'longitude' => $geocodedData['lng'],
        ];

        $data = [
            'title' => $propertyDetails['property_name']. ' | DHRUV Realty',
            'propertyDetails' => $propertyDetails,
            'additionaListingAgentLists' => $additionaListingAgentLists,
            'investmentHighlightLists' => $investmentHighlightLists,
            'propertyGallery' => $propertyGallery,
            'locations' => $locations,
            'leasingUnitsList' => $leasingUnitsList,
        ];
        if($propertyDetails['purpose'] == 'For Sale') {
            return view('pages/forsale', $data);
        }
        else {
            return view('pages/forlease', $data);
        }
    }
    private function geocodeState($state)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($state) . "&key=" . $this->apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response);
    
        if ($data->status === 'OK') {
            return [
                'lat' => $data->results[0]->geometry->location->lat,
                'lng' => $data->results[0]->geometry->location->lng
            ];
        }
    
        return false;
    } 
    public function sendMessage()
    {
        $messagesModel = new MessagesModel();
        $data = [
            'fname' => $this->request->getPost('fname'),
            'lname' => $this->request->getPost('lname'),
            'note' => $this->request->getPost('note'),
            'phonenumber' => $this->request->getPost('phonenumber'),
            'property' => $this->request->getPost('property'),
            'link' => $this->request->getPost('link'),
            'emailaddress' => $this->request->getPost('email'),
        ];
    
        $content = "";

        $content .= "Email : " . $data['emailaddress'] . "<br/>";
        $content .= "Phone Number : " . $data['phonenumber'] . "<br/>";
        $content .= "First Name : " . $data['fname'] . "<br/>";
        $content .= "Last Name : " . $data['lname'] . "<br/>";
        $content .= "Property : " . $data['property'] . "<br/>";
        $content .= "Property URL: <a href='" . $data['link'] . "'>".$data['property']."</a><br/>";
        $content .= "Note : " . $data['note'] . "<br/>";
        // Email sending code
        $email = \Config\Services::email();
        $email->setTo('interested@dhruvcommercial.com');
        $email->setSubject('I am interested in this property!');
        $email->setMessage($content);

        if ($email->send()) {
            $messagesModel->insert($data);
            $response = [
                'success' => 'success',
                'message' => 'We will get back at you soon!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to send message!',
            ];
        }

        return $this->response->setJSON($response);
    }
    public function omConsent()
    {
        $omConsentModel = new OmConsentModel();
        $data = [
            'fullname' => $this->request->getPost('om-name'),
            'email' => $this->request->getPost('om-email'),
            'phone' => $this->request->getPost('om-phone'),
            'property_id' => $this->request->getPost('property_id'),
            'link' => $this->request->getPost('link'),
            'property' => $this->request->getPost('property'),
            'date' => date('Y-m-d')
        ];
    
        $content = "";

        $content .= "Full Name : " . $data['fullname'] . "<br/>";
        $content .= "Email : " . $data['email'] . "<br/>";
        $content .= "Phone Number : " . $data['phone'] . "<br/>";
        $content .= "Property : " . $data['property'] . "<br/>";
        $content .= "Property URL: <a href='" . base_url() . $data['link'] . "'>".$data['property']."</a>";
        
        $email = \Config\Services::email();
        $email->setTo('interested@dhruvcommercial.com');
        $email->setSubject('I am interested in this property!');
        $email->setMessage($content);

        if ($email->send()) {
            $insert = $omConsentModel->insert($data);
            $response = [
                'success' => true,
                'message' => 'Successfully saved'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to save'
            ];
        }
        return $this->response->setJSON($response);
    }
}