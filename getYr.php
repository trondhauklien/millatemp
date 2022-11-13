<?php
$xml = "https://www.yr.no/sted/Norge/Innlandet/%C3%85mot/Rena_leir/varsel_time_for_time.xml";
$file = file_get_contents($xml,0);
$json = json_encode(array($file,0));
echo $json;
?>