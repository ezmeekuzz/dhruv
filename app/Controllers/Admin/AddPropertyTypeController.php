<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertyTypesModel;

class AddPropertyTypeController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Add Property Type',
            'currentpage' => 'addpropertytype'
        ];
        return view('pages/admin/addpropertytype', $data);
    }
    public function insert()
    {
        $propertyTypesModel = new PropertyTypesModel();
        $property_type = $this->request->getPost('property_type');
    
        $data = [
            'property_type' => $property_type
        ];

        $result = $propertyTypesModel->insert($data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Property type added successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to add property type.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
