<?php

namespace App\NsControllers\NFe\Eventos;

use App\NsControllers\Genericos\Genericos;

class CartaCorrecaoNFe{
    public function criarRequisicao($chNFe, $tpAmb, $dhEvento, $nSeqEvento, $xCorrecao){
        $campos = get_defined_vars();
        $req = new CartaCorrecaoNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function corrigir($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[CCE_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/cce');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CCE_NFE_FIM]');

        return $ret;
    }

    public function corrigirEsalvar($conteudo, $caminho, $tpDown){
        $ret = $this->corrigir($conteudo);
        $cancRet = $ret['status'];

        if ($cancRet == 200){
            $download = new DownloadEventoNFe;
            $download->chNFe = $ret['retEvento']['chNFe'];
            $download->tpAmb = $conteudo->tpAmb;
            $download->tpDown = $tpDown;
            $download->tpEvento = 'CCE';
            $download->nSeqEvento = $conteudo->nSeqEvento;
        
            $downloadRet = $download->downloadEvento($download, $caminho);

            return $downloadRet;
        }
        else {
            return $ret;
        }
    }
}

?>