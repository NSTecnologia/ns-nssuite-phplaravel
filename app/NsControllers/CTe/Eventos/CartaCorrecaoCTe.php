<?php

namespace App\NsControllers\CTe\Eventos;

use App\NsControllers\Genericos\Genericos;

class infCorrecao{}

class CartaCorrecaoCTe{
    public function infCorrecao($grupoAlterado, $campoAlterado, $valorAlterado, $nroItemAlterado){
        $campos = get_defined_vars();
        $req = new infCorrecao;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }
    
    public function criarRequisicao($chCTe, $tpAmb, $dhEvento, $nSeqEvento, $infCorrecao){
        $campos = get_defined_vars();
        $req = new CartaCorrecaoCTe;
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

        $genericos->gravarLinhaLog('[CCE_CTE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://cte.ns.eti.br/cte/cce/300');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CCE_CTE_FIM]');

        return $ret;
    }

    public function corrigirEsalvar($conteudo, $caminho, $tpDown){
        $ret = $this->corrigir($conteudo);
        $cancRet = $ret['status'];

        if ($cancRet == 200){
            $download = new DownloadEventoCTe;
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