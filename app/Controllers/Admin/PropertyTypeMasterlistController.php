<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertyTypesModel;

class PropertyTypeMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Property Type Masterlist',
            'currentpage' => 'propertytypemasterlist'
        ];
        return view('pages/admin/propertytypemasterlist', $data);
    }
    public function getData()
    {
        return datatables('property_types')->make();
    }
    public function delete($id)
    {
        $PropertyTypesModel = new PropertyTypesModel();
        
        $deleted = $PropertyTypesModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the property type from the database']);
        }
    }    
}
