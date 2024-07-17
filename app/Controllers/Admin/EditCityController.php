<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;

class EditCityController extends SessionController
{
    public function index($id)
    {
        $citiesModel = new CitiesModel();
        $statesModel = new StatesModel();
        $states = $statesModel->findAll();
        $details = $citiesModel
        ->join('states', 'states.state_id=cities.state_id', 'left')
        ->find($id);
        $data = [
            'title' => 'DHRUV Realty | Edit City',
            'currentpage' => 'statemasterlist',
            'states' => $states,
            'details' => $details,
        ];
        return view('pages/admin/editcity', $data);
    }
    public function update()
    {
        $citiesModel = new CitiesModel();
        $city_id = $this->request->getPost('city_id');
        $cityname = $this->request->getPost('cityname');
        $stateId = $this->request->getPost('state_id');
        $data = [
            'state_id' => $stateId,
            'cityname' => $cityname,
        ];

        $result = $citiesModel->update($city_id, $data);
    
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'City updated successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to updated city.',
            ];
        }
    
        return $this->response->setJSON($response);
    }   
}
