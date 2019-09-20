<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Equipe extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Equipe_model','eq');
    }
    public function equipe_get() {
        $data = $this->eq->get();
        $this->set_response($data,REST_Controller_Definitions::HTTP_OK);
    }
    public function equipe_post() {
        if((!$this->post('nome'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->post('nome')
        );
        if($this->eq->insert($data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Equipe inserido com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir equipe'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function equipe_delete($id) {
        if($this->eq->delete($id)) {
            $this->set_response([
                'status' => true,
                'message' => 'Equipe deletado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao deletar equipe'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    public function equipe_put($id) {
        if ((!$this->put('nome'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->put('nome')
        );
        if ($this->eq->update($id, $data)) {
            $this->set_response([
                'status' => true,
                'message' => 'Equipe alterado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar equipe'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}
?>