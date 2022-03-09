<?php

namespace App\NsControllers\NFe\Emissao;

use App\NsControllers\Genericos\Genericos;

class DownloadNFe{
    public function criarRequisicao($chNFe, $printCEAN = null, $tpAmb = null, $tpDown, $obsCanhoto = null){
        $campos = get_defined_vars();
        $req = new DownloadNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function download($conteudo, $caminho){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[DOWNLOAD_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/get');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);

        $ret = json_decode($ret->getBody(), true);

        if ($ret['status'] == 200){
            $nome = $ret['chNFe'] . '-nfeProc';
            if (array_key_exists('pdf', $ret)){
                $genericos->salvarPDF($caminho, $nome . '.pdf', $ret['pdf']);
            }
            if (array_key_exists('xml', $ret)){
                $genericos->salvarXML($caminho, $nome . '.xml', $ret['xml']);
            }
            if (array_key_exists('nfeProc', $ret)){
                $genericos->salvarJSON($caminho, $nome . '.json', $ret['json']);
            }
        }

        $genericos->gravarLinhaLog('[DOWNLOAD_NFE_FIM]');

        return $ret;
    }
}

?>