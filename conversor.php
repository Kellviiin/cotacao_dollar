<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cotação Dollar</title>
</head>
<body>

<?php 
    $valor = $_GET["valor"];
    $curl = curl_init();
    $hoje = date("'m-d-Y'");
    $urlAPI = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'06-09-2023\'&@dataFinalCotacao='.$hoje.'&$top=100&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,cotacaoVenda,dataHoraCotacao';
    $valoresCotacao = [];

    curl_setopt_array($curl, [
        CURLOPT_URL => $urlAPI,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_RETURNTRANSFER => true
    ]);

    $object = json_decode(curl_exec($curl));

    foreach ($object -> value as $value){
        array_push($valoresCotacao, $value);
        
    }

    $cotacaoCompra = $valoresCotacao[0] -> cotacaoCompra;
    $cotacaoVenda = $valoresCotacao[0] -> cotacaoVenda;
    $dataHoraCotacao = $valoresCotacao[0] ->  dataHoraCotacao ;

    $format_Date = explode("-", $dataHoraCotacao);
    $format_Date_hora = explode(" ", $format_Date[2]);

    $resultado = $valor/$cotacaoCompra;
    $resultado_final = number_format($resultado, 2, '.')

?>


    <div class="block-cotacao">
        <p><strong>Cotação-Venda:</strong> <?php print_r(number_format($cotacaoCompra, 2, '.'))?></p>
        <p><strong>Cotação-Compra:</strong> <?php  print_r(number_format($cotacaoVenda, 2, '.'))?></p>
        <p><strong>Data e Hora/Cotação:</strong> <?php print_r($format_Date_hora[0]."/".$format_Date[1]."/".$format_Date[0]." - ".$format_Date_hora[1])?></p>
        <h3>Valor da consulta - Real para Dolar <?php echo "$resultado_final" ?></h3>
    </div>
        

    <br>

    
    

</body>
</html>




