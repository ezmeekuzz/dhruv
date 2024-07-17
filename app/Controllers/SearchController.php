<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\PropertiesModel;

class SearchController extends BaseController
{
    public function index()
    {
        $query = $this->request->getPost('query');

        $propertyModel = new PropertiesModel();
        $results = $propertyModel
            ->join('states', 'states.state_id = properties.state_id', 'left')
            ->join('cities', 'cities.city_id = properties.city_id', 'left')
            ->groupStart()
                ->like('properties.property_name', $query)
                ->orLike('states.state_name', $query)
                ->orLike('cities.cityname', $query)
            ->groupEnd()
            ->findAll();

        return $this->response->setJSON(['results' => $results]);
    }
}
