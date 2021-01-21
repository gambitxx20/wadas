<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

class Authenticate extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }


    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = array(
            'username' => $this->post('username'),
            'password' => md5($this->post('password'))
        );

        $dataUser = $this->users_model->userLogin($data['username'],$data['password'])->row();
        $message = '';
        $success = 0;

        if ($dataUser == '') {
            $success = 0;
            $message = 'User Not Found';
        }else{

            $success = 1;
            $message = 'Login Success';

            $data = array(
                'logged' => TRUE,
                'user_id' => $dataUser->id,
                'ip' => $this->input->ip_address(),
                    
             
            );
            $this->session->set_userdata($data);
        }
        $response = [
            'message' => $message,
            'success' => $success,
        ];

        $this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

}