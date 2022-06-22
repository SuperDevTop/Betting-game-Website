<?php
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.iugu.com/v1/transfers?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{"transfer_type": "pix","amount_cents": 500,"receiver":
        {"account_id":"17","name": "Andre Luiz Pedrozo","cpf_cnpj": "33974953850","bank": 
            {"ispb": "336","account": "49887971","account_type": "checking_account"}}}',
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);



if($err){
    echo 'Erro<br><br>';
}else{
    echo 'Ok<br><br>';
}

  $dados1 = json_decode($err,true);
  
  $dados2 = json_decode($response,true);

var_dump($dados1);
echo '<br><hr><br>';
var_dump($dados2);

curl_close($curl);
?>