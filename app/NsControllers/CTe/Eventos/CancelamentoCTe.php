<?php

namespace App\NsControllers\CTe\Eventos;

use App\NsControllers\Genericos\Genericos;

class CancelamentoCTe{
    public function criarRequisicao($chCTe, $tpAmb, $dhEvento, $nProt, $xJust){
        $campos = get_defined_vars();
        $req = new CancelamentoCTe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function cancelar($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[CANC_CTE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://cte.ns.eti.br/cte/cancel/300');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CANC_CTE_FIM]');

        return $ret;
    }

    public function cancelarEsalvar($conteudo, $caminho, $tpDown){
        $ret = $this->cancelar($conteudo);
        $cancRet = $ret['status'];

        if ($cancRet == 200){
            $download = new DownloadEventoCTe;
            $download->chCTe = $ret['retEvento']['chCTe'];
            $download->tpAmb = $conteudo->tpAmb;
            $download->tpDown = $tpDown;
            $download->tpEvento = 'CANC';
            $download->nSeqEvento = '1';
        
            $downloadRet = $download->downloadEvento($download, $caminho);

            return $downloadRet;
        }
        else {
            return $ret;
        }
    }
}

?>