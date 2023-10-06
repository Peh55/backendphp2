<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_atendimento extends CI_Model {
    public function inserirAtendimento($codAtendimento, $descricao, $estatus){
        $sql = "insert into atendimento (cod_atendimento, descricao, estatus)
                velues ('$codAtendimento', '$descricao', '$estatus' )";

        $this->db->query($sql);

        if($this->db->affected_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg' => 'Atendimento cadastrado corretamente.');
        }else{
            $dados = array('codigo' => 2,
                           'msg' => 'Houve algum problema na inserção na tabela de Atendimento.');
        }

        return $dados;

    }

    public function consultarAtendimento($codAtendimento, $descricao, $estatus, $ra){
        $sql = "select * from atendimento
                where estatus = '$estatus' ";

        if(trim($codAtendimento) != '' && trim($codAtendimento) != '0'){
            $sql = $sql . "and cod_atendimento = '$codAtendimento' ";
        }

        if(trim($ra) != '' && trim($ra) != '0'){
            $sql = $sql . "and ra = '$ra' ";
        }

        if(trim($descricao) != ''){
            $sql = $sql . "and descricao like '%$descricao' ";
        }

        $retorno = $this->db->query($sql);

        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg' => 'Consulta efetuada com sucesso.',
                           'dados' => $retorno->result());
        }else{
            $dados = array('codigo' => 2,
                           'msg' => 'Dados não encontrados.');
        }

        return $dados;
    }

    public function alterarAtendimento($codAtendimento, $descricao){
        $retornoAtendimento = $this->consultarAtendimento($codAtendimento);

        if($retornoAtendimento['codigo'] == 1){
            $sql = "update atendimento set descricao = '$descricao'
                    where cod_atendimento = $codAtendimento";

            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 1,
                               'msg' => 'Descricao do atendimento atualizada corretamente.');
            }else{
                $dados = array('codigo' => 2,
                               'msg' => 'Houve algum problema na atualização na descricao do atendimento.');
            }
        }else{
            $dados = array('codigo' => 5,
                           'msg' => 'Codigo de Atendimento passado não está cadastrado na base de dados.');
        }
        return $dados;
    }

    public function apagarAtendimento($codAtendimento){
        $retornoAtendimento = $this->consultarAtendimento($codAtendimento);

        if($retornoAtendimento['codigo'] == 1){
            $sql = "update atendimento set estatus = '0'
                    where cod_atendimento = $codAtendimento";
            
            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 1,
                               'msg' => 'Atendimento desativado corretamente.');
            }else{
                $dados = array('codigo' => 2,
                               'msg' => 'Houve algum problema na desativação do curso.');
            }
        }else{
            $dados = array('codigo' => 5,
                           'msg' => 'O codigo do atendimento passado não está cadastrado na base de dados.');
        }

        return $dados;
    }
}

?>