<?php

namespace App\NsControllers\NFe\Eventos;

use App\NsControllers\Genericos\Genericos;

class CancCompEntrega{
    public function criarRequisicao($chNFe, $tpAmb, $dhEvento, $nSeqEvento, $tpAutor, $verAplic, $dhEntrega, $nProtEvento){
        $campos = get_defined_vars();
        $req = new CancCompEntrega;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function cancelarComprovante($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[CANC_COMP_ENTREGA_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/nfe/compentregacanc');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[CANC_COMP_ENTREGA_NFE_FIM]');

        return $ret;
    }
}

?>