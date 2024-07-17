<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\PropertyTypesModel;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;

class HomeController extends BaseController
{
    public function index()
    {
        $propertyTypesModel = new PropertyTypesModel();
        $statesModel = new StatesModel();
        $propertyTypes = $propertyTypesModel->findAll();
        $statesList = $statesModel->findAll();

        $data = [
            'title' => 'Listing | DHRUV Realty',
            'propertyTypes' => $propertyTypes,
            'statesList' => $statesList,
        ];

        return view('pages/home', $data);
    }

    public function getProperties()
    {
        if ($this->request->isAJAX()) {
            $filters = $this->request->getPost();

            $propertiesModel = new PropertiesModel();
            $builder = $propertiesModel->join('property_types', 'property_types.property_type_id = properties.property_type_id', 'left');

            // Apply filters
            if (!empty($filters['property_type_id'])) {
                $builder->whereIn('properties.property_type_id', $filters['property_type_id']);
            }

            if (!empty($filters['state_id'])) {
                $builder->where('properties.state_id', $filters['state_id']);
            }

            if (!empty($filters['city_id'])) {
                $builder->where('properties.city_id', $filters['city_id']);
            }

            if (!empty($filters['zip_code'])) {
                $builder->where('properties.zipcode', $filters['zip_code']);
            }

            if (!empty($filters['min_price'])) {
                $builder->where('properties.price >=', $filters['min_price']);
            }

            if (!empty($filters['max_price'])) {
                $builder->where('properties.price <=', $filters['max_price']);
            }

            if (!empty($filters['min_cr'])) {
                $builder->where('properties.caprate >=', $filters['min_cr']);
            }

            if (!empty($filters['max_cr'])) {
                $builder->where('properties.caprate <=', $filters['max_cr']);
            }

            if (!empty($filters['tenancy'])) {
                $builder->whereIn('properties.tenancy', $filters['tenancy']);
            }

            $properties = $builder->findAll();

            return $this->response->setJSON($properties);
        }
    }

    public function getCitiesByState()
    {
        if ($this->request->isAJAX()) {
            $stateId = $this->request->getPost('state_id');

            $cityModel = new CitiesModel();
            $cities = $cityModel->where('state_id', $stateId)->findAll();

            return $this->response->setJSON($cities);
        }
    }
}
