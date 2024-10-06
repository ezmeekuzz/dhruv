<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\PropertiesModel;
use App\Models\Admin\PropertyTypesModel;
use App\Models\Admin\StatesModel;
use App\Models\Admin\CitiesModel;
use App\Models\Admin\PropertyGalleriesModel;
use App\Models\Admin\SpacesModel;

class SoldListingsController extends BaseController
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
        $spacesModel = new SpacesModel();
        
        // Fetch property types and states
        $propertyTypes = $propertyTypesModel->findAll();
        $spaces = $spacesModel->findAll();
    
        // Fetch unique states associated with properties
        $uniqueStates = $propertiesModel
        ->join('states', 'states.state_id = properties.state_id')
        ->where('properties.soldstatus', 'sold')
        ->distinct()
        ->findAll();
    
        // Initialize the locations array
        $locations = [];
    
        // Loop through the unique states to geocode and add location data
        foreach ($uniqueStates as $state) {
            $geocodedData = $this->geocodeState($state['location']);
            
            // Prepare the image URL and price
            $imageUrl = $state['backgroundimage'];
            $price = $state['price'];
            
            if ($geocodedData) {
                $locations[] = [
                    'purpose' => $state['purpose'],
                    'soldstatus' => $state['soldstatus'],
                    'location' => $state['location'],
                    'property_name' => $state['property_name'], 
                    'caprate' => $state['caprate'], 
                    'rental_rate' => $state['rental_rate'], 
                    'size_sf' => $state['size_sf'], 
                    'image_url' => $imageUrl,
                    'price' => $price,
                    'latitude' => $geocodedData['lat'],
                    'longitude' => $geocodedData['lng'],
                ];
            }
        }
    
        // Prepare data for the view
        $data = [
            'title' => 'Sold Listing | DHRUV Realty',
            'propertyTypes' => $propertyTypes,
            'spaces' => $spaces,
            'locations' => $locations,
        ];
    
        // Load the view with the prepared data
        return view('pages/sold-listing', $data);
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

    public function getForSaleGridProperties()
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
    
            if (!empty($filters['solddate'])) {
                $builder->where('properties.solddate', $filters['solddate']);
            }
    
            $builder->where('properties.publishstatus', 'Published');
            $builder->where('properties.purpose', 'For Sale');
            $builder->where('properties.soldstatus', 'sold');
    
            // Apply ordering filters
            if (!empty($filters['orderBy'])) {
                switch ($filters['orderBy']) {
                    case 'Price_Asc':
                        $builder->orderBy('properties.price', 'ASC');
                        break;
                    case 'Price_Desc':
                        $builder->orderBy('properties.price', 'DESC');
                        break;
                    case 'Cap_Asc':
                        $builder->orderBy('properties.caprate', 'ASC');
                        break;
                    case 'Cap_Desc':
                        $builder->orderBy('properties.caprate', 'DESC');
                        break;
                    default:
                        $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
                        break;
                }
            } else {
                $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
            }
    
            // Fetch properties
            $properties = $builder->findAll();
    
            // Initialize HTML content
            $htmlContent = '<div class="card-container">';
    
            foreach ($properties as $property) {
                // Fetch property galleries
                $galleries = $propertyGalleryModel
                    ->where('property_id', $property['property_id'])
                    ->orderBy('order_sequence', 'asc')
                    ->findAll();
    
                // Build card content
                $htmlContent .= '<div class="card">';
    
                // Wrap the image and SOLD label together
                $htmlContent .= '<div class="image-container">'; // New wrapper for the image and label
                
                // Add main image (or first gallery image)
                if (!empty($galleries)) {
                    $htmlContent .= '<img src="' . base_url($galleries[0]['location']) . '" alt="Card Image" class="card-image">';
                } else {
                    $htmlContent .= '<img src="https://via.placeholder.com/300x200" alt="Card Image" class="card-image">'; // Fallback if no images
                }
    
                // Add SOLD label
                $htmlContent .= '<div class="sold-watermark">SOLD</div>'; // Add SOLD label here
                
                $htmlContent .= '</div>'; // End image-container
    
                // Add hover overlay
                $htmlContent .= '<div class="hover-overlay"></div>';
    
                // Card details
                $htmlContent .= '<div class="card-details">';
                $htmlContent .= '<h2><a href="' . base_url('/' . $property['slug']) . '">' . $property['property_name'] . '</a></h2>';
                $htmlContent .= '<h3>Sold Price: $' . number_format($property['price']) . '</h3>';
                $htmlContent .= '<h3>Location: ' . $property['location'] . '</h3>';
                $htmlContent .= '</div>'; // End card-details
    
                $htmlContent .= '</div>'; // End card
            }
    
            $htmlContent .= '</div>'; // End card-container
    
            // Return the generated HTML content
            return $this->response->setBody($htmlContent);
        }
    }    
       
    public function getForLeasingGridProperties()
    {
        if ($this->request->isAJAX()) {
            $filters = $this->request->getPost();
    
            $propertiesModel = new PropertiesModel();
            $propertyGalleryModel = new PropertyGalleriesModel();
            $builder = $propertiesModel
                ->join('states', 'states.state_id = properties.state_id', 'left')
                ->join('cities', 'cities.city_id = properties.city_id', 'left')
                ->join('spaces', 'spaces.space_id = properties.space_id', 'left')
                ->where('purpose', 'For Leasing');
    
            // Apply filters
            if (!empty($filters['property_type_id2'])) {
                $builder->whereIn('properties.space_id', $filters['property_type_id2']);
            }

            if (!empty($filters['leaseddate'])) {
                $builder->where('properties.solddate', $filters['leaseddate']);
            }
    
            $builder->where('properties.publishstatus', 'Published');
            $builder->where('properties.soldstatus', 'sold');

            if (!empty($filters['orderBy'])) {
                switch ($filters['orderBy']) {
                    case 'PriceSF_Asc':
                        $builder->orderBy('properties.price_per_sf', 'ASC');
                        break;
                    case 'PriceSF_Desc':
                        $builder->orderBy('properties.price_per_sf', 'DESC');
                        break;
                    case 'Rental_Asc':
                        $builder->orderBy('properties.rental_rate', 'ASC');
                        break;
                    case 'Rental_Desc':
                        $builder->orderBy('properties.rental_rate', 'DESC');
                        break;
                    default:
                        $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
                        break;
                }
            } else {
                $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
            }

            $properties = $builder->findAll();
    
            // Start generating the specific HTML
            $htmlContent = '';
    
            foreach ($properties as $property) {
                // Check if the property is added within the last two weeks
                $dateAdded = new \DateTime($property['dateadded']);
                $twoWeeksAgo = new \DateTime('-2 weeks');
                $isNew = $dateAdded >= $twoWeeksAgo;
    
                // Begin list-item div with background image
                $htmlContent .= '<div class="list-item leasingItem" style="background-image: url(\'' . base_url($property['backgroundimage']) . '\');">';
    
                // Add SOLD watermark
                if ($property['soldstatus'] == 'sold') {
                    $htmlContent .= '<div class="sold-watermark">LEASED</div>';
                }
                // If the property is new, add the 'New' tag
                if ($isNew) {
                    $htmlContent .= '<a class="list-tag">New</a>';
                }
    
                // Add property details
                $htmlContent .= '<div class="list-info-sec">';
                $htmlContent .= '<div class="item-info">';
                $htmlContent .= '<h3><a class="sliderTitle" href="' . $property['slug'] . '">' . $property['property_name'] . '</a></h3>';
                $htmlContent .= '<p>City: ' . $property['cityname'] . '</p>'; // Assuming city_name is joined
                $htmlContent .= '<div class="item-price">';
                $htmlContent .= '<h5>Space Available : ' . number_format($property['size_sf']) . ' sf</h5>'; // Assuming 'size_sf' is the space available
                $htmlContent .= '<span>Type: ' . $property['spacetype'] . '</span>';
                $htmlContent .= '</div>'; // End item-price
                $htmlContent .= '</div>'; // End item-info
                $htmlContent .= '</div>'; // End list-info-sec
                $htmlContent .= '</div>'; // End list-item
            }
    
            // Return the generated HTML content
            return $this->response->setBody($htmlContent);
        }
    }
      
    public function getForSaleTabularProperties()
    {
        if ($this->request->isAJAX()) {
            $filters = $this->request->getPost();

            $propertiesModel = new PropertiesModel();
            $builder = $propertiesModel
                ->join('states', 'states.state_id = properties.state_id', 'left')
                ->join('cities', 'cities.city_id = properties.city_id', 'left')
                ->join('property_types', 'property_types.property_type_id = properties.property_type_id', 'left')
                ->where('purpose', 'For Sale');

            // Apply filters
            if (!empty($filters['property_type_id'])) {
                $builder->whereIn('properties.property_type_id', $filters['property_type_id']);
            }

            if (!empty($filters['solddate'])) {
                $builder->where('properties.solddate', $filters['solddate']);
            }
    
            $builder->where('properties.publishstatus', 'Published');
            $builder->where('properties.soldstatus', 'sold');

            if (!empty($filters['orderBy'])) {
                switch ($filters['orderBy']) {
                    case 'Price_Asc':
                        $builder->orderBy('properties.price', 'ASC');
                        break;
                    case 'Price_Desc':
                        $builder->orderBy('properties.price', 'DESC');
                        break;
                    case 'Cap_Asc':
                        $builder->orderBy('properties.caprate', 'ASC');
                        break;
                    case 'Cap_Desc':
                        $builder->orderBy('properties.caprate', 'DESC');
                        break;
                    default:
                        $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
                        break;
                }
            } else {
                $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
            }

            $properties = $builder->findAll();
            
            $htmlContent = "";

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

            // Return the generated HTML content
            return $this->response->setBody($htmlContent);
        }
    }
      
    public function getForLeasingTabularProperties()
    {
        if ($this->request->isAJAX()) {
            $filters = $this->request->getPost();

            $propertiesModel = new PropertiesModel();
            $builder = $propertiesModel
                ->join('states', 'states.state_id = properties.state_id', 'left')
                ->join('cities', 'cities.city_id = properties.city_id', 'left')
                ->join('spaces', 'spaces.space_id = properties.space_id', 'left')
                ->where('purpose', 'For Leasing');
    
            // Apply filters
            if (!empty($filters['property_type_id2'])) {
                $builder->whereIn('properties.space_id', $filters['property_type_id2']);
            }

            if (!empty($filters['leaseddate'])) {
                $builder->where('properties.solddate', $filters['leaseddate']);
            }
    
            $builder->where('properties.publishstatus', 'Published');
            $builder->where('properties.soldstatus', 'sold');

            if (!empty($filters['orderBy'])) {
                switch ($filters['orderBy']) {
                    case 'PriceSF_Asc':
                        $builder->orderBy('properties.price_per_sf', 'ASC');
                        break;
                    case 'PriceSF_Desc':
                        $builder->orderBy('properties.price_per_sf', 'DESC');
                        break;
                    case 'Rental_Asc':
                        $builder->orderBy('properties.rental_rate', 'ASC');
                        break;
                    case 'Rental_Desc':
                        $builder->orderBy('properties.rental_rate', 'DESC');
                        break;
                    default:
                        $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
                        break;
                }
            } else {
                $builder->orderBy('properties.property_id', 'ASC'); // Default ordering
            }

            $properties = $builder->findAll();
            
            $htmlContent = "";

            foreach ($properties as $property) {
                $htmlContent .= '<tr>';
                $htmlContent .= '<td><a href="' . $property['slug'] . '">' . $property['property_name'] . '</a></td>';
                $htmlContent .= '<td>' . $property['cityname'] . '</td>'; // Assuming 'city_name' is available
                $htmlContent .= '<td>' . $property['state_name'] . '</td>'; // Assuming 'state_name' is available
                $htmlContent .= '<td>$' . $property['rental_rate'] . '</td>';
                $htmlContent .= '<td>' . $property['leasestructure'] . '</td>';
                $htmlContent .= '<td>' . $property['spacetype'] . '</td>'; // Assuming 'property_type' is available
                $htmlContent .= '</tr>';
            }

            // Return the generated HTML content
            return $this->response->setBody($htmlContent);
        }
    }
}
