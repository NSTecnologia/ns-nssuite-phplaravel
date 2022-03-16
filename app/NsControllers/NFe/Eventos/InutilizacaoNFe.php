<?php

namespace App\NsControllers\NFe\Eventos;

use App\NsControllers\Genericos\Genericos;

class InutilizacaoNFe{
    public function criarRequisicao($ano, $serie, $nNFIni, $nNFFin, $xJust,  $tpAmb, $CNPJ = null, $cUF = null){
        $campos = get_defined_vars();
        $req = new InutilizacaoNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function inutilizar($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[INUT_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/inut');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[INUT_NFE_FIM]');

        return $ret;
    }

    public function inutilizarEsalvar($conteudo, $caminho, $tpDown){
        $ret = $this->inutilizar($conteudo);
        $inutRet = $ret['status'];

        if ($inutRet == 200){
            $download = new DownloadInutNFe;
            $download->chave = $ret['retornoInutNFe']['chave'];
            $download->tpAmb = $conteudo->tpAmb;
            $download->tpDown = $tpDown;
        
            $downloadRet = $download->downloadInut($download, $caminho);

            return $downloadRet;
        }
        else {
            return $ret;
        }
    }
}

?>