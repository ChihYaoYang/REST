<?php

/** 
 * Implementação da API REST usando a biblioteca do link abaixo
 * Essa biblioteca possui 4 arquivos distintos:
 * 1- REST_Controller na pasta libraries, que altera o comportamento padrão do Codeigniter
 * 2- REST_Controller_Definitions na pasta libraries, que tras algumas definições para o REST_Controller,
 * trabalha como um arquivo de padrões auxiliando o controller principal
 * 3- Format na pasta libraries, que faz o parsing(conversão) dos diferentes tipos de dados (JSON, XML, CSV e etc)
 * 4- rest.php na pasta config, para as configurações desta biblioteca
 * 
 * @author  Ryan Yang 
 * @link    https://github.com/chriskacerguis/codeigniter-restserver
 */

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class V1 extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Empresa_model','em');
    }
    //o nome dos método sempre vem acompanhado do tipo de requisição
    //ou seja, contato_get significa que é uma requisição do tipo GET
    //e o usuário vai requisitar apenas /contato EX:http://127.0.0.1/wssenac/rest/V1/contato
    public function contato_get()
    {
        $retorno = [
            'status' => true,
            'nome' => 'ryan',
            'telefone' => '01010101',
            'error' => ''
        ];
        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
    }

    public function usuario_get() {
        $id = (int) $this->get('id');
        $this->load->model('Usuario_model', 'us');
        if($id <= 0) {
            $data = $this->us->get();
        } else {
            $data = $this->us->getOne($id);
        }
        $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
    }
    //usuario_post significa que este método vai ser executado
    //quando os WS(web-service) receber uma requisição do tipo 
    //POST na url 'usuario'
    public function usuario_post()
    {
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->post('email')) || (!$this->post('senha'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'email' => $this->post('email'),
            'senha' => $this->post('senha'),
        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via POST
        $this->load->model('Usuario_model', 'us');
        if ($this->us->insert($data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Usuário inserido com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir usuário'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    //deletar
    public function usuario_delete() {
        $id = (int) $this->get('id');
        if ($id <= 0) {
            $this->set_response([
                'status' => false,
                'error' => 'Parâmetros obrigatórios não fornecidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $this->load->model('Usuario_model', 'us');
        if ($this->us->delete($id)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Usuário deletado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao deletar usuário'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    //usuario_post significa que este método vai ser executado
    //quando os WS(web-service) receber uma requisição do tipo 
    //PUT na url 'usuario'
    public function usuario_put() {
        $id = (int) $this->get('id');
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->put('email')) || (!$this->put('senha') || ($id <= 0))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'email' => $this->put('email'),
            'senha' => $this->put('senha'),
        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via PUT
        $this->load->model('Usuario_model', 'us');
        if ($this->us->update($id, $data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Usuário alterado com successo !'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar usuário'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}