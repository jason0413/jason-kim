<?php
include_once 'Snoopy.class.php';
include_once 'simple_html_dom.php';

$hostname = "localhost";
$username = "cs20121576";
$password = "dbpass";
$dbname = "db20121576";

$connect = new mysqli($hostname, $username, $password, $dbname) or die("DB Connection Failed");

mysqli_set_charset($connect,"utf8");

while(1){

	$html = new simple_html_dom();
	$snoopy = new snoopy;
	$snoopy->fetch("http://aqicn.org/map/seoul/kr/");
	$txt = $snoopy->results;

	$html->load($txt);

	$lists = $html->find('div[id=map-stations]');

	foreach($lists as $value){
		foreach($value->find('a') as $e){
			$str = $e->innertext;
			$city = strtok($str," ");
			if($city == "서울특별시") continue;
			$aqi = strtok(">");
			$aqi = strtok("<");
			$time = date("Y-m-d H:i:s");
			$sql = "INSERT INTO whisen(city, time, value) VALUES('$city','$time','$aqi')";

			$result = mysqli_query($connect, $sql);
		}
	}
	sleep(1800);
}
$connect->close();
?>
