<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SubscribeController extends BaseController
{
    public function index()
    {
        $data = [
            'emailaddress' => $this->request->getPost('emailaddress')
        ];
    
        $content = "";

        $content .= "Email : " . $data['emailaddress'] . "<br/>";
        // Email sending code
        $email = \Config\Services::email();
        $email->setTo('rustomcodilan@gmail.com');
        $email->setSubject('New subscriber!');
        $email->setMessage($content);

        if ($email->send()) {
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
