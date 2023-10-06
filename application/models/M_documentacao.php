<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class M_documentacao extends CI_Model{
    public function inserirDocumentacao($semestreAno,$ra,$tcer,$tcenr,$descAtividades,$fichaValidEstagio,$relAtividades,$rescisao,$relEquivalencia,$observacoes,$estatus){
        $sql = "insert into curso (semestre_ano, ra, tcer, tcenr, desc_atividades, ficha_valid_estagio, rel_atividades, rescisao, rel_equivalencia, observacoes, estatus)
                values ('$semestreAno','$ra', '$tcer', '$tcenr', '$descAtividades', '$fichaValidEstagio', '$relAtividades', '$rescisao', '$relEquivalencia', '$observacoes', '$estatus')";
                
                $this->db->query($sql);

                if($this->db->affected_rows() > 0){
                    $dados = array('codigo' => 1,
                                   'msg' => 'Documentação cadastrada corretamente.');
                }else{
                    $dados = array('codigo' => 2,
                                   'msg' => 'Houve algum problema na inserção na tabela de doumentacao.');
                }

                return $dados;
    }

    public function consultarDocumentacao($semestreAno,$ra,$tcer,$tcenr,$descAtividades,$fichaValidEstagio,$relAtividades,$rescisao,$relEquivalencia,$observacoes,$estatus){
        $sql = "select * from documentacao
                where estatus = '$estatus' ";
        
        if(($ra != '')){
            $sql = $sql . "and ra = '$ra' ";
        }

        if(trim($semestreAno) != '' && trim($semestreAno) != '0'){
            $sql = $sql . "and semestre_ano = '$semestreAno' ";
        }

        if(trim($tcer) != ''){
            $sql = $sql . "and tcer like '%$tcer%' ";
        }

        if(trim($tcenr) != ''){
            $sql = $sql . "and tcenr like '%$tcenr%' ";
        }

        if(trim($descAtividades) != ''){
            $sql = $sql . "and desc_atividades like '%$descAtividades' ";
        }

        if(trim($fichaValidEstagio) != ''){
            $sql = $sql . "and ficha_valid_estagio like '%$fichaValidEstagio' ";
        }

        if(trim($relAtividades) != ''){
            $sql = $sql . "and rel_atividades like '%$relAtividades";
        }

        if(trim($rescisao) != ''){
            $sql = $sql . "and rel_atividades like '%$rescisao' ";
        }

        if(trim($relEquivalencia) != ''){
            $sql = $sql . "and rel_equivalencia like '%$relEquivalencia' ";
        }

        if(trim($observacoes) != ''){
            $sql = $sql . "and observacoes like '%$observacoes' ";
        }

        return $dados;
    }

    public function alterarDocumentacao($semestreAno, $ra, $tcer, $tcenr, $descAtividades, $fichaValidEstagio, $relAtividades, $rescisao, $relEquivalencia, $observacoes, $estatus){
        $retorno = $atendimento->consultarAtendimento($ra);

        if($retorno['codigo'] == 1){
            $retorno = $this->db->consultarDocumentacao($ra);

            if($retorno['codigo'] == 1){
                $sql = "update documentacao set semestre_ano = '$semestreAno', tcer = '$tcer', tcenr = '$tcenr', desc_atividades, = '$descAtividades', ficha_valid_estagio = '$fichaValidEstagio', rel_atividades = '$relAtividades', rescisao = '$rescisao', rel_equivalencia = '$relEquivalencia', observacoes = '$observacoes' 
                        where estatus = '$estatus' ";
            }else{
                $dados = array('codigo' => 2,
                               'msg' => 'Houve algum problema na atualização na descrição da documentação'); 
            }
        }else{
            $dados = array('codigo' => 5,
                           'msg' => 'O Estatus ou semestreAno da documentação não está cadastrado na base de dados.');
        }
  return $dados;  
    }

    public function apagarDocumentacao($semestreAno, $ra, $estatus){
        $dados = $this->apagarDocumentacao($ra);

        if($retorno['codigo'] == 1){

            $sql = "update documentacao set estatus = 'D' 
                    where semestre_ano = '$semestreAno";

            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 1,
                               'msg' => 'Documentacao desativada corretamente.');
            }else{
                $dados = array('codigo' => 2,
                               'msg' => 'Houve algum problema na desativação da documentação');
            }
        }else{
            $dados = array('codigo' => 5,
                           'msg' => 'O semestre da documentação não está cadastrado na base de dados.');
        }
        return $dados;
    }
}
?>
