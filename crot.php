<?php

date_default_timezone_set("Asia/Jakarta");

echo  PHP_EOL;
echo "CREATE AKUN BLI BLI.CROT". PHP_EOL;
echo "mavin.pro". PHP_EOL;
echo  PHP_EOL;

$x='Y';
while($x=='Y' || $x=='y'){
$ppq = new_email();

echo "pass  : ";
$pass = trim(fgets(STDIN));

buat($ppq, $pass);
echo  PHP_EOL;
echo "lagi?(y/n) : ";
$x = trim(fgets(STDIN));
}

function new_email() {
	$ch_new = curl_init();
	curl_setopt($ch_new, CURLOPT_URL, 'https://api.internal.temp-mail.io/api/v2/email/new');
    curl_setopt($ch_new, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0');
	curl_setopt($ch_new, CURLOPT_HEADER, false);
	/*$header   =  [
            'Content-Type: application/json;charset=utf-8'
        ];*/

	curl_setopt($ch_new, CURLOPT_HTTPHEADER, 'Content-Type: application/json;charset=utf-8');
	curl_setopt($ch_new, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch_new, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch_new, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch_new, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch_new, CURLOPT_COOKIEJAR,'cookie.txt');
	curl_setopt($ch_new, CURLOPT_POST, true);
	curl_setopt($ch_new, CURLOPT_POSTFIELDS, "min_name_length=10&max_name_length=10");
	
	
	$hasil_new_email = json_decode(curl_exec($ch_new));
	
	$email = $hasil_new_email->email;
	return $email;
}

function inbox($email) {
	echo "email inbox : " .$email.PHP_EOL;
	$ch_new = curl_init();
	curl_setopt($ch_new, CURLOPT_POST, false);
	curl_setopt($ch_new, CURLOPT_URL, 'https://api.internal.temp-mail.io/api/v2/email/'.$email.'/messages');
    curl_setopt($ch_new, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0');
	curl_setopt($ch_new, CURLOPT_HEADER, false);
		$header   =  [
            null
        ];
	curl_setopt($ch_new, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch_new, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch_new, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch_new, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch_new, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch_new, CURLOPT_COOKIEJAR,'cookie.txt');


        $json = json_decode(curl_exec($ch_new));
		// print_r($json);
		
 		$kemem = $json[0]->body_text;
		// echo $kemem;
		

            
            if(isset($kemem)) { 
                if(is_numeric(strpos($kemem, 'http://url5735.blibli.com/ls/click?upn='))) {    
                    $a = strpos($kemem, 'Kalau kamu tidak mendaftarkan akun');

                    $b = substr($kemem, 1099, (strlen($kemem)-$a+2)*-1);
                    $c = strpos($b, 'click?');
					
                    $activation_link = 'http://url5735.blibli.com/ls/click?'.substr($b, ($c+6), -2); 
					// 'http://url5735.blibli.com/ls/click?upn='.substr($json->body_text, ($a+21), (strlen($json->body_text)-$b+2)*-1); 
                    echo $activation_link;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }   
        

              

}

function buat($email,$pass){
	echo PHP_EOL."ini email buat:".$email.PHP_EOL;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://www.blibli.com/backend/mobile/reg');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$email."&password=".$pass);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'User-Agent:BlibliAndroid/6.9.0(2632) 814a9275-4654-47a7-aabf-25f0beef9f3b Dalvik/2.1.0 (Linux; U; Android 6.0.1; CPH1701 Build/MMB29M)';
	$headers[] = 'Accept-Language: id';
	$headers[] = 'channelId: android';
	$headers[] = 'storeId: 10001';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'Host: www.blibli.com';
	$headers[] = 'Connection: Keep-Alive';
	$headers[] = 'Accept-Encoding: gzip';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	$result = json_decode(curl_exec($ch));
	 print_r($result);
	 $cek_res = $result->result;
	 if($cek_res == false){
		 
		 echo "ulang lagi ya ppq";
	 } else {
		sleep(30);
		$verif_email = inbox($email);
	 }

}



?>
