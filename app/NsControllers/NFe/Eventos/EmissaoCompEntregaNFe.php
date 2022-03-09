<?php

namespace App\NsControllers\NFe\Eventos;

use App\NsControllers\Genericos\Genericos;

class EmissaoCompEntregaNFe{
    public function criarRequisicao($chNFe, $tpAmb, $dhEvento, $nSeqEvento, $verAplic, $dhEntrega, $nDoc, $xNome, $hashComprovante, $dhHashComprovante = null, $tpAutor, $latGPS = null, $longGPS = null){
        $campos = get_defined_vars();
        $req = new EmissaoCompEntregaNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function emitirComprovante($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[COMP_ENTREGA_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/compentrega');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[COMP_ENTREGA_NFE_FIM]');

        return $ret;
    }
}

?>