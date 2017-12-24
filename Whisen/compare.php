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

mysqli_set_charset($connect,"utf8");
$string1 = $_REQUEST["q"];
$string2 = $_REQUEST["r"];
echo "<br>";
#echo $string1;
#echo $string2;
$row1 = "";
$sql = "SELECT * FROM ".$dbname.".whisen "."WHERE city = '"."$string1"."'"." order by time DESC limit 1";
$val = mysqli_query($connect,$sql);

if($val)
{
	$row1 = mysqli_fetch_assoc($val);
	
//	$x = $row1['city'];
//	$y = $row1['value'];
	 
}
else
{
	echo "No data";
}

$sql = "SELECT * FROM ".$dbname.".whisen "."WHERE city = '"."$string2"."'"." order by time DESC limit 1";
$val = mysqli_query($connect,$sql);

if($val)
{
	$row2 = mysqli_fetch_assoc($val);
	
#	echo $row1['value'];
#	echo $row2['value'];

	if($row1['value'] < $row2['value'])
	{
		echo $string1;
		echo " 가 ";
		echo $row2['city'];
		echo " 보다 <br> 미세먼지 농도가 낮습니다";
		echo "<br>";
		echo $row1['value'];
		echo " < ";
		echo $row2['value'];
	}
	else if($row1['value'] == $row2['value'])
	{
		echo $string1;
		echo " 가 ";
		echo $row2['city'];
		echo " 와 <br> 미세먼지 농도가 같습니다";
		echo "<br>";
		echo $row1['value'];
		echo " = ";
		echo $row2['value'];
	}
	else
	{
		echo $row2['city'];
		echo " 가 ";
		echo $string1;
		echo " 보다 <br> 미세먼지 농도가 낮습니다";
		echo "<br>";
		echo $row2['value'];
		echo " < ";
		echo $row1['value'];
	}

}
else
{
	echo "No data";
}
	$connect->close();
?>
</body>
</html>
