<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\SpacesModel;

class SpaceMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Space Masterlist',
            'currentpage' => 'spacemasterlist'
        ];
        return view('pages/admin/spacemasterlist', $data);
    }
    public function getData()
    {
        return datatables('spaces')->make();
    }
    public function delete($id)
    {
        $SpacesModel = new SpacesModel();
        
        $deleted = $SpacesModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the space type from the database']);
        }
    }    
}
