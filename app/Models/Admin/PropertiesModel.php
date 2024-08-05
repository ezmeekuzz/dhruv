<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PropertiesModel extends Model
{
    protected $table            = 'properties';
    protected $primaryKey       = 'property_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'property_name', 'slug', 'real_estate_type', 'property_type_id', 'listing_agent_id', 'price', 'price_per_sf', 'state_id', 'city_id', 'zipcode', 'caprate', 'tenancy', 'buildingsize', 'yearbuilt', 'location', 'askingcaprate', 'noi', 'leasestructure', 'occupancy', 'backgroundimage', 'offering_memorandum', 'publishstatus', 'dateadded'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
