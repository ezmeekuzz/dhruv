<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubscribersModel;

class SubscribeController extends BaseController
{
    public function index()
    {
        $subscribersModel = new SubscribersModel();
        $data = [
            'emailaddress' => $this->request->getPost('emailaddress')
        ];
    
        $content = "";

        $content .= "Email : " . $data['emailaddress'] . "<br/>";
        // Email sending code
        $email = \Config\Services::email();
        $email->setTo('subscribe@dhruvcommercial.com');
        $email->setSubject('New subscriber!');
        $email->setMessage($content);

        if ($email->send()) {
            $subscribersModel->insert($data);
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
}
