<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

class Users extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function index_get($id = null)
    {
        // Users from a data store e.g. database
        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            $users = $this->users_model->showAll()->result();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users)
            {
                // Set the response and exit
                $response = array(
                    'data' => $users,
                );
                $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {
            $id = (int) $id;
            $user = $this->users_model->getById($id)->row();
            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            //$user = NULL;

            if (!empty($users))
            {
                foreach ($users as $key => $value)
                {
                    if (isset($value['id']) && $value['id'] === $id)
                    {
                        $user = $value;
                    }
                }
            }

            if (!empty($user))
            {
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = array(
            'name' => $this->post('name'),
            'username' => $this->post('username'),
            'password' => md5($this->post('password'))
        );

        $dataUser = $this->users_model->getByUsername($this->post('username'))->row();
        $message = '';
        $success = 0;
        if ($dataUser == '') {
        
            $this->users_model->add($data);
            $message = 'User berhasil ditambahkan';
            $success = 1;
        }else{
            $message = 'Username sudah digunakan';
        }


        $message = [
            'data' => $data,
            'message' => $message,
            'success' => $success,
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post()
    {
        // $this->some_model->update_user( ... );
        $dataUser = $this->users_model->getById($this->post('id'))->row();
        $input = $this->post();
        
        if ($input['password'] == '') {
            
            $data = array(
                'name' => $this->post('name'),
                'username' => $this->post('username'),
            );
            $message = 'User Updated';
        }else{
            $data = array(
                'name' => $this->post('name'),
                'username' => $this->post('username'),
                'password' => md5($this->post('password'))
            );

            $message = 'User Updated and Password Changed';
        }

        $this->users_model->update($dataUser->id,$data);
        
        $success = 1;
        
        $response = [
            'message' => $message,
            'success' => $success,
        ];

        $this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {   
        $json = json_decode(file_get_contents('php://input'));
        
        $this->users_model->delete($json->id);
        $message = [
            'id' => $json->id,
            'message' => 'Deleted the resource',
            'error' => 0
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code
    }

}