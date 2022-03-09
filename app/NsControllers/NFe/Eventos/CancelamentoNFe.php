<?php

namespace App\NsControllers\NFe\Eventos;

use App\NsControllers\Genericos\Genericos;

class CancelamentoNFe{
    public function criarRequisicao($chNFe, $tpAmb, $dhEvento, $nProt, $xJust){
        $campos = get_defined_vars();
        $req = new CancelamentoNFe;
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

        $genericos->gravarLinhaLog('[CANC_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/cancel');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CANC_NFE_FIM]');

        return $ret;
    }

    public function cancelarEsalvar($conteudo, $caminho, $tpDown){
        $ret = $this->cancelar($conteudo);
        $cancRet = $ret['status'];

        if ($cancRet == 200){
            $download = new DownloadEventoNFe;
            $download->chNFe = $ret['retEvento']['chNFe'];
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