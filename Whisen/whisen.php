<html>
<body>


<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

#echo ("MySQL - PHP Connect Test <br/>");
$hostname = "localhost";
$username = "cs20121576";
$password = "dbpass";
$dbname = "db20121576";

$connect = new mysqli($hostname, $username, $password) 
     or die("DB Connection Failed");
	 //$result = mysql_select_db($dbname,$connect);
	  
#	  if($connect) {
#	   echo("MySQL Server Connect Success!");
#	   }
#	   else {
#	    echo("MySQL Server Connect Failed!");
#		}
mysqli_set_charset($connect,"utf8");

$city = $_REQUEST["q"];
#echo $city;

if($city == "min")
{
	$sql = "SELECT min(value) FROM ".$dbname.".whisen WHERE time > NOW() - interval 1 day limit 1";
	$val = mysqli_query($connect,$sql);
	$row = mysqli_fetch_array($val);
	$sql = "SELECT * FROM ".$dbname.".whisen "."WHERE value = '"."$row[0]"."' and time > NOW() - interval 1 day limit 1";
}
else if($city == "max")
{
	#echo "here";
	$sql = "SELECT max(value) FROM ".$dbname.".whisen WHERE time > NOW() - interval 1 day limit 1";
	$val = mysqli_query($connect,$sql);
	$row = mysqli_fetch_array($val);
	$sql = "SELECT * FROM ".$dbname.".whisen "."WHERE value = '"."$row[0]"."' and time > NOW() - interval 1 day limit 1";
	#echo $sql;
}
else
	$sql = "SELECT * FROM ".$dbname.".whisen "."WHERE city = '"."$city"."'"." order by time DESC limit 1";

#==========================
# min.max 미세먼지 값 구하는 mysql query

#echo $sql;
$val = mysqli_query($connect,$sql);

//$val = $connect->multi_query($sql);
if($val)
{
	if($city == "min")
		$row = mysqli_fetch_array($val);	
	else if($city == "max")
		$row = mysqli_fetch_array($val);	
	else
		$row = mysqli_fetch_assoc($val);
	if(!$row)
		echo "nothing";
	if($city == "min")
	{
		echo $row[0];
		echo "<br>미세먼지 농도 : ";
		echo $row[2];
	}
	else if($city == "max")
	{
		echo $row[0];
		echo "<br>미세먼지 농도 : ";
		echo $row[2];
	}
	else
	{
		echo "미세먼지 농도 : ";
		echo $row['value'];
		echo "<br>";
		if($row['value'] < 50)
			echo "대기 오염 지수 : 좋음";
		else if($row['value'] < 100)
			echo "대기 오염 지수 : 보통";
		else if($row['value'] < 150)
			echo "대기 오염 지수 : 민감군영향";
		else if($row['value'] < 200)
			echo "대기 오염 지수 : 나쁨";
		else if($row['value'] < 300)
			echo "대기 오염 지수 : 매우 나쁨";
		else
			echo "위험";
	#print_r($row);
	}
}
else
{
	echo "<br>No data";
}
	$connect->close();
?>
</body>
</html>
