<?php

namespace App\Http\Controllers;

use App\NsControllers\NFe\Eventos\CancelamentoNFe;
use Illuminate\Http\Request;

class Cancelar{
    public function enviar(Request $request){
        if ($request->input('modelo') == 55){
            $consulta = new CancelamentoNFe;
            $conteudo = $consulta->criarRequisicao($request->input('chNFe'), '2', $request->input('dhEvento'), $request->input('nProt'), $request->input('xJust'));
            if ($request->input('salvar') == true){
                return $consulta->cancelarEsalvar($conteudo, 'Caminho para salvar', 'XP');
            }
            else{
                echo $consulta->cancelar($conteudo);
            }
        }
    }
}

?>