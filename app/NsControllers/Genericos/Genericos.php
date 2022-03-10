<?php

namespace App\NsControllers\Genericos;

use Illuminate\Support\Facades\Http;

class Genericos{
    function enviarConteudoParaAPI($conteudo, $tpConteudo, $url){
        $token = 'SEU_TOKEN_AQUI';

        $retorno = Http::withHeaders([
            'X-AUTH-TOKEN' => $token
        ])
        ->withBody($conteudo, $tpConteudo)
        ->post($url);

        return $retorno;
    }

    public function gravarLinhaLog($msg){
        $dir = '../log/';

        if (!is_dir($dir)){
            mkdir($dir, 0777, true);
        }

		date_default_timezone_set("America/Sao_Paulo");
		$arq = fopen($dir.date('Ymd').'.log', 'a+');
		$today = date('Y/m/d H:i:s');
	    $msg = sprintf("[%s][%s]: %s%s", $today, '55', $msg, PHP_EOL);
	    fwrite($arq, $msg);
	    fclose($arq);
    }

    public function salvarXML($caminho, $nome, $conteudo){
        if (!is_dir($caminho)){
            mkdir($caminho, 0777, true);
        }

        $localSalvar = $caminho . $nome;
        $xml = fopen($localSalvar, 'w+');
        fwrite($xml, $conteudo);
    }

    public function salvarPDF($caminho, $nome, $conteudo){
        if (!is_dir($caminho)){
            mkdir($caminho, 0777, true);
        }

        $localSalvar = $caminho . $nome;
        $pdf = fopen($localSalvar, 'w+');
        fwrite($pdf, base64_decode($conteudo));
    }

    public function salvarJSON($caminho, $nome, $conteudo){
        if (!is_dir($caminho)){
            mkdir($caminho, 0777, true);
        }

        $localSalvar = $caminho . $nome;
        $json = fopen($localSalvar, 'w+');
        fwrite($json, json_encode($conteudo));
    }
}

?>