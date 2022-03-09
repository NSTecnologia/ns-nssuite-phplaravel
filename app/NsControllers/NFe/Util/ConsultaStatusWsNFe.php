<?php

namespace App\NsControllers\NFe\Util;

use App\NsControllers\Genericos\Genericos;

class ConsultaStatusWsNFe{
    public function criarRequisicao($CNPJCont, $UF, $tpAmb, $versao){
        $campos = get_defined_vars();
        $req = new ConsultaStatusWsNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }
    

    public function consultarStatusWS($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[CONS_WS_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/util/wssefazstatus');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CONS_WS_NFE_FIM]');

        return $ret;
    }
}

?>