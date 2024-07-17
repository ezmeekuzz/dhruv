<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\ListingAgentsModel;

class EditListingAgentController extends SessionController
{
    public function index($id)
    {
        $listingAgentsModel = new ListingAgentsModel();
        $details = $listingAgentsModel->find($id);
        $data = [
            'title' => 'DHRUV Realty | Edit Listing Agent',
            'currentpage' => 'listingagentmasterlist',
            'details' => $details
        ];
        return view('pages/admin/editlistingagent', $data);
    }

    public function update()
    {
        $listingAgentsModel = new ListingAgentsModel();
        $listingAgentId = $this->request->getPost('listing_agent_id');

        // Retrieve existing profile image path for deletion if necessary
        $existingImage = $listingAgentsModel->find($listingAgentId)['profileimage'];

        // Handle file upload if a new file is selected
        $uploadedFile = $this->request->getFile('profileimage');

        if ($uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
            // Generate a unique name for the file
            $newName = $uploadedFile->getRandomName();

            // Directory to save uploads
            $uploadDir = FCPATH . 'uploads/profile-image';

            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Store the file in the uploads folder
            $uploadedFile->move($uploadDir, $newName);

            // Update data including new profile image
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'email' => $this->request->getPost('email'),
                'licenseno' => $this->request->getPost('licenseno'),
                'phonenumber' => $this->request->getPost('phonenumber'),
                'mobilenumber' => $this->request->getPost('mobilenumber'),
                'position' => $this->request->getPost('position'),
                'profileimage' => 'uploads/profile-image/' . $newName,
            ];

            // Remove existing profile image if there was one
            if (!empty($existingImage) && file_exists($existingImage)) {
                unlink($existingImage);
            }
        } else {
            // Update data excluding profile image
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'email' => $this->request->getPost('email'),
                'licenseno' => $this->request->getPost('licenseno'),
                'phonenumber' => $this->request->getPost('phonenumber'),
                'mobilenumber' => $this->request->getPost('mobilenumber'),
                'position' => $this->request->getPost('position'),
            ];
        }

        // Perform database update
        $result = $listingAgentsModel->update($listingAgentId, $data);

        // Prepare response based on update result
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Listing agent updated successfully!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to update listing agent.',
            ];
        }

        // Return JSON response
        return $this->response->setJSON($response);
    }
}
