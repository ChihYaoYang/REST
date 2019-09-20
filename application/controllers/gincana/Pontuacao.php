<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Pontuacao extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pontuacao_model','pt');
        date_default_timezone_set('America/Sao_Paulo');
    }
    public function pontuacao_get() {
        $data = $this->pt->get();
        $this->set_response($data,REST_Controller_Definitions::HTTP_OK);
    }
    public function pontuacao_post() {
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
        if($this->pt->insert($data)) {
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
    public function pontuacao_delete($id) {
        if($id > 0) {
            if($this->pt->delete($id)) {
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
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao deletar pontuação'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function pontuacao_put($id) {
        if ((!$this->put('id_equipe')) || (!$this->put('id_prova')) || (!$this->put('id_usuario')) || (!$this->put('pontos'))) {
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

?>