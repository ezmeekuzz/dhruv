<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\SpacesModel;

class EditSpaceController extends SessionController
{
    public function index($id)
    {
        $SpacesModel = new SpacesModel();
        $details = $SpacesModel->find($id);
        $data = [
            'title' => 'DHRUV Realty | Edit Space',
            'currentpage' => 'spacemasterlist',
            'details' => $details
        ];
        return view('pages/admin/editspace', $data);
    }
    public function update()
    {
        $SpacesModel = new SpacesModel();
        $spacetype = $this->request->getPost('spacetype');
        $spaceId = $this->request->getPost('space_id');
        $data = [
            'spacetype' => $spacetype
        ];

        $result = $SpacesModel->update($spaceId, $data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Space type updated successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to updated Space type.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
