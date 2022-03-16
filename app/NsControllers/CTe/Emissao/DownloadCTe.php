<?php

namespace App\NsControllers\CTe\Emissao;

use App\NsControllers\Genericos\Genericos;

class DownloadCTe{
    public function criarRequisicao($chCTe, $tpDown, $CNPJ, $tpAmb){
        $campos = get_defined_vars();
        $req = new DownloadCTe;
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

        $genericos->gravarLinhaLog('[DOWNLOAD_CTE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://cte.ns.eti.br/cte/get/300');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);

        $ret = json_decode($ret->getBody(), true);

        if ($ret['status'] == 200){
            $nome = $ret['chCTe'] . '-cteProc';
            if (array_key_exists('pdf', $ret)){
                $genericos->salvarPDF($caminho, $nome . '.pdf', $ret['pdf']);
            }
            if (array_key_exists('xml', $ret)){
                $genericos->salvarXML($caminho, $nome . '.xml', $ret['xml']);
            }
            if (array_key_exists('nfeProc', $ret)){
                $genericos->salvarJSON($caminho, $nome . '.json', $ret['cteProc']);
            }
        }

        $genericos->gravarLinhaLog('[DOWNLOAD_CTE_FIM]');

        return $ret;
    }
}

?>