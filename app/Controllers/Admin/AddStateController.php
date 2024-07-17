<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\StatesModel;

class AddStateController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Add State',
            'currentpage' => 'addstate'
        ];
        return view('pages/admin/addstate', $data);
    }
    public function insert()
    {
        $statesModel = new StatesModel();
        $state_code = $this->request->getPost('state_code');
        $state_name = $this->request->getPost('state_name');
    
        $data = [
            'state_code' => $state_code,
            'state_name' => $state_name,
        ];

        $result = $statesModel->insert($data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'State added successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to add state.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
