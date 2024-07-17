<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\ListingAgentsModel;

class ListingAgentMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Listing Agent Masterlist',
            'currentpage' => 'listingagentmasterlist'
        ];
        return view('pages/admin/listingagentmasterlist', $data);
    }

    public function getData()
    {
        return datatables('listing_agents')->make();
    }

    public function delete($id)
    {
        $listingAgentsModel = new ListingAgentsModel();
        $agent = $listingAgentsModel->find($id);

        if (!$agent) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Listing agent not found.']);
        }

        // Check and delete profile image file if it exists
        $existingImage = $agent['profileimage']; // Adjust path as per your application
        
        if (!empty($agent['profileimage']) && file_exists($existingImage)) {
            // Proceed with database deletion
            $deleted = $listingAgentsModel->delete($id);
            if (unlink($existingImage)) {
                if ($deleted) {
                    return $this->response->setJSON(['status' => 'success']);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the listing agent from the database.']);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the profile image file.']);
            }
        } else {
            // If image file doesn't exist or no image associated, proceed with database deletion
            $deleted = $listingAgentsModel->delete($id);
            if ($deleted) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the listing agent from the database.']);
            }
        }
    }
}
