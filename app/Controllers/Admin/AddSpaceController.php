<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\SpacesModel;

class AddSpaceController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Add Space',
            'currentpage' => 'addspace'
        ];
        return view('pages/admin/addspace', $data);
    }
    public function insert()
    {
        $SpacesModel = new SpacesModel();
        $spacetype = $this->request->getPost('spacetype');
    
        $data = [
            'spacetype' => $spacetype
        ];

        $result = $SpacesModel->insert($data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Space type added successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to add Space type.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
