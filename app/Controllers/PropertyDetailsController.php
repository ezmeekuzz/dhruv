<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\ListingAgentsModel;
use App\Models\Admin\AdditionalListingAgentsModel;
use App\Models\Admin\InvestmentHighlightsModel;
use App\Models\Admin\PropertyGalleriesModel;
use App\Models\MessagesModel;
use App\Models\OmConsentModel;

class PropertyDetailsController extends BaseController
{
    public function index($id)
    {
        $propertiesModel = new PropertiesModel();
        $additionalListingAgentsModel = new AdditionalListingAgentsModel();
        $investmentHighlightsModel = new InvestmentHighlightsModel();
        $propertyGalleryModel = new PropertyGalleriesModel();
        $propertyDetails = $propertiesModel
        ->join('property_types', 'property_types.property_type_id=properties.property_type_id', 'left')
        ->join('listing_agents', 'listing_agents.listing_agent_id=properties.listing_agent_id', 'left')
        ->join('states', 'states.state_id=properties.state_id', 'left')
        ->join('cities', 'cities.city_id=properties.city_id', 'left')
        ->where('properties.publishstatus', 'Published')
        ->find($id);
        
        $additionaListingAgentLists = $additionalListingAgentsModel
        ->join('listing_agents', 'listing_agents.listing_agent_id=additional_listing_agents.listing_agent_id', 'left')
        ->where('additional_listing_agents.property_id', $id)
        ->findAll();
        
        $investmentHighlightLists = $investmentHighlightsModel
        ->where('property_id', $id)
        ->findAll();
        
        $propertyGallery = $propertyGalleryModel
        ->where('property_id', $id)
        ->orderBy('order_sequence', 'asc')
        ->findAll();

        $data = [
            'title' => $propertyDetails['property_name']. ' | DHRUV Realty',
            'propertyDetails' => $propertyDetails,
            'additionaListingAgentLists' => $additionaListingAgentLists,
            'investmentHighlightLists' => $investmentHighlightLists,
            'propertyGallery' => $propertyGallery,
        ];
        return view('pages/propertydetails', $data);
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