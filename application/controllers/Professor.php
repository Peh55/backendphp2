<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Professor extends CI_Controller{

    //atributos de classe 
    private $json;
    private $resultado;

    //Atributos privados da classe
    private $idProfessor;
    private $nome;
    private $usuario;
    private $senha;
    private $estatus;

    //Getters dos atributos 
    public function getIdProfessor(){
        return $this->idProfessor;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getUsuario(){
        return $this->usuario;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function getEstatus(){
        return $this->estatus;
    }
    public function setIdProfessor($idProfessorFront){
        $this->idProfessor = $idProfessorFront;
    }
    public function setNome($nomeFront){
        $this->nome = $nomeFront;
    }
    public function setUsuario($usuarioFront){
        $this->usuario = $usuarioFront;
    }
    public function setSenha($senhaFront){
        $this->senha = $senhaFront;
    }
    public function setEstatus($estatusFront){
        $this->estatus = $estatusFront;
    }

    public function inserirProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idProfessor" => '0',
            "nome"        => '0',
            "usuario"     => '0',
            "senha"       => '0',
            "estatus"     => '0');

        if (verificarParam($resultado, $lista) == 1){
            $this->setIdProfessor($resultado->idProfessor);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if(strlen($this->getIdProfessor()) == 0){
                $retorno = array('codigo' => 3,
                                 'msg'    => 'id do professor não informado.');
            }elseif (strlen($this->getNome()) == 0){
                $retorno = array('codigo' => 4,
                                 'msg'    => 'Aluno não informado ou zerado.');
            }elseif ($this->getUsuario() == 0 || $this->getUsuario() == ''){
                $retorno = array('codigo' => 5,
                                 'msg'    => 'Dados não informados');
            }elseif ($this->getSenha() == 0 || $this->getSenha() == ''){
                $retorno = array('codigo' => 5,
                                 'msg'    => 'Dados não informados');
            }else{
                $this->load->model('M_professor');

                $retorno = $this->M_professor->alterarProfessor($this->getIdProfessor(), $this->getNome(), $this->getUsuario(), $this->getSenha(),
                                                                $this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg'    => 'Os campos vindos do FrontEnd não representam o método de inserção,
                              verifique.');
        }

        echo json_encode($retorno);
    }
    public function consultarProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idProfessor" => '0',
            "nome"        => '0',
            "usuario"     => '0',
            "senha"       => '0',
            "estatus"     => '0');
        
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdProfessor($resultado->idProfessor);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if($this->getEstatus() != "D" && $this->getEstatus() != ""){
                $retorno = array('codigo' => 4,
                                 'msg'    => 'Status não condiz com o permitido.');
            }else{
                $this->load->model('M_professor');
                $retorno = $this->M_professor->consultarProfessor($this->getIdProfessor(), $this->getNome(), $this->getUsuario(), $this->getSenha(),
                                                                  $this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg'    => 'Os campos vindos do FrontEnd não representa o método de consulta,
                                          verifique.');
        }

        echo json_encode($retorno);
    }
    public function alterarProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idProfessor" => '0',
            "nome"        => '0',
            "usuario"     => '0',
            "senha"       => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setIdProfessor($resultado->idProfessor);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);

            if(strlen($this->getIdProfessor()) == 0){
                $retorno = array('codigo' => 3,
                                 'msg'    => 'id professor não informado.');
            }elseif(strlen($this->getNome()) == 0){
                $retorno = array('codigo' => 4,
                                 'msg'    => 'nome professor não informado');
            }elseif($this->getUsuario() == "" || $this->getUsuario() == 0){
                $retorno = array('codigo' => 3,
                                 'msg'    => 'O usuario não foi informado ou zerado');
            }elseif($this->getSenha() == "" || $this->getSenha() == 0){
                $retorno = array('codigo' => 3,
                                 'msg'    => 'A senha não informada ou zerada');
            }else{
                $this->load->model('M_professor');
                $retorno = $this->M_professor->alterarProfessor($this->getIdprofessor(), $this->getNome(), $this->getUsuario(), $this->getSenha());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg'    => 'Os campos vindos do FrontEnd não representam o método de consulta,
                                          verifique.');
        }

        echo json_encode($retorno);

    }
    public function apagarProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array('idProfessor' => '0');

        if(verificarParam($resultado, $lista) == 1){

            $this->setIdprofessor($resultado->idProfessor);

            if ($this->getIdProfessor() == "" || $this->getIdProfessor() == 0){
                $retorno = array('codigo' => 3,
                                 'msg'    => 'id do professor não informado ou zerado');
            }else{
                $this->load->model('M_professor');
                $retorno = $this->M_professor->apagarProfessor($this->getIdProfessor());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg'    => 'Os campos vindos do FrontEnd não representam o método de consulta,
                              verifique.');
        }

        echo json_encode($retorno);

    }

    public function logarProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array ('usuario' => '0',
                        'senha' => '0',
                        'estatus' => '0');

        if(verificarParam($resultado, $lista) == 1){

            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if($this->getUsuario() == "" || $this->getUsuario() == 0){
                $retorno = array('codigo' => 3,
                                 'msg' => 'Usuario do professor não informado ou zerado.');
            }elseif($this->getSenha() == "" || $this->getSenha() == 0){
                $retorno = array('codigo' => 3,
                                 'msg' => 'Senha do professor não informada ou zerada.');
            }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
                $retorno = array('codigo' => 4,
                                 'msg' => 'Status não condiz com o permitido.');
            }else{
                $this->load->model('M_professor');
                $retorno = $this->M_professor->logarProfessor($this->getUsuario(), $this->getSenha());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta,
                              verifique.');
        }

        echo json_encode($retorno);

    }
    public function reativarProfessor(){}

}
?>