<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$text=$_POST['phrase'];

file_put_contents('text.txt',$text);

$command = escapeshellcmd('python Run_Model.py');

$output = shell_exec($command);

echo $output;

$curl = curl_init();
$textID=14;
curl_setopt($curl, CURLOPT_URL, "https://web.njit.edu/~shm27/CS490/middleend/addString.php");
$info="text=".$text."&result=".$output."&textID=".$textID;
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $info);
$response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if($status == 200 && isset($response)){
    //echo "\nsent__".$response;
}
else{

    echo "\nfailed";
}

curl_close($curl);

?>