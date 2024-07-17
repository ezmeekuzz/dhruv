<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\UsersModel;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->has('user_id') && session()->get('usertype') == 'Administrator') {
            return redirect()->to('/admin/dashboard');
        }
        $data = [
            'title' => 'DHRUV Realty | Login'
        ];
        return view('pages/admin/login', $data);
    }
    public function authenticate()
    {
        $userModel = new UsersModel();
    
        $emailaddress = $this->request->getPost('emailaddress');
        $password = $this->request->getPost('password');
    
        $result = $userModel
        ->where('emailaddress', $emailaddress)
        ->where('usertype', 'Administrator')
        ->first();
    
        if ($result && password_verify($password, $result['encryptedpass'])) {
            // Set session data
            session()->set('user_id', $result['user_id']);
            session()->set('firstname', $result['firstname']);
            session()->set('lastname', $result['lastname']);
            session()->set('emailaddress', $result['emailaddress']);
            session()->set('username', $result['username']);
            session()->set('usertype', $result['usertype']);
            session()->set('AdminLoggedIn', true);
    
            // Prepare response
            $response = [
                'success' => true,
                'redirect' => '/admin/dashboard', // Redirect URL upon successful login
                'message' => 'Login successful'
            ];
        } else {
            // Prepare response for invalid login
            $response = [
                'success' => false,
                'message' => 'Invalid login credentials'
            ];
        }
    
        // Return JSON response
        return $this->response->setJSON($response);
    }
}
