<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\UsersModel;

class UserMasterlistController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | User Masterlist',
            'currentpage' => 'usermasterlist'
        ];
        return view('pages/admin/usermasterlist', $data);
    }
    public function getData()
    {
        return datatables('users')->make();
    }
    public function delete($id)
    {
        $UsersModel = new UsersModel();
        $deleted = $UsersModel->delete($id);

        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the user from the database']);
        }
    }    
}
