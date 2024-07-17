<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\CitiesModel;
use App\Models\Admin\StatesModel;

class AddCityController extends SessionController
{
    public function index()
    {
        $statesModel = new StatesModel();
        $states = $statesModel->findAll();
        $data = [
            'title' => 'DHRUV Realty | Add City',
            'currentpage' => 'addcity',
            'states' => $states
        ];
        return view('pages/admin/addcity', $data);
    }
    public function insert()
    {
        $citiesModel = new CitiesModel();
        $state_id = $this->request->getPost('state_id');
        $cityname = $this->request->getPost('cityname');
    
        $data = [
            'state_id' => $state_id,
            'cityname' => $cityname,
        ];

        $result = $citiesModel->insert($data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'City added successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to add city.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
