# NSSuiteClientPHPLaravel

Utilizando a NS API, este exemplo - criado em PHP Laravel versão 8.x- possui funcionalidades para consumir documentos fiscais eletrônicos em geral, como por exemplo: 
+ NFe; 
+ CTe; 
+ NFCe;
+ MDFe;
+ BPe;

Obs.: Neste momento, apenas as funcionalidades para NFe e CTe estão disponíveis.

## Primeiros passos:

### Integrando ao sistema:

Para utilizar as funções de comunicação com a API, você precisa realizar os seguintes passos:

1. Extraia o conteúdo da pasta compactada que você baixou;
2. Copie para sua aplicação a pasta NsControllers para dentro de sua pasta app, na qual contem todos as classes que serão utilizadas;
3. Remova os projetos de documentos fiscais que você não utilizará, com exceção da pasta Genericos.

Pronto! Agora, você já pode consumir a NS Suite API através do seu sistema, basta importar os métodos que você deseja utlizar. As funcionalidades de cada documento fiscal se encontram nas pastas com seus respectivos nomes.

------

## Emissão Sincrona:

### Realizando uma Emissão Sincrona:

Para realizar uma emissão completa de uma NFe (utilizada para exemplo), você poderá utilizar a função emitirNFeSincrono da classe EmissaoSincronaNFe. Veja abaixo sobre os parâmetros necessários, e um exemplo de chamada do método.

##### Parâmetros:

**ATENÇÃO:** o **token** também é um parâmetro necessário e você deve, primeiramente, defini-lo na classe **Genericos.php**, como pode ver abaixo:

Parametros     | Descrição
:-------------:|:-----------
conteudo       | Conteúdo de emissão do documento.
tpConteudo     | Tipo de conteúdo que está sendo enviado. Valores possíveis: json, xml, txt
CNPJ           | CNPJ do emitente do documento.
tpDown         | Tipo de arquivos a serem baixados.Valores possíveis: <ul> <li>**X** - XML</li> <li>**J** - JSON</li> <li>**P** - PDF</li> <li>**XP** - XML e PDF</li> <li>**JP** - JSON e PDF</li> </ul> 
tpAmb          | Ambiente onde foi autorizado o documento.Valores possíveis:<ul> <li>1 - produção</li> <li>2 - homologação</li> </ul>
caminho        | Caminho onde devem ser salvos os documentos baixados.

##### Exemplo de chamada:

Após ter todos os parâmetros listados acima, você deverá fazer a chamada da função. Veja o código de exemplo abaixo:

      $retorno = $emissao->emitirNFeSincrono($conteudo, $tpConteudo, $cnpjEmit, $tpDown, $tpAmb, $caminho, $exibeNaTela);
      echo $retorno;

A função emitirNFeSincrono fará o envio, a consulta e download do documento, utilizando as funções emitirNFe, consultarStatus e download, presentes nas demais classes localizadas na pasta NFe\Emissao. Por isso, o retorno será um JSON com os principais campos retornados pelos métodos citados anteriormente. No exemplo abaixo, veja como tratar o retorno da função emitirNFeSincrono:

##### Exemplo de tratamento de retorno:

O JSON retornado pelo método terá os seguintes campos: emissaoStatus, consultaStatus, nsNRec, cStat, xMotivo, chNFe, nProt, downloadStatus. Veja o exemplo abaixo:

    {
		"emissaoStatus": "200",
        "consultaStatus": "200",
		"nsNRec": "313022",
        "cStat": "100",
		"xMotivo": "Autorizado o uso da NF-e",
        "chNFe": "43181007364617000135550000000119741004621864",
        "nProt": "143180007036833",
		"downloadStatus": "200",
    }
	
Se houver algum erro, será retornado um campo contendo o retorno do método aonde ocorreu tal erro.
      
Confira um código para tratamento do retorno, no qual pegará as informações dispostas no JSON de Retorno disponibilizado:


    $retorno = $emissao->emitirNFeSincrono($conteudo, $tpConteudo, $cnpjEmit, $tpDown, $tpAmb, $caminho, $exibeNaTela);

    $emissaoStatus = $resposta['emissaoStatus'];
    $consultaStatus = $resposta['consultaStatus'];
    $downloadStatus = $resposta['downloadStatus'];
    $cStat = $resposta['cStat'];
    $chNFe = $resposta['chNFe'];
    $nProt = $resposta['nProt'];
    $xMotivo = $resposta['xMotivo'];
    $nsNRec = $resposta['nsNRec'];
    $erros = $resposta['erros'];

    if ($emissaoStatus == 200 || $emissaoStatus == -6){
        if ($consultaStatus == 200){
            if ($cStat == 100){
                echo $xMotivo;
                if ($downloadStatus != 200){
                    echo 'Erro Download';
                }
            }else{
                echo $xMotivo;
            }
        }else{
            echo $xMotivo . '<br>' . $erros;
        }
    }else{
        echo $xMotivo . '<br>' . $erros;
    }
-----
## Criando uma Requisição:

Eventos e funções utilitárias são, em grande parte, enviados na forma de objetos para as funções. Então, para auxiliar na criação desse objeto, as classes dessas funções possuem uma outra função, chamada **criarRequisicao**, para auxiliar na criação da requisição. Veja abaixo como chamar a função criarRequisicaolasse, utilizando a classeEnvioPorEmailNFe.php como exemplo:

	$email = new EnvioEmailNFe;
    $emailReqNFe = $email->criarRequisicao($chNFe, $tpAmb, $enviaEmailDoc, ['exemplo1@email.com', 'exemplo2@email.com]);      

A função **criarRequisicao** retornará um objeto com os dados para a variável $emailReqNFe, que poderá ser enviada na função **enviarPorEmail**, onde será transformada em JSON e enviada para a API.

-----
## Cancelamento de Documento:

### Realizando um Cancelamento:

Utilizando NFe como exemplo para o cancelamento deve-se ter em mente que você deverá usar a função cancelarEsalvar da classe CancelamentoNFe. Veja abaixo sobre os parâmetros necessários, e um exemplo de chamada do método.

##### Parâmetros:

**ATENÇÃO:** o **token** também é um parâmetro necessário e você deve, primeiramente, defini-lo na classe **Genericos.php**, como pode ver abaixo:

Parametros     | Descrição
:-------------:|:-----------
conteudo       | Objeto contendo as informações de uma requisição de cancelamento de documento
caminho        | Caminho onde devem ser salvos os documentos baixados.
tpDown         | Tipo de arquivos a serem baixados.Valores possíveis: <ul> <li>**X** - XML</li> <li>**J** - JSON</li> <li>**P** - PDF</li> <li>**XP** - XML e PDF</li> <li>**JP** - JSON e PDF</li> </ul>

##### Exemplo de chamada:

Após ter todos os parâmetros listados acima, você deverá fazer a chamada da função. Veja o código de exemplo abaixo utilizando a função criarRequisicao para auxiliar na criação da requisição de cancelamento:

    $cancelarReqNFe = $Cancelamento->criarRequisicao($chNFe, $tpAmb, $dhEvento, $nProt, $xJust);

    $retorno = $Cancelamento->cancelarEsalvar($cancelarReqNFe, $caminho, $tpDown);
    
A função **cancelarEsalvar** fará o cancelamento da NFe que possa ser cancelada e o download do evento, utilizando as funções cancelar e download das classes CancelamentoNFe.php e DownloadEvento.php, respectivamente. Caso não ocorra erro no cancelamento, o retorno será o download realizado pelo método de download de evento da API, contendo:

##### Exemplo de retorno de cancelamento:

    {
      "status": 200,
      "motivo": "Consulta realizada com sucesso",
      "retEvento": {
        "cStat": "135",
        "xMotivo": "Evento registrado e vinculado a NF-e",
        "chNFe": "43161107364617000135550000000099341000094832",
        "dhRegEvento": "2016-11-29T19:15:42-02:00",
        "nProt": "143160001512983"
      },
      "xml": "..."
    }

-----

## Carta de Correção(CC):

### Realizando uma Correção de Documento:

Utilizando NFe como exemplo para a criação de uma carta de correção, deve-se ter em mente que você deverá usar a função corrigirEsalvar da classe CartaCorrecaoNFe. Veja abaixo sobre os parâmetros necessários, e um exemplo de chamada do método.

##### Parâmetros:

**ATENÇÃO:** o **token** também é um parâmetro necessário e você deve, primeiramente, defini-lo na classe **Genericos.php**, como pode ver abaixo:

Parametros     | Descrição
:-------------:|:-----------
conteudo       | Objeto contendo as informações de uma requisição de carta de correção
caminho        | Caminho onde devem ser salvos os documentos baixados.
tpDown         | Tipo de arquivos a serem baixados.Valores possíveis: <ul> <li>**X** - XML</li> <li>**J** - JSON</li> <li>**P** - PDF</li> <li>**XP** - XML e PDF</li> <li>**JP** - JSON e PDF</li> </ul>

##### Exemplo de chamada:

Após ter todos os parâmetros listados acima, você deverá fazer a chamada da função. Veja o código de exemplo abaixo utilizando a função criarRequisicao para auxiliar na criação da requisição de correção:

    $corrigirReqNFe = $Correcao->criarRequisicao($chNFe, $tpAmb, $dhEvento, $nSeqEvento, $xCorrecao);

    $retorno = $Correcao->corrigirEsalvar($corrigirReqNFe, $caminho, $tpDown);
    
A função **corrigirEsalvar** irá vincular um CCe (carta de correção) a uma NFe, utilizando as funções corrigir e download das classes CartaCorrecaoNFe.php e DownloadEvento.php. Caso não ocorra erro na correção, o retorno será o download realizado pelo método de download de evento da API, contendo:

##### Exempo de retorno de correção de documento:

    {
      "status": 200,
      "motivo": "Consulta realizada com sucesso",
      "retEvento": {
        "cStat": "135",
        "xMotivo": "Evento registrado e vinculado a NF-e",
        "chNFe": "43161107364617000135550000000099341000094832",
        "dhRegEvento": "2016-11-29T19:15:42-02:00",
        "nProt": "143160001512983"
      },
      "xml": "..."
    }


-----

## Inutilizar Numeração:

### Realizando uma Inutilização de Numeração de um Documento:

Utilizando NFe como exemplo para a inutilização de numeração, deverá ser utilizada a função inutilizarEsalvar da classe InutilizacaoNFe. Veja abaixo sobre os parâmetros necessários, e um exemplo de chamada do método.

##### Parâmetros:

**ATENÇÃO:** o **token** também é um parâmetro necessário e você deve, primeiramente, defini-lo na classe **Genericos.php**, como pode ver abaixo:

Parametros     | Descrição
:-------------:|:-----------
conteudo       | Objeto contendo as informações de uma requisição de inutilização.
caminho        | Caminho onde devem ser salvos os documentos baixados.
tpDown         | Tipo de arquivos a serem baixados.Valores possíveis: <ul> <li>**X** - XML</li> <li>**J** - JSON</li> <li>**P** - PDF</li> <li>**XP** - XML e PDF</li> <li>**JP** - JSON e PDF</li> </ul>

##### Exemplo de chamada:

Após ter todos os parâmetros listados acima, você deverá fazer a chamada da função. Veja o código de exemplo abaixo utilizando a função criarRequisicao para auxiliar na criação da requisição de inutilização:

    $inutReqNFe = $Inutilizacao->criarRequisicao($ano, $serie, $nNFIni, $nNFFin, $xJust, $CNPJ, $cUF, $tpAmb);

    $retorno = $Inutilizacao->inutilizarEsalvar($inutReqNFe, $caminho, $tpDown);
    
A função inutilizarEsalvar irá inutilizar a numeração do documento, usando as funções inutilizar e download presentes nas classe InutilizacaoNFe.php e DownloadInutNFe.php. Caso não ocorra erro na correção, o retorno será o download realizado pelo método de inutilização da API, contendo:

##### Exempo de retorno de correção de documento:

    {
      "status": 200,
      "motivo": "Evento localizado com sucesso",
      "retInut": {
        "cStat": "102",
        "xMotivo": "Inutilizacao de numero homologado",
        "chave": "99999999999999999999999999999999999999999",
        "tpAmb": 2,
        "dhRecbto": "2016-11-29T19:15:42-02:00",
        "nProt": "143160001512981",
        "xml": "<?xml version=\"1.0\" encoding=\"utf-8\"?><ProcInutNFe versao=\"3.10\" xmlns=\"http://www.portalfiscal.inf.br/nfe\">...</ProcInutNFe>"
      }
    }
    
 

![Ns](https://nstecnologia.com.br/blog/wp-content/uploads/2018/11/ns%C2%B4tecnologia.png) | Obrigado pela atenção!
