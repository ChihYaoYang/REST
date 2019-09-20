<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Usuario extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }
    public function usuario_get() {
        $data = $this->User_model->get();
        $this->set_response($data,REST_Controller_Definitions::HTTP_OK);
    }
    public function usuario_post() {
        if ((!$this->post('nome')) || (!$this->post('senha')) || (!$this->post('nivel'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->post('nome'),
            'senha' => $this->post('senha'),
            'nivel' => $this->post('nivel')
        );
        if($this->User_model->insert($data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Usuário inserido com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir usuário'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function usuario_delete($id) {
        if($id > 0) {
            if($this->User_model->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Usuário deletado com successo !'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao deletar usuário'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao deletar usuário'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function usuario_put($id) {
        if ((!$this->put('nome')) || (!$this->put('senha')) || (!$this->put('nivel'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->put('nome'),
            'senha' => $this->put('senha'),
            'nivel' => $this->put('nivel')
        );
        if ($this->User_model->update($id, $data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Usuário alterado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar usuário'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}

?>