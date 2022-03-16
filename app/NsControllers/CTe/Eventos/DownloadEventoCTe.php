<?php

namespace App\NsControllers\CTe\Eventos;

use App\NsControllers\Genericos\Genericos;

class DownloadEventoCTe{
    public function criarRequisicao($chCTe, $tpAmb, $tpDown, $tpEvento, $nSeqEvento, $infCorrecao){
        $campos = get_defined_vars();
        $req = new DownloadEventoCTe;
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

        $genericos->gravarLinhaLog('[DOWNLOAD_EVENTO_CTE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://cte.ns.eti.br/cte/get/event/300');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);

        $ret = json_decode($ret->getBody(), true);

        if ($ret['status'] == 200){
            $nome = $ret['retEvento']['chCTe'] . '-procEven';
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

        $genericos->gravarLinhaLog('[DOWNLOAD_EVENTO_CTE_FIM]');

        return $ret;
    }
}

?>