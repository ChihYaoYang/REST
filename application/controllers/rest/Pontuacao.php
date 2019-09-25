<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Pontuacao extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pontuacao_model', 'pt');
        date_default_timezone_set('America/Sao_Paulo');
    }
    public function index_get()
    {
        $id = (int) $this->get('id');
        if ($id <= 0) {
            $data = $this->pt->get();
        } else {
            $data = $this->pt->getOne($id);
        }
        $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
    }
    public function index_post()
    {
        if ((!$this->post('id_equipe')) || (!$this->post('id_prova')) || (!$this->post('id_usuario')) || (!$this->post('pontos'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_equipe' => $this->post('id_equipe'),
            'id_prova' => $this->post('id_prova'),
            'id_usuario' => $this->post('id_usuario'),
            'pontos' => $this->post('pontos'),
            'data_hora' => date('Y-m-d H:i:s')
        );
        if ($this->pt->insert($data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Pontuação inserido com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir Pontuação'
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
        if ($this->pt->delete($id)) {
            $this->set_response([
                'status' => true,
                'message' => 'pontuação deletado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao deletar pontuação'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        $id = (int) $this->get('id');
        if ((!$this->put('id_equipe')) || (!$this->put('id_prova')) || (!$this->put('id_usuario')) || (!$this->put('pontos')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'id_equipe' => $this->put('id_equipe'),
            'id_prova' => $this->put('id_prova'),
            'id_usuario' => $this->put('id_usuario'),
            'pontos' => $this->put('pontos'),
            'data_hora' => date('Y-m-d H:i:s')
        );
        if ($this->pt->update($id, $data)) {
            $this->set_response([
                'status' => true,
                'message' => 'pontuação alterado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar pontuação'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}
