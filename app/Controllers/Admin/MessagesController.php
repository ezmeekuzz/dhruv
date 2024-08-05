<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MessagesModel;

class MessagesController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'DHRUV Realty | Messages',
            'currentpage' => 'messages'
        ];
        return view('pages/admin/messages', $data);
    }
    public function getData()
    {
        return datatables('messages')->make();
    }
    public function delete($id)
    {
        $messagesModel = new MessagesModel();
        
        $deleted = $messagesModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the message from the database']);
        }
    }    
}
