<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atendimento extends CI_controller{

    private $json;
    private $resultado;

    private $codAtendimento;
    private $ra;
    private $idProfessor;
    private $descricao;
    private $estatus;

    public function getCodAtendimento(){
        return $this->codAtendimento;
    }
    public function getRA(){
        return $this->ra;
    }
    public function getIdProfessor(){
        return $this->idProfessor;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function getEstatus(){
        return $this->estatus;
    }
    public function setCodAtendimento($codAtendimentoFront){
        $this->codAtendimento = $codAtendimentoFront;
    }
    public function setRA($raFront){
        $this->ra = $raFront;
    }
    public function setIdProfessor($idProfessorFront){
        $this->idProfessor = $idProfessorFront;
    }
    public function setDescricao($descricaoFront){
        $this->descricao = $descricaoFront;
    }
    public function setEstatus($estatusFront){
        $this->estatus = $estatusFront;
    }
    public function inserirAtendimento(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codAtendimento" => '0',
                       "descricao" => '0',
                       "estatus" => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setDescricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            if(trim($this->getCodAtendimento()) == ""){
                $retorno = array('codigo' => 6, 
                                 'msg' => 'Atendimento não consta no sistema');
            }elseif(trim($this->getDescricao()) == ""){
                $retorno = array('codigo' => 3,
                                 'msg' => 'Descricao não informada.');
            }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
                $retorno = array('codigo' => 4,
                                 'msg' => 'Status não condiz com o permitido');
            }else{
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->inserirAtendimento($this->getCodAtendimento(),$this->getDescricao(), $this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção,
                                      verifique.');
        }

        echo json_encode($retorno);

    }

    public function consultarAtendimento(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codAtendiemento" => '0',
                       "ra" => '0',
                       "idProfessor" => '0',
                       "descricao" => '0',
                       "estatus" => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setRA($resultado->ra);
            $this->setIdProfessor($resultado->idProfessor);
            $this->setDescricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            if(trim($this->getCodAtendimento() < 1)){
                $retorno = array('codigo' => 4,
                                 'msg' => 'esse atendimento não existe');
            }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
                $retorno = array('codigo' => 4,
                                 'msg' => 'Status não condiz com o permitido.');
            }else{
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->consultarAtendimento($this->getCodAtendimento(), $this->getRA(), $this->getIdProfessor(), $this->getDescricao(), $this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta,
                             verifique.');
        }

        echo json_encode($retorno);
    }

    public function alterarAtendimento(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codAtendimento" => '0',
                       "descricao" => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setDescricao($resultado->descricao);

            if($this->getCodAtendimento() == "" || $this->getCodAtendimento() == 0){
                $retorno = array('codigo' => 3,
                                 'msg' => 'Codigo de atendimento não informado ou zerado.');
            }elseif(strlen($this->getDescricao()) == 0){
                $retorno = array('codigo' => 4,
                                 'msg' => 'Descricao do atendimento não informado.');
            }else{
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->alterarAtendimento($this->getCodAtendimento(), $this->getDescricao());            
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg' => 'Os campos vindos do FrontEnd não represnetam o método de consulta,
                                       verifique.');
        }

        echo json_encode($retorno);
    }
    
    public function apagarAtendimento(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codAtendimento" => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setCodAtendimento($resultado->codAtendimento);

            if($this->getCodAtendimento() == "" || $this->getCodAtendimento() == 0){
                $retorno = array('codigo' => 3,
                                 'msg' => 'codigo de Atendimento não informado ou zerado.');
            }else{
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->apagarAtendimento($this->getCodAtendimento());
            }
        }else{
            $retorno = array('codigo' => 99,
                             'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta,
                                       verifique.');
        }

        echo json_encode($retorno);
    }
}
?>
