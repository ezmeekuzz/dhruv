<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\StatesModel;

class EditStateController extends SessionController
{
    public function index($id)
    {
        $statesModel = new StatesModel();
        $details = $statesModel->find($id);
        $data = [
            'title' => 'DHRUV Realty | Edit State',
            'currentpage' => 'statemasterlist',
            'details' => $details
        ];
        return view('pages/admin/editstate', $data);
    }
    public function update()
    {
        $statesModel = new StatesModel();
        $state_code = $this->request->getPost('state_code');
        $state_name = $this->request->getPost('state_name');
        $stateId = $this->request->getPost('state_id');
        $data = [
            'state_code' => $state_code,
            'state_name' => $state_name,
        ];

        $result = $statesModel->update($stateId, $data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'States updated successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to updated states.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
