<?php

namespace App\NsControllers\NFe\Util;

use App\NsControllers\Genericos\Genericos;

class GerarXMLNFe{
    public function gerarXML($conteudo, $tpConteudo){
        $genericos = new Genericos;

        $genericos->gravarLinhaLog('[GERAR_XML_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        if ($tpConteudo == 'json'){
            $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/util/generatexml');
        }
        else if ($tpConteudo == 'xml'){
            $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/xml', 'https://nfe.ns.eti.br/util/generatexml');
        }
        else if ($tpConteudo == 'txt'){
            $ret = $genericos->enviarConteudoParaAPI($conteudo, 'text/plain;charset=utf-8', 'https://nfe.ns.eti.br/util/generatexml');
        }
        else{
            $ret = 'tpConteudo invalido';
        }

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[GERAR_XML_NFE_FIM]');

        return $ret;
    }
}

?>