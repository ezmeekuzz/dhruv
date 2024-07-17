<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\UsersModel;

class AddUserController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Add User',
            'currentpage' => 'adduser'
        ];
        return view('pages/admin/adduser', $data);
    }
    public function insert()
    {
        $usersModel = new UsersModel();
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $username = $this->request->getPost('username');
        $emailaddress = $this->request->getPost('emailaddress');
        $usertype = $this->request->getPost('usertype');
        $password = $this->request->getPost('password');
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'emailaddress' => $emailaddress,
            'password' => $password,
            'encryptedpass' => password_hash($password, PASSWORD_BCRYPT),
            'usertype' => $usertype
        ];
        $userList = $usersModel->where('emailaddress', $emailaddress)->first();
        if($userList) {
            $response = [
                'success' => false,
                'message' => 'Email is not available',
            ];
        }
        else {
            $userId = $usersModel->insert($data);
    
            if ($userId) {
                $response = [
                    'success' => 'success',
                    'message' => 'User added successfully!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to add user.',
                ];
            }
        }

        return $this->response->setJSON($response);
    }
}
