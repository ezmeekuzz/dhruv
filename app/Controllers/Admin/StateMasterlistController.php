<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;

class StateMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | State Masterlist',
            'currentpage' => 'statemasterlist'
        ];
        return view('pages/admin/statemasterlist', $data);
    }
    public function getData()
    {
        return datatables('states')->make();
    }
    public function delete($id)
    {
        $statesModel = new StatesModel();
        $citiesModel = new CitiesModel();
        
        $citiesModel->where('state_id', $id)->delete();
        $deleted = $statesModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the state from the database']);
        }
    }    
}
