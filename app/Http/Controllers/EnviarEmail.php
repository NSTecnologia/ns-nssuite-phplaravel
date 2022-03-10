<?php

namespace App\Http\Controllers;

use App\NsControllers\NFe\Util\EnvioEmailNFe;
use Illuminate\Http\Request;

class EnviarEmail{
    public function enviar(Request $request){
        if ($request->input('modelo') == 55){
            $email = new EnvioEmailNFe;
            $conteudo = $email->criarRequisicao('Chave NFe', 'tpAmb', 'enviaEmailDoc', ['email1@email.com', 'email2@email.com']);
            
            return $email->enviarPorEmail($conteudo);
        }
    }
}

?>