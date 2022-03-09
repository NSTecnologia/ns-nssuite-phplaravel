<?php

namespace App\NsControllers\NFe\Eventos;

use App\NsControllers\Genericos\Genericos;

class DownloadEventoNFe{
    public function criarRequisicao($chNFe, $tpAmb, $tpDown, $tpEvento, $nSeqEvento){
        $campos = get_defined_vars();
        $req = new DownloadEventoNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function downloadEvento($conteudo, $caminho){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[DOWNLOAD_EVENTO_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/get/event');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);

        $ret = json_decode($ret->getBody(), true);

        if ($ret['status'] == 200){
            $nome = $ret['retEvento']['chNFe'] . '-procEven';
            if (array_key_exists('pdf', $ret)){
                $genericos->salvarPDF($caminho, $nome . '.pdf', $ret['pdf']);
            }
            if (array_key_exists('xml', $ret)){
                $genericos->salvarXML($caminho, $nome . '.xml', $ret['xml']);
            }
            if (array_key_exists('json', $ret)){
                $genericos->salvarJSON($caminho, $nome . '.json', $ret['json']);
            }
        }

        $genericos->gravarLinhaLog('[DOWNLOAD_EVENTO_NFE_FIM]');

        return $ret;
    }
}

?>