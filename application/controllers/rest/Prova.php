<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Prova extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prova_model', 'pr');
    }
    public function index_get()
    {
        $id = (int) $this->get('id');
        if ($id <= 0) {
            $data = $this->pr->get();
        } else {
            $data = $this->pr->getOne($id);
        }
        $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
    }
    public function index_post()
    {
        if ((!$this->post('nome')) || (!$this->post('descricao')) || (!$this->post('num_int'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->post('nome'),
            'descricao' => $this->post('descricao'),
            'num_int' => $this->post('num_int')
        );
        if ($this->pr->insert($data)) {
            $this->set_response([
                'status' => true,
                'message' => 'prova inserido com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir prova'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function index_delete()
    {
        $id = (int) $this->get('id');
        if ($id <= 0) {
            $this->set_response([
                'status' => false,
                'error' => 'Parâmetros obrigatórios não fornecidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        if ($this->pr->delete($id)) {
            $this->set_response([
                'status' => true,
                'message' => 'prova deletado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao deletar prova'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        $id = (int) $this->get('id');
        if ((!$this->put('nome')) || (!$this->put('descricao')) || (!$this->put('num_int')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->put('nome'),
            'descricao' => $this->put('descricao'),
            'num_int' => $this->put('num_int')
        );
        if ($this->pr->update($id, $data)) {
            $this->set_response([
                'status' => true,
                'message' => 'prova alterado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar prova'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}
