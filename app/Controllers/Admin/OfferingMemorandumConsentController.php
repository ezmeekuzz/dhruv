<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OmConsentModel;

class OfferingMemorandumConsentController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Dashboard',
            'currentpage' => 'offeringmemorandumconsent'
        ];
        return view('pages/admin/offeringmemorandumconsent', $data);
    }
    public function getData()
    {
        return datatables('om_consents')
        ->join('properties', 'om_consents.property_id = properties.property_id', 'LEFT JOIN')
        ->make();
    }
    public function delete($id)
    {
        $OmConsentModel = new OmConsentModel();
        
        $deleted = $OmConsentModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the om consent from the database']);
        }
    } 
}
