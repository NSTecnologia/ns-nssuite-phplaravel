<?php

namespace App\NsControllers\CTe\Emissao;

use App\NsControllers\Genericos\Genericos;

class ConsultaStatusCTe{
    public function criarRequisicao($CNPJ, $nsNRec, $tpAmb){
        $campos = get_defined_vars();
        $req = new ConsultaStatusCTe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function consultarStatus($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[CONSULTA_STATUS_CTE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://cte.ns.eti.br/cte/issueStatus/300');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CONSULTA_STATUS_CTE_FIM]');

        return $ret;
    }
}

?>