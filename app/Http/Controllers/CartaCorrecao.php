<?php

namespace App\Http\Controllers;

use App\NsControllers\CTe\Eventos\CartaCorrecaoCTe;
use Illuminate\Http\Request;

class CartaCorrecao{
    public function enviar(Request $request){
        if ($request->input('modelo') == 57 || $request->input('modelo') == 67){
            $correcaoReq = new CartaCorrecaoCTe;

            $correcaoReq = $correcaoReq->criarRequisicao(
                'chCTe',
                'tpAmb',
                'dhEvento',
                'nSeqEvento', 
                [
                    $correcaoReq->infCorrecao('grupoAlterado', 'campoAlterado', 'valorAlterado', 'nroItemAlterado'), 
                    $correcaoReq->infCorrecao('grupoAlterado', 'campoAlterado', 'valorAlterado', 'nroItemAlterado')
                ]
            );
            
            if ($request->input('salvar') == true){
                return $correcaoReq->corrigirEsalvar($correcaoReq, 'Caminho para salvar', 'XP');
            }
            else{
                return $correcaoReq->corrigir($correcaoReq);
            }
        }
    }
}

?>