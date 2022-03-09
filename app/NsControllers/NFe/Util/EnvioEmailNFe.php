<?php

namespace App\NsControllers\NFe\Util;

use App\NsControllers\Genericos\Genericos;

class EnvioEmailNFe{
    public function criarRequisicao($chNFe, $tpAmb, $enviaEmailDoc = null,  $email = null, $anexarPDF = null, $anexarEvento = null){
        $campos = get_defined_vars();
        $req = new EnvioEmailNFe;
        foreach ($campos as $campo => $valor){
            if ($valor != ''){
                $req->{$campo} = $valor;
            }
        }
        return $req;
    }

    public function enviarPorEmail($conteudo){
        $genericos = new Genericos;
        
        $conteudo = json_encode($conteudo, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[ENVIO_EMAIL_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($conteudo, 'application/json', 'https://nfe.ns.eti.br/util/resendemail');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[ENVIO_EMAIL_NFE_FIM]');

        return $ret;
    }
}

?>