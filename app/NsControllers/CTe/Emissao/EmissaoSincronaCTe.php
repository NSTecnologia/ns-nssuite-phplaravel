<?php

namespace App\NsControllers\CTe\Emissao;

use App\NsControllers\Genericos\Genericos;

class EmissaoSincronaCTe{
    public function emitirCTeSincrono($conteudo, $tpConteudo, $modelo, $CNPJ, $tpAmb, $tpDown, $caminho){
        $genericos = new Genericos;
        
        $retorno = [];
        $retorno['emissaoStatus'] = '';
        $retorno['consultaStatus'] = '';
        $retorno['nsNRec'] = '';
        $retorno['cStat'] = '';
        $retorno['xMotivo'] = '';
        $retorno['chCTe'] = '';
        $retorno['nProt'] = '';
        $retorno['downloadStatus'] = '';
        $retorno['erros'] = '';

        $genericos->gravarLinhaLog('[EMISSAO_SINCRONA_CTE_INICIO]');

        $emissao = new EmissaoCTe;
        $emissaoRetorno = $emissao->emitir($conteudo, $tpConteudo, $modelo);
        $emissaoStatus = $emissaoRetorno['status'];

        $retorno['emissaoStatus'] = $emissaoStatus;

        if ($emissaoStatus == 200){
            $consStatusProc = new ConsultaStatusCTe;
            $consStatusProc->CNPJ = $CNPJ;
            $consStatusProc->nsNRec = $emissaoRetorno['nsNRec'];
            $consStatusProc->tpAmb = $tpAmb;

            $consultaRetorno = $consStatusProc->consultarStatus($consStatusProc);
            $consultaStatus = $consultaRetorno['status'];

            $retorno['consultaStatus'] = $consultaStatus;
            $retorno['nsNRec'] = $emissaoRetorno['nsNRec'];

            if ($consultaStatus == 200){
                $cStat = $consultaRetorno['cStat'];

                $retorno['cStat'] = $cStat;
                $retorno['xMotivo'] = $consultaRetorno['xMotivo'];

                if ($cStat == 100){
                    $download = new DownloadCTe;
                    $download->chCTe = $consultaRetorno['chCTe'];
                    $download->tpAmb = $tpAmb;
                    $download->tpDown = $tpDown;
                    $download->CNPJ = $CNPJ;

                    $downloadRetorno = $download->download($download, $caminho);
                    $downloadStatus = $downloadRetorno['status'];
                    
                    $retorno['chCTe'] = $consultaRetorno['chCTe'];
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
        $genericos->gravarLinhaLog('[EMISSAO_SINCRONA_CTE_FIM]');

        return json_encode($retorno);
    }
}

?>