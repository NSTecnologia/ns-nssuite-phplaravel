<?php

namespace App\NsControllers\NFe\Util;

use App\NsControllers\Genericos\Genericos;

class PreviaNFe{
    public function gerarPrevia($conteudo, $tpConteudo){
        $genericos = new Genericos;
        $url = 'https://nfe.ns.eti.br/util/preview/nfe';

        $genericos->gravarLinhaLog('[EMISSAO_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        switch($tpConteudo){
            case 'json':
                $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', $url);
                break;
            case 'xml':
                $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/xml', $url);
                break;
            case 'txt':
                $ret = $genericos->enviarConteudoParaAPI($conteudo, 'text/plain;charset=utf-8', $url);
                break;
            default:
                $ret = 'tpConteudo invalido';
                break;
        }

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[EMISSAO_NFE_FIM]');

        return $ret;
    }
}

?>