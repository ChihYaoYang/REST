<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Integrante extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Integrante_model','it');
    }
    public function index_get() {
        $id = (int) $this->get('id');
        if ($id <= 0) {
            $data = $this->it->get();
        } else {
            $data = $this->it->getOne($id);
        }
        $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
    }
    public function index_post() {
        if ((!$this->post('id_equipe')) || (!$this->post('nome')) || (!$this->post('data_nasc')) || (!$this->post('rg')) || (!$this->post('cpf'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_equipe' => $this->post('id_equipe'),
            'nome' => $this->post('nome'),
            'data_nasc' => $this->post('data_nasc'),
            'rg' => $this->post('rg'),
            'cpf' => $this->post('cpf')
        );
        if($this->it->insert($data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Integrante inserido com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir Integrante'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function index_delete() {
        $id = (int) $this->get('id');
        if ($id <= 0) {
            $this->set_response([
                'status' => false,
                'error' => 'Parâmetros obrigatórios não fornecidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
            if($this->it->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'integrante deletado com successo !'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao deletar integrante'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
       
    }
    public function index_put() {
        $id = (int) $this->get('id');
        if ( (!$this->put('id_equipe')) || (!$this->put('nome')) || (!$this->put('data_nasc')) || (!$this->put('rg')) || (!$this->put('cpf')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_equipe' => $this->put('id_equipe'),
            'nome' => $this->put('nome'),
            'data_nasc' => $this->put('data_nasc'),
            'rg' => $this->put('rg'),
            'cpf' => $this->put('cpf')
        );
        if ($this->it->update($id, $data)) {
            $this->set_response([
                'status' => true,
                'message' => 'integrante alterado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar integrante'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
      
    }
}
