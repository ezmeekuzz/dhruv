<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\UsersModel;

class EditUserController extends SessionController
{
    public function index($id)
    {
        $usersModel = new UsersModel();
        $userDetails = $usersModel->find($id);
        $data = [
            'title' => 'Edit User | PageDuo',
            'currentpage' => 'usermasterlist',
            'userDetails' => $userDetails
        ];
        return view('pages/admin/edituser', $data);
    }
    public function update()
    {
        $usersModel = new UsersModel();
        $userId = $this->request->getPost('user_id');
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $username = $this->request->getPost('username');
        $emailaddress = $this->request->getPost('emailaddress');
        $password = $this->request->getPost('password');
        $usertype = $this->request->getPost('usertype');
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'emailaddress' => $emailaddress,
            'usertype' => $usertype // Assuming usertype should not be updated here
        ];
    
        // Check if password is provided and update password fields accordingly
        if (!empty($password)) {
            $data['password'] = $password;
            $data['encryptedpass'] = password_hash($password, PASSWORD_BCRYPT);
        }
    
        // Check if the provided username is already in use
        $userList = $usersModel->where('emailaddress', $emailaddress)->where('user_id !=', $userId)->first();
        if ($userList) {
            $response = [
                'success' => false,
                'message' => 'Email is not available',
            ];
        } else {
            // Update the user data
            $updated = $usersModel->update($userId, $data);
    
            if ($updated) {
                $response = [
                    'success' => true,
                    'message' => 'User updated successfully!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to update user.',
                ];
            }
        }
    
        return $this->response->setJSON($response);
    }    
}
