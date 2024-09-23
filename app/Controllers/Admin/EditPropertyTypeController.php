<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertyTypesModel;

class EditPropertyTypeController extends SessionController
{
    public function index($id)
    {
        $propertyTypesModel = new PropertyTypesModel();
        $details = $propertyTypesModel->find($id);
        $data = [
            'title' => 'DHRUV Realty | Edit Property Type',
            'currentpage' => 'propertytypemasterlist',
            'details' => $details
        ];
        return view('pages/admin/editpropertytype', $data);
    }
    public function update()
    {
        $propertyTypesModel = new PropertyTypesModel();
        $property_type = $this->request->getPost('property_type');
        $propertyTypeId = $this->request->getPost('property_type_id');
        $data = [
            'property_type' => $property_type
        ];

        $result = $propertyTypesModel->update($propertyTypeId, $data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Property type updated successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to updated property type.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
