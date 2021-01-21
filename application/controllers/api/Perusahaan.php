<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

class Perusahaan extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function index_get($id = null)
    {
        // Perusahaan from a data store e.g. database
        // If the id parameter doesn't exist return all the Perusahaan

        if ($id === NULL)
        {
            $Perusahaan = $this->perusahaan_model->showAll()->result();
            // Check if the Perusahaan data store contains Perusahaan (in case the database result returns NULL)
            if ($Perusahaan)
            {
                // Set the response and exit
                $response = array(
                    'data' => $Perusahaan,
                );
                $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Perusahaan were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {
            $id = (int) $id;
            $user = $this->perusahaan_model->getById($id)->row();
            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            //$user = NULL;

            if (!empty($Perusahaan))
            {
                foreach ($Perusahaan as $key => $value)
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
                    'message' => 'Perusahaan Tidak Ditemukan'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = array(
            'nama' => $this->post('nama'),
        );

        $dataPerusahaan = $this->perusahaan_model->getByName($data['nama'])->row();
        $message = '';
        $success = 0;
        if ($dataPerusahaan == '') {
        
            $this->perusahaan_model->add($data);
            $message = 'Perusahaan berhasil ditambahkan';
            $success = 1;
        }else{
            $message = 'Nama Perusahaan sudah digunakan';
        }


        $response = [
            'data' => $data,
            'message' => $message,
            'success' => $success,
        ];

        $this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post()
    {
        // $this->some_model->update_user( ... );
        $dataPerusahaan = $this->perusahaan_model->getById($this->post('id'))->row();
        $input = $this->post();
        
        $checkPerusahaan = $this->perusahaan_model->getByName($input['nama'])->row();
        $message = '';
        $success = 0;
        if ($checkPerusahaan == '') {
        
            $this->perusahaan_model->update($dataPerusahaan->id,$input);
            $message = 'Perusahaan berhasil diupdate';
            $success = 1;
        }else{
            $message = 'Nama Perusahaan sudah digunakan';
        }
        
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
        
        $this->perusahaan_model->delete($json->id);
        $message = [
            'id' => $json->id,
            'message' => 'Perusahaan Berhasil di-delete',
            'error' => 0
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code
    }

}