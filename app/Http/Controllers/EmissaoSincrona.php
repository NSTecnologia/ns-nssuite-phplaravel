<?php

namespace App\Http\Controllers;

use App\NsControllers\NFe\COFINS;
use App\NsControllers\NFe\COFINSNT;
use App\NsControllers\NFe\Dest;
use App\NsControllers\NFe\Det;
use App\NsControllers\NFe\DetPag;
use App\NsControllers\NFe\Emissao\EmissaoSincronaNFe;
use App\NsControllers\NFe\Emit;
use App\NsControllers\NFe\EnderDest;
use App\NsControllers\NFe\EnderEmit;
use App\NsControllers\NFe\ICMS;
use App\NsControllers\NFe\ICMS00;
use App\NsControllers\NFe\ICMSTot;
use App\NsControllers\NFe\Ide;
use App\NsControllers\NFe\Imposto;
use App\NsControllers\NFe\InfNFe;
use App\NsControllers\NFe\NFe;
use App\NsControllers\NFe\NFeJSON;
use App\NsControllers\NFe\Pag;
use App\NsControllers\NFe\PIS;
use App\NsControllers\NFe\PISNT;
use App\NsControllers\NFe\Prod;
use App\NsControllers\NFe\Total;
use App\NsControllers\NFe\Transp;
use Illuminate\Http\Request;
include ('C:/projetos/LaravelTeste/laravel/app/NsControllers/NFe/NFeJSON.php');

class EmissaoSincrona{
    public function enviar(Request $request){
        $NFeJSON = new NFeJSON;
        $nfe = new NFe;
        $infNFe = new InfNFe;
        $ide = new Ide;
        $emit = new Emit;
        $enderEmit = new EnderEmit;
        $dest = new Dest;
        $enderDest = new EnderDest;
        $det = array();
        $detAux = new Det;
        $det[] = $detAux;
        $prod = new Prod;
        $imposto = new Imposto;
        $icms = new ICMS;
        $icms00 = new ICMS00;
        $pis = new PIS;
        $pisnt = new PISNT;
        $cofins = new COFINS;
        $cofinsnt = new COFINSNT;
        $total = new Total;
        $icmstot = new ICMSTot;
        $transp = new Transp;
        $pag = new Pag;
        $detPag = array();
        $detPagAux = new DetPag;
        $detPag[] = $detPagAux;
    
        $NFeJSON-> NFe = $nfe;
        $nfe-> infNFe = $infNFe;
        $infNFe-> versao = "4.00";
    
        $infNFe->ide = $ide;
        $ide->cUF = "43";
        $ide->natOp = "VENDA";
        $ide->mod = "55";
        $ide->serie = "Serie da nota";
        $ide->nNF = "Numero da nota";
        $ide->dhEmi = "2022-03-06T16:05:00-03:00";
        $ide->idDest = "1";
        $ide->tpNF = "1";
        $ide->cMunFG = "4303509";
        $ide->tpImp = "0";
        $ide->tpEmis = "1";
        $ide->tpAmb = "2";
        $ide->finNFe = "1";
        $ide->procEmi = "0";
        $ide->verProc = "4.00";
        $ide->indFinal = "1";
        $ide->indPres = "0";
        
        $infNFe->emit = $emit;
        $emit->CNPJ = "CNPJ_EMITENTE";
        $emit->xNome = "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        $emit->IE = "IE_EMITENTE";
        $emit->CRT = "2";
        $emit->enderEmit = $enderEmit;
        $enderEmit->xLgr = "AV.ANTONIO DURO";
        $enderEmit->nro = "870";
        $enderEmit->xBairro = "OLARIA";
        $enderEmit->cMun = "4303509";
        $enderEmit->xMun = "CAMAQUA";
        $enderEmit->UF = "RS";
        $enderEmit->CEP = "96785192";
    
        $infNFe->dest = $dest;
        $dest->CNPJ = "CNPJ_DESTINATARIO";
        $dest->xNome = "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        $dest->IE = "IE_DESTINATARIO";
        $dest->indIEDest = "9";
        $dest->enderDest = $enderDest;
        $enderDest->xLgr = "AV.ANTONIO DURO";
        $enderDest->nro = "870";
        $enderDest->xBairro = "OLARIA";
        $enderDest->cMun = "4303509";
        $enderDest->xMun = "CAMAQUA";
        $enderDest->UF = "RS";
        $enderDest->CEP = "96785192";
    
        $infNFe->det = $det;
        $detAux->nItem = 1;
        $detAux->prod = $prod;
        $prod->cProd = "01234567";
        $prod->cEAN = "SEM GTIN";
        $prod->xProd = "IPHONE DA XIOME";
        $prod->NCM = "85287200";
        $prod->CFOP = "5111";
        $prod->uCom = "UN";
        $prod->qCom = "5.0000";
        $prod->vUnCom = "10.00";
        $prod->vProd = "50.00";
        $prod->cEANTrib = "SEM GTIN";
        $prod->uTrib = "UN";
        $prod->qTrib = "5.0000";
        $prod->vUnTrib = "10.00";
        $prod->indTot = "1";
    
        $detAux->imposto = $imposto;
    
        $imposto->ICMS = $icms;
        $icms->ICMS00 = $icms00;
        $icms00->orig = "0";
        $icms00->CST = "00";
        $icms00->modBC = "3";
        $icms00->vBC = "50.00";
        $icms00->pICMS = "12.00";
        $icms00->vICMS = "6.00";
        $icms00->pFCP = "2.00";
        $icms00->vFCP = "1.00";
    
        $imposto->PIS = $pis;
        $pis->PISNT = $pisnt;
        $pisnt->CST = "04";
    
        $imposto->COFINS = $cofins;
        $cofins->COFINSNT = $cofinsnt;
        $cofinsnt->CST = "04";
        
        $infNFe->total = $total;
        $total->ICMSTot = $icmstot;
        $icmstot->vBC = "50.00";
        $icmstot->vICMS = "6.00";
        $icmstot->vBCST = "0.00";
        $icmstot->vST = "0.00";
        $icmstot->vProd = "50.00";
        $icmstot->vFrete = "0.00";
        $icmstot->vSeg = "0.00";
        $icmstot->vDesc = "0.00";
        $icmstot->vII = "0.00";
        $icmstot->vIPI = "0.00";
        $icmstot->vPIS = "0.00";
        $icmstot->vCOFINS = "0.00";
        $icmstot->vOutro = "0.00";
        $icmstot->vNF = "50.00";
        $icmstot->vICMSDeson = "0.00";
        $icmstot->vFCPUFDest = "0.00";
        $icmstot->vICMSUFDest = "0.00";
        $icmstot->vICMSUFRemet = "0.00";
        $icmstot->vFCP = "1.00";
        $icmstot->vFCPST = "0.00";
        $icmstot->vFCPSTRet = "0.00";
        $icmstot->vIPIDevol = "0.00";
    
        $infNFe->transp = $transp;
        $transp->modFrete = "9";
    
        $infNFe->pag = $pag;
        $pag->detPag = $detPag;
        $pag->vTroco = "0.00";
        $detPagAux->indPag = "0";
        $detPagAux->tPag = "90";
        $detPagAux->vPag = "0.00";
        $detPag[] = $detPagAux;
    
        $conteudo = json_encode($NFeJSON, JSON_UNESCAPED_UNICODE);
        if ($request->input('modelo') == 55){
            $emissao = new EmissaoSincronaNFe;
            return $emissao->emitirNFeSincrono($conteudo, 'json', 'CNPJ_EMITENTE', '2', 'XP', 'Caminho para salvar');
        }
    }
}

?>