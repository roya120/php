<?php

echo <<<_END
<html><head><title>PHP and MySQL</title></head><body>
<form method="post" action="web.php" enctype="multipart/form-data">
Please choose a file<br>
Name:<input type="text" name="name"><br>
Content:<input type="file" name="content" size='10'>
<input type="submit" name="submit" value="Upload">

</form>
_END;

require_once 'login.php';

$connection=new mysqli($hn,$un,$pw,$db);

if ($connection->connect_error) die ($connection->connect_error); 

table($connection);


if (isset($_FILES) && isset($_POST['name'])){
	
	$files=$_FILES['content']['name'];
	$files=preg_replace("/[^A-Za-z0-9.]/", "", $files); 


	$extention= substr($files, strpos($files, '.')+1);
	if (($extention=="txt")){
		


$content= file_get_contents($_FILES['content']['tmp_name']);

$name=$connection-> real_escape_string($_POST['name']);




$query= "INSERT INTO uploads VALUES"."('$name','$content')";
$result= $connection->query($query);


if(!$result){
	echo "invalid";
} 
	}
	webpage($connection);

}
 

$result->close();
$connection->close();


function table($connection){
	$query="SELECT * FROM uploads";
	$result=$connection->query($query);
if (empty($result)){
$query="CREATE TABLE uploads (
	name VARCHAR (128),
	content VARCHAR(128))";
	$result=$connection->query($query);	
}
	if(!$result){
	echo "empty";
} 
}

function webpage($connection){
	$query="SELECT * FROM uploads";
	$result= $connection->query($query);
	if(!$result){
		echo "Error";
	}
	$rows=$result->num_rows;
	echo "<table><tr><th>Name</th><th>Content</th></tr>";
	for($j=0;$j<$rows;++$j){
		$result->data_seek($j);
		$row=$result->fetch_array(MYSQLI_NUM);
		echo "<tr>";
		for ($k=0;$k<4;++$k){
			echo "<td>$row[$k]</td>";
		}
	}
	echo "</table>";
}



?>
