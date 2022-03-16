<?php

namespace App\NsControllers\CTe\Emissao;

use App\NsControllers\Genericos\Genericos;

class EmissaoCTe{
    public function emitir($conteudo, $tpConteudo, $modelo){
        $genericos = new Genericos;
        $url = '';

        $genericos->gravarLinhaLog('[EMISSAO_CTE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        switch($modelo == 57){
            case 57:
                $url = 'https://cte.ns.eti.br/cte/issue';
                break;
            case 67:
                $url = 'https://cte.ns.eti.br/cte/issueos';
                break;
            default:
                $ret = 'modelo invalido';
        }

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
        $genericos->gravarLinhaLog('[EMISSAO_CTE_FIM]');

        return $ret;
    }
}

?>