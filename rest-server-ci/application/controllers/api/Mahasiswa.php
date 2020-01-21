<?php 

    
    use Restserver\Libraries\REST_Controller;
    defined('BASEPATH') OR exit('No direct script access allowed');
        
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';

    class Mahasiswa extends REST_Controller {
    
        public function __construct(){
            parent::__construct();
            $this->load->model('Mahasiswa_model','mahasiswa');
        }

        public function index_get(){
            
            $id = $this->get('id');
            
            if ($id == null) {
                # code...
                $mahasiswa = $this->mahasiswa->getMahasiswa();
            }else{
                $mahasiswa = $this->mahasiswa->getMahasiswa($id);

            }
            // penamaan  pengganti nama model = mahasiswa
            
            // Jika id tidak dipilih

            if($mahasiswa){
                $this->response([
                    'status' => true,
                    'data' => $mahasiswa
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Ngga ada'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }

        }

        // Hapus data
        public function index_delete(){
            $id = $this->delete('id');

            // Jika id tidak dipilih
            if ($id == null) {
                # code...
                $this->response([
                    'status' => false,
                    'message' => 'id belum dipilih'
                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            
            // cek id di database
            }else{
                
                if ($this->mahasiswa->deleteMahasiswa($id) > 0) {
                    # code...
                    // kondisi id terhapus
                    $this->response([
                        'status' => true,
                        'id' => $id,
                        'message' => 'id yang dipilih berhasil dihapus'
                    ], REST_Controller::HTTP_NO_CONTENT); // NOT_FOUND (404) being the HTTP response code
    
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'id tidak ada'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
    
                }
            }
        }

        // tambah Data
        public function index_post(){
            $data = [
                'nrp' => $this->post('nrp'),
                'nama' => $this->post('nama'),
                'email' => $this->post('email'),
                'jurusan' => $this->post('jurusan')
                
            ];

            if ($this->mahasiswa->createMahasiswa($data) > 0) {

                $this->response([
                    'status' => TRUE,
                    'message' => 'data mahasiswa ditambah'
                ], REST_Controller::HTTP_CREATED); // NOT_FOUND (404) being the HTTP response code

            }else{
                $this->response([
                    'status' => false,
                    'message' => 'data gagal ditambah'
                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code

            }
        }

        // Edit Data
        public function index_put()
        {
            # code...
            $id = $this->put('id');
            
            $data = [
                'nrp' => $this->put('nrp'),
                'nama' => $this->put('nama'),
                'email' => $this->put('email'),
                'jurusan' => $this->put('jurusan')
                
            ];

            if ($this->mahasiswa->updateMahasiswa($data, $id) > 0) {

                $this->response([
                    'status' => TRUE,
                    'message' => 'data mahasiswa diubah'
                ], REST_Controller::HTTP_NO_CONTENT); // NOT_FOUND (404) being the HTTP response code

            }else{
                $this->response([
                    'status' => false,
                    'message' => 'data gagal diubah'
                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code

            }
        }
    
    }
    
    /* End of file Mahasiswa.php */
    