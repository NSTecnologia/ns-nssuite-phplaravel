<?php

namespace App\NsControllers\NFe\Util;

use App\NsControllers\Genericos\Genericos;

class GerarPDFNFe{
    public function criarRequisicao($xml, $printCEAN = null, $obsCanhoto = null){
        $campos = get_defined_vars();
        $req = new GerarPDFNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function gerarPDF($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[GERAR_PDF_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/util/generatepdf');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[GERAR_PDF_NFE_FIM]');

        return $ret;
    }
}

?>