<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_aluno.php");
include_once("M_curso.php");

class M_professor extends CI_Model {
    public function inserirProfessor($idProfessor, $nome, $usuario, $senha, $estatus){
        
        $sql = "insert into professor(nome,usuario, senha)
                values ('$nome','$usuario','$senha')";

        $this->db->query($sql);

        if($this->db->affected_rows() > 0){
            $dados = array('codigo' => 1, 
                           'msg'    => 'Professor cadastrado corretamente.');
        }else{
            $dados = array('codigo' => 2,
                           'msg'    => 'Houve algum problema na inserção na tabela de professor');
        }
        return $dados;
    }

    public function consultarProfessor($idProfessor, $nome, $usuario, $senha, $estatus){
        $sql = "select * from professor
                where esstatus = '$estatus' ";

        if(trim($idProfessor != '') && trim($idProfessor) != '0'){
            $sql = $sql . "and idProfessor = '$idProfessor' ";
        }

        if(trim($nome) != ''){
            $sql . $sql . "and descricao like '%$nome%' ";
        }

        if(trim($usuario) != ''){
            $sql . $sql . "and descricao like '%$usuario%' ";
        }

        $retorno =  $this->db->query($sql);

        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg'    => 'Consulta efetuada com sucesso.',
                           'dados'  => $retorno->result());
        }else{
            $dados = array('codigo' => 2,
                           'msg'    => 'Dados não encontrados.');
        }
        return $dados;
    }

    public function alterarProfessor($idProfessor, $nome){
        $retornoProfessor = $this->consultarSoProfessor($idProfessor);

        if($retornoProfessor['codigo'] == 1){

            $sql = "update professor set nome = '$nome'
                    where id_professor = $idProfessor";

            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 1,
                               'msg'    => 'Professor atualizado com sucesso');
            }else{
                $dados = array('codigo' => 2,
                               'msg'    => 'Houve algum problema na atualização do professor');
            }
        }else{
            $dados = array('codigo' => 5, 
                           'msg'    => "O professor não está cadastrado na base de dados");
        }
        return $dados;
    }

    public function apagarProfessor($idProfessor){
        $retornoProfessor = $this->consultarSoProfessor($idProfessor);

        if($retornoProfessor['codigo'] == 1){
            $sql = "update professor set estatus = 'D'
                    where id_professor = $idProfessor";

        $this->db->query($sql);

        if($this->db->affected_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg'    => 'professor desativado corretamente');
        }else{
            $dados = array('codigo' => 2, 
                           'msg');
        }
        }
        return $dados;
    }
}
