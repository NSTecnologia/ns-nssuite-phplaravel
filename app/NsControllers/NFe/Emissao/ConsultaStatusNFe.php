<?php

namespace App\NsControllers\NFe\Emissao;

use App\NsControllers\Genericos\Genericos;

class ConsultaStatusNFe{
    public function criarRequisicao($CNPJ, $nsNRec, $tpAmb = null){
        $campos = get_defined_vars();
        $req = new ConsultaStatusNFe;
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

        $genericos->gravarLinhaLog('[CONSULTA_STATUS_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/issue/status');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CONSULTA_STATUS_NFE_FIM]');

        return $ret;
    }
}

?>