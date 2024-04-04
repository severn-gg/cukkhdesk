<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Api\ApiModel;

class Api extends BaseController
{
    use ResponseTrait;
    
    public function index()
    {
        //
    }

    public function insert()
    {
        // Get the incoming JSON data as an array
        $requestBody = $this->request->getBody();
        $validation = \Config\Services::validation();
        $jsonData = json_decode($requestBody, true);

        if (empty($jsonData['table'])) {
            return $this->failServerError('No table specified');
        }

        $table = $jsonData['table'];

        switch ($table) {
            case "user":
                // Validate incoming data    
                $validation->setRules([
                    'nama_pengguna' => 'required',
                    'password_hash' => 'required',
                    'usergroup_id' => 'required',
                    'nomor_telepon' => 'required',                    
                    'jabatan' => 'required',
                    'kantor' => 'required',
                ]);
                break;
            case "usergroup":
                // Validate incoming data    
                $validation->setRules([
                    'nama_group' => 'required'
                ]);
                break;
            case "kategoritiket":
                // Validate incoming data    
                $validation->setRules([
                    'nama_kategori' => 'required',
                    'deskripsi' => 'required'
                ]);
                break;
            case "tiket":
                // Validate incoming data    
                $validation->setRules([
                    'user_id' => 'required',
                    'kategori_id' => 'required',
                    'tgl_buat' => 'required',
                    'deskripsi' => 'required'
                ]);
                break;
            case "partner":
                // Validate incoming data    
                $validation->setRules([
                    'partner_name' => 'required',
                    'partner_type' => 'required',
                    'email' => 'required|valid_email',
                    'phone_number' => 'required',
                    'address' => 'required'
                ]);
                break;
            case "package":
                // Validate incoming data    
                $validation->setRules([
                    'package_name' => 'required',
                    'description' => 'required',
                    'price' => 'required',
                    'packagekategori_id' => 'required'
                ]);
                break;
            case "packagekategori":
                // Validate incoming data    
                $validation->setRules([
                    'kategori' => 'required',
                ]);
                break;
            case "percentage":
                // Validate incoming data    
                $validation->setRules([
                    'partner_id' => 'required',
                    'percentage' => 'required',
                ]);
                break;
            case "payment":
                // Validate incoming data    
                $validation->setRules([
                    'order_id' => 'required',
                    'amount' => 'required',
                    'payment_date' => 'required',
                    'payment_type' => 'required',
                ]);
                break;
            case "eventdetail":
                // Validate incoming data    
                $validation->setRules([
                    'order_id' => 'required',
                    'event_date' => 'required',
                    'event_address' => 'required',
                    'reception_address' => 'required',
                    'event_start_time' => 'required',
                ]);
                break;
            default:
                return $this->failServerError('Invalid table specified');
        }

        $id = isset($jsonData['id']) && !empty($jsonData['id']) ? (int)$jsonData['id'] : null;
        $data = $jsonData['data'][0];
        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        // Continue with your logic for each case
        // Insert data into the database
        $partnerModel = new ApiModel();
        $result = $partnerModel->insert_table($data, $table, $id);

        if ($result === true && $id !== null) {
            return $this->respondCreated(['message' => 'Data Updated successfully']);
        } elseif ($result === true && $id === null) {
            return $this->respondCreated(['message' => 'Data Inserted successfully']);
        } else {
            return $this->fail($result); // Include the error message
        }
    }

    public function get()
    {
        $requestBody = $this->request->getBody();
        $jsonData = json_decode($requestBody, true);

        if (empty($jsonData['table'])) {
            return $this->failServerError('Need specified the Table');
        }

        $table = $jsonData['table'];

        $id = isset($jsonData['id']) && !empty($jsonData['id']) ? (int)$jsonData['id'] : null;

        $morders = new ApiModel();

        $result = $morders->get($table, $id);

        if ($result['status'] === true) {
            return $this->respond($result, 200);
        } else {
            return $this->respond($result, 404);
        }
    }

    public function delete()
    {}

}
