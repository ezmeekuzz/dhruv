<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\ListingAgentsModel;

class AddListingAgentController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Add Listing Agent',
            'currentpage' => 'addlistingagent'
        ];
        return view('pages/admin/addlistingagent', $data);
    }

    public function insert()
    {
        // Initialize necessary variables
        $listingAgentsModel = new ListingAgentsModel();
        $uploadedFile = $this->request->getFile('profileimage'); // Get uploaded file

        // Check if file was uploaded successfully
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

            // Form data
            $fullname = $this->request->getPost('fullname');
            $email = $this->request->getPost('email');
            $licenseno = $this->request->getPost('licenseno');
            $phonenumber = $this->request->getPost('phonenumber');
            $mobilenumber = $this->request->getPost('mobilenumber');
            $position = $this->request->getPost('position');

            // Data to be inserted into database
            $data = [
                'fullname' => $fullname,
                'email' => $email,
                'licenseno' => $licenseno,
                'phonenumber' => $phonenumber,
                'mobilenumber' => $mobilenumber,
                'position' => $position,
                'profileimage' => 'uploads/profile-image/' . $newName, // Save the file name to database
            ];

            // Insert data into database
            $result = $listingAgentsModel->insert($data);

            // Prepare response based on insert result
            if ($result) {
                $response = [
                    'success' => true,
                    'message' => 'Listing agent added successfully!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to add listing agent.',
                ];
            }
        } else {
            // Error handling if file upload fails
            $response = [
                'success' => false,
                'message' => 'Failed to upload profile image.',
            ];
        }

        // Return JSON response
        return $this->response->setJSON($response);
    }
}
