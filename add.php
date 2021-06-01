<?php 

$FATAL_ERROR = 0;

require_once 'login.php';
$connection=new mysqli($hn,$un,$pw,$db);
if ($connection->connect_error) die(mysqlfetalError($FATAL_ERROR)) ;


echo <<<_END
<html><head><title>Add and Search</title></head><body>
<form method="post" action="add.php">
Please complete the following form
<pre>Advisor Name:<input type="text" name="advisorname">
Student Name:<input type="text" name="studentname">
Student ID:<input type="text" name="id">
Class Code:<input type="text" name="code">
<input type="submit" name="submit" value="ADD TO THE DATABASE">
</pre>

Advisor Name: <input type="text" name ="advisorsearch" > <br>
<input type="submit" value="SEARCH">

</form>
_END;
echo "</body></html>";


table($connection);

if(isset($_POST['advisorname']) && isset($_POST['studentname']) && isset($_POST['id']) &&
isset($_POST['code'])){

$advisor=mysql_fix_string($connection,$_POST['advisorname']);
$student=mysql_fix_string($connection,$_POST['studentname']);
$id=mysql_fix_string($connection,$_POST['id']);
$code=mysql_fix_string($connection,$_POST['code']);

if(!empty($advisor)&&(!empty($student))&&(!empty($id))&&(!empty($code))){
$statement=$connection->prepare("INSERT INTO records VALUES(?,?,?,?)");
$statement->bind_param('ssii',$advisor,$student,$id,$code);

$statement->execute();
}
}

search($connection);

function search($connection){

	 if(isset($_POST['advisorsearch'])){

$user_input=mysql_fix_string($connection,$_POST['advisorsearch']);
$statement2=$connection->prepare("SELECT * FROM records WHERE advisor=?");
$statement2->bind_param('s', $user_input);

$statement2->execute();

$result=$statement2->get_result();
if ($result->num_rows>0){
  echo "It is in the database";
 echo "<br>$rows The result is:<br><br>" ;
             $rows = $result->num_rows;
            for ($i = 0; $i < $rows; $i++)
            {
                $result->data_seek($i) ;
                $row = $result->fetch_array(MYSQLI_NUM) ;
                
                echo <<< _PRINT
<pre>
  advisor $row[0]
  student $row[1]
  ID $row[2]
  Code $row[3]

<pre>
_PRINT;

}

}

}
}

function table($connection){
	$query="SELECT * FROM records";
	$result=$connection->query($query);
if (empty($result)){
$query="CREATE TABLE records (
	advisor VARCHAR (64),
	student VARCHAR(64),
	ID CHAR(16),
	Code VARCHAR(16))";
	$result=$connection->query($query);	
}
	if(!$result){
	echo "Didn't create the table";
} 
}


function mysql_fix_string($connection, $string){
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return $connection->real_escape_string($string);
}


$statement->close();
$statement2->close();
$result->close();
$connection->close();

function mysqlfetalError()
{
 echo "<br><br> We were not able to complete the task please try again<br>" ;
         
}



 ?>