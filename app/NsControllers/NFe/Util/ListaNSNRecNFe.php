<?php

namespace App\NsControllers\NFe\Util;

use App\NsControllers\Genericos\Genericos;

class ListaNSNRecNFe{
    public function litarNSNRecs($chNFe){
        $genericos = new Genericos;
        
        $conteudo = json_encode($chNFe, JSON_UNESCAPED_UNICODE);

        $genericos->gravarLinhaLog('[LISTAR_NSNRECS_NFE_INICIO]');
        $genericos->gravarLinhaLog('[DADOS_ENVIADOS]');
        $genericos->gravarLinhaLog($conteudo);

        $ret = $genericos->enviarConteudoParaAPI($chNFe, 'application/json', 'https://nfe.ns.eti.br/util/list/nsnrecs');

        $genericos->gravarLinhaLog('[DADOS_RETORNADOS]');
        $genericos->gravarLinhaLog($ret);
        $genericos->gravarLinhaLog('[LISTAR_NSNRECS_NFE_FIM]');

        return $ret;
    }
}

?>