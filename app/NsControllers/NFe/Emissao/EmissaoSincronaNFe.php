<?php

namespace App\NsControllers\NFe\Emissao;

use App\NsControllers\Genericos\Genericos;

class EmissaoSincronaNFe{
    public function emitirNFeSincrono($conteudo, $tpConteudo, $CNPJ, $tpAmb, $tpDown, $caminho){
        $genericos = new Genericos;
        
        $retorno = [];
        $retorno['emissaoStatus'] = '';
        $retorno['consultaStatus'] = '';
        $retorno['nsNRec'] = '';
        $retorno['cStat'] = '';
        $retorno['xMotivo'] = '';
        $retorno['chNFe'] = '';
        $retorno['nProt'] = '';
        $retorno['downloadStatus'] = '';
        $retorno['erros'] = '';

        $genericos->gravarLinhaLog('[EMISSAO_SINCRONA_NFE_INICIO]');

        $emissao = new EmissaoNFe;
        $emissaoRetorno = $emissao->emitir($conteudo, $tpConteudo);
        $emissaoStatus = $emissaoRetorno['status'];

        $retorno['emissaoStatus'] = $emissaoStatus;

        if ($emissaoStatus == 200){
            $consStatusProc = new ConsultaStatusNFe;
            $consStatusProc->CNPJ = $CNPJ;
            $consStatusProc->nsNRec = $emissaoRetorno['nsNRec'];

            $consultaRetorno = $consStatusProc->consultarStatus($consStatusProc);
            $consultaStatus = $consultaRetorno['status'];

            $retorno['consultaStatus'] = $consultaStatus;
            $retorno['nsNRec'] = $emissaoRetorno['nsNRec'];

            if ($consultaStatus == 200){
                $cStat = $consultaRetorno['cStat'];

                $retorno['cStat'] = $cStat;
                $retorno['xMotivo'] = $consultaRetorno['xMotivo'];

                if ($cStat == 100){
                    $download = new DownloadNFe;
                    $download->chNFe = $consultaRetorno['chNFe'];
                    $download->tpAmb = $tpAmb;
                    $download->tpDown = $tpDown;

                    $downloadRetorno = $download->download($download, $caminho);
                    $downloadStatus = $downloadRetorno['status'];
                    
                    $retorno['chNFe'] = $consultaRetorno['chNFe'];
                    $retorno['nProt'] = $consultaRetorno['nProt'];
                    $retorno['downloadStatus'] = $downloadStatus;

                    if ($downloadStatus != 200){
                        $retorno['erros']['downloadRetorno'] = json_decode($downloadRetorno);
                    }
                }
            }
            else {
                $retorno['erros']['consultaRetorno'] = json_decode($consultaRetorno);
            }
        }
        else {
            $retorno['erros']['emissaoRetorno'] = json_decode($emissaoRetorno);
        }

        $genericos->gravarLinhaLog('[RETORNO_EMISSAO_SINCRONA]');
        $genericos->gravarLinhaLog(json_encode($retorno));
        $genericos->gravarLinhaLog('[EMISSAO_SINCRONA_NFE_FIM]');

        return json_encode($retorno);
    }
}

?>