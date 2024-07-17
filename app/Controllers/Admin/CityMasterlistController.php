<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;

class CityMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | City Masterlist',
            'currentpage' => 'citymasterlist'
        ];
        return view('pages/admin/citymasterlist', $data);
    }
    public function getData()
    {
        return datatables('cities')
            ->join('states', 'cities.state_id = states.state_id', 'LEFT JOIN')
            ->make();
    }
    public function delete($id)
    {
        $citiesModel = new CitiesModel();
        
        $deleted = $citiesModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the city from the database']);
        }
    }    
}
