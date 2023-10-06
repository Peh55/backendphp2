<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentacao extends CI_Controller{
private $json;
private $resultado;

private $semestreAno;
private $ra;
private $tcer;
private $tcenr;
private $descAtividades;
private $fichaValidEstagio;
private $relAtividades;
private $rescisao;
private $relEquivalencia;
private $observacoes;
private $estatus;

public function getSemestreAno(){
    return $this->semestreAno;
}
public function getRA(){
    return $this->ra;
}
public function getTcer(){
    return $this->tcer;
}
public function getTcenr(){
    return $this->tcenr;
}
public function getDescAtividades(){
    return $this->descAtividades;
}
public function getFichaValidEstagio(){
    return $this->fichaValidEstagio;
}
public function getRelAtividades(){
    return $this->relAtividades;
}
public function getRescisao(){
    return $this->rescisao;
}
public function getRelEquivalencia(){
    return $this->relEquivalencia;
}
public function getObservacoes(){
    return $this->observacoes;
}
public function getEstatus(){
    return $this->estatus;
}
public function setSemestreAno($semestreAnoFront){
    $this->semestreAno = $semestreAnoFront;
}
public function setRA($raFront){
    $this->ra = $raFront;
}
public function setTcer($tcerFront){
    $this->tcer = $tcerFront;
}
public function setTcenr($tcenrFront){
    $this->tcenr = $tcenrFront;
}
public function setDescAtividades($descAtividadesFront){
    $this->descAtividades = $descAtividadesFront;
}
public function setFichaValidEstagio($fichaValidEstagioFront){
    $this->fichaValidEstagio = $fichaValidEstagioFront;
}
public function setRelAtividades($relAtividadesFront){
    $this->relAtividades = $relAtividadesFront;
}
public function setRescisao($rescrisaoFront){
    $this->rescisao = $rescrisaoFront;
}
public function setRelEquivalencia($relEquivalenciaFront){
    $this->relEquivalencia = $relEquivalenciaFront;
}
public function setObservacoes($observacoesFront){
    $this->observacoes = $observacoesFront;
}
public function setEstatus($estatusFront){
    $this->estatus = $estatusFront;
}

public function inserirDocumentacao(){
    $json = file_get_contents('php://input');
    $resultado = json_decode($json);

    $lista = array("semestreAno" => '0',
                   "ra" => '0',
                   "tcer" => '0',
                   "tcenr" => '0',
                   "descAtividades" => '0',
                   "fichaValidEstagio" => '0',
                   "relAtividades" => '0',
                   "rescricao" => '0',
                   "relEquivalencia" => '0',
                   "observacoes" => '0',
                   "estatus" => '0');
    
    if(verificarParam($resultado, $lista) == 1){
        $this->setSemestreAno($resultado->semestreAno);
        $this->setRA($resultado->ra);
        $this->setTcer($resultado->tcer);
        $this->setTcenr($resultado->tcenr);
        $this->setDescAtividades($resultado->descAtividades);
        $this->setFichaValidEstagio($resultado->fichaValidEstagio);
        $this->setRelAtividades($resultado->relAtividades);
        $this->setRescisao($resultado->rescricao);
        $this->setRelEquivalencia($resultado->relEquivalencia);
        $this->setObservacoes($resultado->observacoes);
        $this->setEstatus($resultado->estatus);

        if(strlen($this->getSemestreAno() == 0)){
            $retorno = array('codigo' => 5,
                             'msg' => 'Semestre não está registrado');
        }elseif(trim($this->getRA()) == "" || $this->getRA() == 0){
            $retorno = array('codigo' => 3,
                             'msg' => 'RA do Aluno não informado ou zerado');
        }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
            $retorno = array('codigo' => 4,
                             'msg' => 'Status não condiz com o permitido');
        }else{
            $this->load->model('M_documentacao');
            $retorno = $this->M_documentacao->inserirDocumentacao($this->getSemestreAno(), $this->getRA(), $this->getTcer(), $this->getTcenr(), $this->getDescAtividades(), $this->getFichaValidEstagio(), $this->getRelAtividades(), $this->getRescisao(), $this->getRelEquivalencia(), $this->getObservacoes(), 
            $this->getEstatus());
        }
    }else{
        $retorno = array('codigo' => 99,
                         'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção,
                         verifique.');
    }

    echo json_decode($retorno);

}

public function consultarDocumentacao(){
    $json = file_get_contents('php://input');
    $resultado = json_decode($json);

    $lista = array("semestreAno" => '0',
                   "ra" => '0',
                   "tcer" => '0',
                   "tcenr" => '0',
                   "descAtividades" => '0',
                   "fichaValidEstagio" => '0',
                   "relAtividades" => '0',
                   "rescisao" => '0',
                   "relEquivalencia" => '0',
                   "observacoes" => '0',
                   "estatus" => '0');
    
    if(verificarParam($resultado, $lista) == 1){
        $this->setSemestreAno($resultado->semestreAno);
        $this->setRA($resultado->ra);
        $this->setTcer($resultado->tcer);
        $this->setTcenr($resultado->tcenr);
        $this->setDescAtividades($resultado->descAtividades);
        $this->setFichaValidEstagio($resultado->fichaValidEstagio);
        $this->setRelAtividades($resultado->relAtividades);
        $this->setRescisao($resultado->rescisao);
        $this->setRelEquivalencia($resultado->relEquivalencia);
        $this->setObservacoes($resultado->observacoes);
        $this->setEstatus($resultado->estatus);

        if(trim($this->getRA()) == "" || $this->getRA() == 0){
            $retorno = array('codigo' => 3,
                             'msg' => 'RA do Aluno não informado ou zerado');
        }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
            $retorno = array('codigo' => 4,
                             'msg' => 'Status não condiz com o permitido');
        }else{
            $this->load->model('M_documentacao');
            $retorno = $this->M_documentacao->consultarDocumentacao($this->getSemestreAno(), $this->getRA(), $this->getTcer(), $this->getTcenr(), $this->getDescAtividades(), $this->getFichaValidEstagio(), $this->getRelAtividades(), $this->getRescisao(), $this->getRelEquivalencia(), $this->getObservacoes(), $this->getEstatus());
        }
    }else{
        $retorno = array('codigo' => 99,
                         'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção,
                         verifique.');
    }

    echo json_decode($retorno);

}

public function alterarDocumentacao(){
    $json = file_get_contents('php://input');
    $resultado = json_decode($json);

    $lista = array("semestreAno" => '0',
                   "ra" => '0',
                   "tcer" => '0',
                   "tcenr" => '0',
                   "descAtividades" => '0',
                   "fichaValidestagio" => '0',
                   "relAtividades" => '0',
                   "rescisao" => '0',
                   "relEquivalencia" => '0',
                   "observacoes" => '0',
                   "estatus" => '0');

    if(verificarParam($resultado, $lista) == 1){
        $this->setRA($resultado->ra);
        $this->setEstatus($resultado->estatus);

        if(strlen($this->getRA()) == 0){
            $retorno = array('codigo' => 3,
                             'msg' => 'RA do aluno não informado');
        }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
            $retorno = array('codigo' => 4,
                             'msg' => 'Status não condiz com o permitido.');
        }else{
            $this->load->model('M_documentacao');
            $retorno = $this->M_documentacao->alterarDocumentacao($this->getRA(), $this->getEstatus());
        }
    }else{
        $retorno = array('codigo' => 99,
                             'msg'    => 'Os campos vindos do FrontEnd não representa o método de consulta,
                                          verifique.');
    }

    echo json_encode($retorno);
}

public function apagarDocumentacao(){
    $json = file_get_contents('php://input');
    $resultado = json_decode($json);

    $lista = array("semestreAno" => '0',
                   "ra" => '0',
                   "estatus" => '0');

    if(verificarParam($resultado, $lista) == 1){
        $this->setSemestreAno($resultado->semestreAno);
        $this->setRA($resultado->ra);
        $this->setEstatus($resultado->estatus);

        if(trim($this->getSemestreAno()) == "" || getSemestreAno() == 0){
            $retorno = array('codigo' => 5,
                             'msg' => 'semestre não condiz com o permitido');
        }elseif(trim($this->getRA()) == "" || $this->getRA() == 0){
            $retorno = array('codigo' => 3,
                             'msg' => 'RA do Aluno não informado ou zerado');
        }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
            $retorno = array('codigo' => 4,
                             'msg' => 'Status não condiz com o permitido.');
        }else{
            $this->load->model('M_documentacao');
            $retorno = $this->M_documentacao->apagarDocumentacao($this->getSemestreAno(), $this->getRA(), $this->getEstatus());
        }
    }else{
        $retorno = array('codigo' => 99,
                         'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção,
                         verifique.');
    }

    echo json_decode($retorno);

}
}

?>
