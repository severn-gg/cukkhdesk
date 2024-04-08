<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Api\ApiModel;

class Api extends BaseController
{
    use ResponseTrait;

    // login api
    public function login()
    {
        // Get request body
        $requestBody = $this->request->getBody();
        $validation = \Config\Services::validation();
        $jsonData = json_decode($requestBody, true);

        // Validate JSON data
        if (!$jsonData || !isset($jsonData['username']) || !isset($jsonData['password'])) {
            return $this->failUnauthorized('Invalid username or password');
        }

        $username = $jsonData['username'];
        $password = $jsonData['password'];

        // Fetch user from database
        $morders = new ApiModel();
        $result = $morders->get('user', null, ['username' => $username]);

        if (!$result['status'] || empty($result['data'])) {
            return $this->failUnauthorized('User not found');
        }

        $userData = $result['data'][0];

        // Check if user is active
        if ($userData['active'] !== "1") {
            return $this->failUnauthorized('User belum di restui Admin!');
        }

        // Verify password
        if ($password !== $userData['password_hash']) {
            return $this->failUnauthorized('Incorrect password');
        }

        // Set session data
        $session = session();
        $sessionData = [
            'username'       => $userData['username'],
            'nama_pengguna'  => $userData['nama_pengguna'],
            'usergroup_id'   => $userData['usergroup_id'],
            'nomor_telepon' => $userData['nomor_telepon'],
            'jabatan'        => $userData['jabatan'],
            'kantor'         => $userData['kantor'],
        ];
        $session->set($sessionData);

        $response = [
            'status' => true,
            'message' => "Sukses Login",
            'data' => $sessionData
        ];
        return $this->respond($response, 200);
    }

    //insert jika manyertakan id adalah update
    public function insert()
    {
        // ambil data yang dikirimkan
        $requestBody = $this->request->getBody();
        $validation = \Config\Services::validation();
        $jsonData = json_decode($requestBody, true);

        if (empty($jsonData['table'])) {
            return $this->failServerError('No table specified');
        }

        $table = $jsonData['table'];

        switch ($table) {
            case "usergroup":
                // Validasi data
                $validation->setRules([
                    'nama_group' => 'required'
                ]);
                break;
            case "user":
                // Validasi data
                $validation->setRules([
                    'nama_pengguna' => 'required',
                    'username' => 'required',
                    'active' => 'required',
                    'password_hash' => 'required',
                    'usergroup_id' => 'required',
                    'nomor_telepon' => 'required',                    
                    'jabatan' => 'required',
                    'kantor' => 'required',
                ]);
                break;            
            case "tiketkategori":
                // Validasi data
                $validation->setRules([
                    'nama_kategori' => 'required',
                    'deskripsi' => 'required'
                ]);
                break;
            case "tiket":
                // Validasi data
                $validation->setRules([
                    'user_id' => 'required',
                    'tiketkategori_id' => 'required',
                    'status' => 'required',
                    'prioritas' => 'required',                    
                    'dibuat_pada' => 'required',
                    'deskripsi' => 'required',
                    'ditugaskan_user_id' => 'required',
                    'nama_file' => 'required',
                    'url_gambar' => 'required'
                ]);
                break;
            case "komentar":
                // Validasi data
                $validation->setRules([
                    'tiket_id' => 'required',
                    'user_id' => 'required',
                    'dibuat_pada' => 'required|valid_email',
                    'teks_komentar' => 'required'
                ]);
                break;
            default:
                return $this->failServerError('Salah inputan table!');
        }

        $id = isset($jsonData['id']) && !empty($jsonData['id']) ? (int)$jsonData['id'] : null;
        $data = $jsonData['data'][0];
        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }
        
        // Insert data ke database
        $partnerModel = new ApiModel();
        $result = $partnerModel->insert_table($data, $table, $id);

        // pengiriman response 
        if ($result === true && $id !== null) {
            return $this->respondCreated(['message' => 'Data Updated successfully']);
        } elseif ($result === true && $id === null) {
            return $this->respondCreated(['message' => 'Data Inserted successfully']);
        } else {
            return $this->fail($result);
        }
    }

    // get jika menyertakan ID, maka : select where
    public function get()
    {
        // ambil data yang dikirimkan
        $requestBody = $this->request->getBody();
        $jsonData = json_decode($requestBody, true);

        // cek jika data kosong
        if (empty($jsonData['table'])) {
            return $this->failServerError('Perlu mencantumkan nama Table!');
        }

        // menyimpan data kiriman ke dalam variable
        $table = $jsonData['table'];
        $id = isset($jsonData['id']) && !empty($jsonData['id']) ? (int)$jsonData['id'] : null;

        // inisialisasi model dan ambil data dari database
        $morders = new ApiModel();
        $result = $morders->get($table, $id);

        // pengiriman response 
        if ($result['status'] === true) {
            return $this->respond($result, 200);
        } else {
            return $this->respond($result, 404);
        }
    }

    public function delete()
    {
        // ambil data yang dikirimkan
        $requestBody = $this->request->getBody();
        $validation = \Config\Services::validation();
        $jsonData = json_decode($requestBody, true);

        // cek jika data kosong
        if (empty($jsonData['table'])) {
            return $this->failServerError('No table specified');
        }

        // tempatkan data ke dalam variable
        $table = $jsonData['table'];
        $id = (int)$jsonData['id'];

        // validasi nama table
        switch ($table) {
            case "usergroup":                
                break;
            case "user":                
                break;            
            case "tiketkategori":                
                break;
            case "tiket":                
                break;
            case "komentar":                
                break;
            default:
                return $this->failServerError('Salah inputan table!');
        }        
        
        // Delete data from the database
        $partnerModel = new ApiModel();
        $result = $partnerModel->delete_table($table, $id);

        // kirimkan response
        if ($result === true) {
            return $this->respondCreated(['message' => 'Data Successfully Deleted']);
        } else {
            return $this->fail($result);
        }
    }

}
