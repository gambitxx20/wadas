<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

class Barang extends REST_Controller {

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
            $barang = $this->barang_model->showAll()->result();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($barang)
            {
                // Set the response and exit
                $response = array(
                    'data' => $barang,
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
            $barang = $this->barang_model->getById($id)->row();
            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            //$user = NULL;

            if (!empty($barang))
            {
                foreach ($barang as $key => $value)
                {
                    if (isset($value['id']) && $value['id'] === $id)
                    {
                        $barang = $value;
                    }
                }
            }

            if (!empty($barang))
            {
                $this->set_response($barang, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Barang tidak ditemukan'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = array(
            'nama' => $this->post('nama'),
            'SKU' => $this->post('sku'),
            'qty' => $this->post('qty'),
            'harga' => $this->post('harga'),
            'created_by' => $this->session->userdata('user_id'),
            'update_by' => $this->session->userdata('user_id')
        );

        $dataBarang = $this->barang_model->getByName($data['nama'])->row();
        $dataSKU = $this->barang_model->getBySKU($data['SKU'])->row();
        $message = '';
        $success = 0;
        if ($dataBarang == '' && $dataSKU == '') {
        
            $this->barang_model->add($data);
            $message = 'Barang berhasil ditambahkan';
            $success = 1;
        }else{
            $message = 'Nama Barang / SKU Barang sudah digunakan';
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
        $dataBarang = $this->barang_model->getById($this->post('id'))->row();
        $input = $this->post();
        $message = 'Barang berhasil diupdate';
        $success = 0;
        
        $data = array(
            'nama' => $this->post('nama'),
            'SKU' => $this->post('sku'),
            'qty' => $this->post('qty'),
            'harga' => $this->post('harga'),
            'update_by' => $this->session->userdata('user_id')
        );
        if ($dataBarang->nama != $data['nama']) {
            # code...
            $checkBarang = $this->barang_model->getByName($data['nama'])->row();
            if ($checkBarang == '') {
                $this->barang_model->update($dataBarang->id,$data);
                $success = 1;
            }else{
                $message = 'Nama Barang Sudah Digunakan';
            }
        }else{
            $this->barang_model->update($dataBarang->id,$data);
            $success = 1;
        }
        
        
        $dataBarang = $this->barang_model->getById($this->post('id'))->row();

        $response = [
            'data' => $dataBarang,
            'message' => $message,
            'success' => $success,
        ];

        $this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {   
        $json = json_decode(file_get_contents('php://input'));
        
        $this->barang_model->delete($json->id);
        $message = [
            'id' => $json->id,
            'message' => 'Barang berhasil dihapus',
            'error' => 0
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code
    }

}