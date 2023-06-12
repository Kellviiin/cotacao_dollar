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
    $curl = curl_init();
    $hoje = date("'m/d/Y'");
    $urlAPI = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarDia(dataCotacao=@dataCotacao)?@dataCotacao='. "$hoje" .'&$top=100&$format=json';
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

?>


    <div class="block-cotacao">
        <p><strong>Cotação-Venda:</strong> <?php echo "$cotacaoVenda"?></p>
        <p><strong>Cotação-Compra:</strong> <?php echo "$cotacaoCompra"?></p>
        <p><strong>Data e Hora/Cotação:</strong> <?php print_r($format_Date_hora[0]."/".$format_Date[1]."/".$format_Date[0]." - ".$format_Date_hora[1])?></p>
    </div>

    <br>

    
    

</body>
</html>



