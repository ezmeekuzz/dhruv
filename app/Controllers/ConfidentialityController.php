<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ConfidentialityController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Confidentiality',
        ];
        return view('pages/confidentiality', $data);
    }
}
