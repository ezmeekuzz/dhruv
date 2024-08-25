<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\PropertyTypesModel;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;
use App\Models\Admin\PropertyGalleriesModel;

class HomeController extends BaseController
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = 'AIzaSyALqBsjd6GtBlG1JSn_Ux4c8t5QSTBf-0A';
    }
    public function index()
    {
        $propertiesModel = new PropertiesModel();
        $propertyTypesModel = new PropertyTypesModel();
        $statesModel = new StatesModel();
        $propertyTypes = $propertyTypesModel->findAll();
        $statesList = $statesModel->findAll();
        $uniqueStates = $propertiesModel->join('states', 'states.state_id = properties.state_id')
                                        ->distinct()
                                        ->findAll();
        $locations = []; // Initialize the locations array
        foreach ($uniqueStates as $state) {
            $geocodedData = $this->geocodeState($state['location']);
            if ($geocodedData) {
                $locations[] = [
                    'state_name' => $state['property_name'],
                    'latitude' => $geocodedData['lat'],
                    'longitude' => $geocodedData['lng'],
                ];
            }
        }
        $data = [
            'title' => 'Listing | DHRUV Realty',
            'propertyTypes' => $propertyTypes,
            'statesList' => $statesList,
            'locations' => $locations
        ];
    
        return view('pages/home', $data);
    }
    
    private function geocodeState($state)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($state) . "&key=" . $this->apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response);
    
        if ($data->status === 'OK') {
            return [
                'lat' => $data->results[0]->geometry->location->lat,
                'lng' => $data->results[0]->geometry->location->lng
            ];
        }
    
        return false;
    }    

    public function getGridProperties()
    {
        if ($this->request->isAJAX()) {
            $filters = $this->request->getPost();
    
            $propertiesModel = new PropertiesModel();
            $propertyGalleryModel = new PropertyGalleriesModel();
            $builder = $propertiesModel
                ->join('states', 'states.state_id = properties.state_id', 'left')
                ->join('cities', 'cities.city_id = properties.city_id', 'left')
                ->join('property_types', 'property_types.property_type_id = properties.property_type_id', 'left');
    
            // Apply filters
            if (!empty($filters['property_type_id'])) {
                $builder->whereIn('properties.property_type_id', $filters['property_type_id']);
            }
    
            if (!empty($filters['state_id'])) {
                $builder->where('properties.state_id', $filters['state_id']);
            }
    
            if (!empty($filters['location'])) {
                $builder->like('properties.location', $filters['location'], 'both');
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
            
            $builder->where('properties.publishstatus', 'Published');
            $properties = $builder->findAll();
    
            // Start generating the specific HTML
            $htmlContent = '';
    
            foreach ($properties as $property) {
                // Fetch property galleries
                $galleries = $propertyGalleryModel
                ->where('property_id', $property['property_id'])
                ->orderBy('order_sequence', 'asc')
                ->findAll();
    
                // Begin list-item div
                $htmlContent .= '<div class="list-item" style="background-image: url(\'' . base_url($property['backgroundimage']) . '\');">';
                $htmlContent .= '<div class="mainSlider">';
    
                // Add gallery images to the slider
                foreach ($galleries as $gallery) {
                    $htmlContent .= '<div class="item"><img src="' . base_url($gallery['location']) . '" alt="Image"></div>';
                }
    
                // Close mainSlider and add remaining property details
                $htmlContent .= '</div>';
                // Check if the property is added within the last two weeks
                $dateAdded = new \DateTime($property['dateadded']);
                $twoWeeksAgo = new \DateTime('-2 weeks');

                if ($dateAdded >= $twoWeeksAgo) {
                    $htmlContent .= '<a class="list-tag">New</a>';
                }
                $htmlContent .= '<div class="list-info-sec">';
                $htmlContent .= '<div class="item-info">';
                $htmlContent .= '<h3><a href="' . $property['slug'] . '" class="sliderTitle">' . $property['property_name'] . '</a></h3>';
                $htmlContent .= '<p>Cap Rate: ' . $property['caprate'] . '%</p>';
                $htmlContent .= '<div class="item-price">';
                $htmlContent .= '<h5>Price: $' . number_format($property['price']) . '</h5>';
                $htmlContent .= '<span>Type: ' . $property['property_type'] . '</span>';
                $htmlContent .= '</div>'; // End item-price
                $htmlContent .= '</div>'; // End item-info
                $htmlContent .= '</div>'; // End list-info-sec
                $htmlContent .= '</div>'; // End list-item
            }
    
            // Return the generated HTML content
            return $this->response->setBody($htmlContent);
        }
    }    
    public function getTabularProperties()
    {
        if ($this->request->isAJAX()) {
            $filters = $this->request->getPost();

            $propertiesModel = new PropertiesModel();
            $builder = $propertiesModel
                ->join('states', 'states.state_id = properties.state_id', 'left')
                ->join('cities', 'cities.city_id = properties.city_id', 'left')
                ->join('property_types', 'property_types.property_type_id = properties.property_type_id', 'left');

            // Apply filters
            if (!empty($filters['property_type_id'])) {
                $builder->whereIn('properties.property_type_id', $filters['property_type_id']);
            }

            if (!empty($filters['state_id'])) {
                $builder->where('properties.state_id', $filters['state_id']);
            }

            if (!empty($filters['location'])) {
                $builder->like('properties.location', $filters['location'], 'both');
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

            // Start generating the specific HTML for table
            $htmlContent = '<table>';
            $htmlContent .= '<thead>
                                <tr>
                                    <th>Property Name</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Cap Rate</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                </tr>
                            </thead>';
            $htmlContent .= '<tbody>';

            foreach ($properties as $property) {
                $htmlContent .= '<tr>';
                $htmlContent .= '<td><a href="' . $property['slug'] . '">' . $property['property_name'] . '</a></td>';
                $htmlContent .= '<td>' . $property['cityname'] . '</td>'; // Assuming 'city_name' is available
                $htmlContent .= '<td>' . $property['state_name'] . '</td>'; // Assuming 'state_name' is available
                $htmlContent .= '<td>' . $property['caprate'] . '%</td>';
                $htmlContent .= '<td>$' . number_format($property['price']) . '</td>';
                $htmlContent .= '<td>' . $property['property_type'] . '</td>'; // Assuming 'property_type' is available
                $htmlContent .= '</tr>';
            }

            $htmlContent .= '</tbody>';
            $htmlContent .= '</table>';

            // Return the generated HTML content
            return $this->response->setBody($htmlContent);
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
