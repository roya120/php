<?php


require_once 'login.php' ;
$conn = new mysqli($hn, $un, $pw, $db) ;
if ($conn->connect_error) die(mysqlError()) ;

session_start() ;   


if (!empty($_POST["signUpUsername"]) || !empty($_POST["signUpPassword"])|| !empty($_POST["signUpEmail"]))
{
    if (!empty($_POST["signUpUsername"]) && !empty($_POST["signUpPassword"]) && !empty($_POST["signUpEmail"]))  
    {
      
        $statement = $conn->prepare('SELECT * FROM credentials WHERE username = ?') ;
        $statement->bind_param('s', $username) ;
        $username = sanitizeMySQL($conn, $_POST['signUpUsername']) ;   
        $statement->execute() ;
        $result = $statement->get_result() ;
        
        if ($result)   
        {
            if (!$result->num_rows)    
            {
              
                $statement = $conn->prepare('INSERT INTO credentials VALUES(?,?,?)') ;
                $statement->bind_param('sss', $username, $password, $email) ;
                
                
                $username = sanitizeMySQL($conn, $_POST['signUpUsername']) ;
               $password = password_hash(sanitizeMySQL($conn, $_POST['signUpPassword']), PASSWORD_DEFAULT) ;	  
                $email = sanitizeMySQL($conn, $_POST['signUpEmail']) ;
	         
                $statement->execute() ;
                
                if ($statement->affected_rows)
                    $_SESSION['username'] = $_POST["signUpUsername"] ;  
                else $insertSignupError = true ;   
                    
                $result->close() ;
            }
            else $nameTaken = true ;    
        }
        else $retrieveSignUpError = true ;    
        
        $statement->close() ;
    }
    else $incompleteSignUp = true ;   
}

else if (!empty($_POST["loginUsername"]) || !empty($_POST["loginPassword"]) || !empty($_POST["loginEmail"]))
{
    if (!empty($_POST["loginUsername"]) && !empty($_POST["loginPassword"]) && !empty($_POST["loginEmail"]))   
    {
        
        $statement = $conn->prepare('SELECT * FROM credentials WHERE username = ?') ;
        $statement->bind_param('s', $username) ;
        $username = sanitizeMySQL($conn, $_POST['loginUsername']) ;   
	
        
        $statement->execute() ;
        $result = $statement->get_result() ;
        $statement->close() ;
        
        if ($result)    
        {
            if ($result->num_rows)     
            {
                $user = $result->fetch_array(MYSQLI_ASSOC) ;    
               
                if (password_verify(sanitizeMySQL($conn, $_POST['loginPassword']), $user['password'])) {
                    $_SESSION['username'] = $_POST["loginUsername"] ;  
  			  
		  
      }
                else $invalidCombination = true ;  
            }
            else $invalidCombination = true ;   
            
            $result->close() ;
        }
        else $retrieveLoginError = true ;   
    }
    else $incompleteLogin = true ;  
}

else if (!empty($_POST['content_name']) || !empty($_FILES['file_content']['tmp_name']))
{
    if (!empty($_POST['content_name']) && $_FILES['file_content']['tmp_name'])  
    {
        if ($_FILES['file_content']['type'] == 'text/plain')
        {
          
            $statement = $conn->prepare('SELECT content_name FROM content WHERE username = ?') ;
            $statement->bind_param('s', $username) ;
            $username = sanitizeMySQL($conn, $_SESSION['username']) ;   
            $statement->execute() ;
            $result = $statement->get_result() ;
            
            if ($result)   
            {
                $found = false ;    
                for ($i = 0; $i < $result->num_rows; $i++) 
                {
                    $result->data_seek($i) ;
                    $row = $result->fetch_array(MYSQLI_NUM) ;
                    if ($row[0] == sanitizeMySQL($conn, $_POST['content_name']))    
                        $found = true ;
                }
                
                if (!$found) 
                {
                    
                    $statement = $conn->prepare('INSERT INTO content VALUES(?,?,?)') ;
                    $statement->bind_param('sss', $username, $content_name, $file_content) ;
                    
                    $username = sanitizeMySQL($conn, $_SESSION['username']) ;
                    $content_name = sanitizeMySQL($conn, $_POST['content_name']) ;
                    $file_content = sanitizeMySQL($conn, file_get_contents($_FILES['file_content']['tmp_name'])) ;
                    $statement->execute() ;
                    
                    if ($statement->affected_rows) $fileAdded = true ;
                    else $insertFileError = true ; 
                }
                else $filenameExist = true ;   
                
                $result->close() ;
            }
            else $retrieveFileError = true ;    
            
            $statement->close() ;
        }
        else $invalidFile = true ;  
    }
    else $incompleteFile = true ;  
}

else if (!empty($_POST["logout"]) && $_POST["logout"] == "yes")  destroySession() ;


if (empty($_SESSION['username']))
{
    
    echo <<<_SIGN_UP

<form action="midterm2.php" method="post"><pre>
SIGN UP

You can sign up here if you don't have an account
Username <input type="text" name="signUpUsername">
Password <input type="text" name="signUpPassword">
Email <input type="text" name="signUpEmail"> <br>
<input type="submit" value="Sign Up">

</pre></form>
_SIGN_UP;
    
    
    if (isset($incompleteSignUp)) echo "Please fill out all the fields.<br><br>" ;
    
    else if (isset($nameTaken)) echo "This username already exist. Try again<br><br>" ;
    
    
   
    echo <<<_LOGIN
<form action="midterm2.php" method="post"><pre>
LOG IN

Log in here if you have an account
Username <input type="text" name="loginUsername">
Password <input type="text" name="loginPassword"> 
Email <input type="text" name="loginEmail"> <br>
<input type="submit" value="Log In">

</pre></form>
_LOGIN;
    
    
    if (isset($incompleteLogin)) echo "Please fill out all the fields<br><br>" ;
    
    else if (isset($invalidCombination)) echo "Invalid username/password combination<br><br>" ;
}

else
{
    
    echo <<<_FILE
 
<form action="midterm2.php" method="post" enctype='multipart/form-data'><pre>
Welcome, {$_SESSION['username']}!

UPLOAD A FILE

Enter file name <input type="text" name="content_name"> 

Please sleet txt file only <br> <input type='file' name='file_content'> <br> <input type="submit" value="Click to see the first 3 lines and the entire file">

</pre></form>
_FILE;
    
    
    if (isset($incompleteFile)) echo "Please fill out all the fields<br><br>" ;
    else if (isset($invalidFile)) echo "Only .txt file is accepted<br><br>" ;
   
    else if (isset($filenameExist)) echo "This name is already in the database, please upload another file
                                            <br><br>" ;
    
    else if (isset($fileAdded)) echo "File uploaded<br><br>" ;
    else echo "Please fill all fields<br><br>" ;



     echo <<<_LOGOUT
<form action="midterm2.php" method="post">
<input type="hidden" name="logout" value="yes"> <br>
<input type="submit" value="Log Out"></form>
_LOGOUT;
    
    echo "<pre>
        
UPLOADED FILES
        
</pre>" ;
    
    
    $statement = $conn->prepare('SELECT * FROM content WHERE username = ?') ;
    $statement->bind_param('s', $username) ;
    $username = sanitizeMySQL($conn, $_SESSION['username']) ;  
    $statement->execute() ;
    $result = $statement->get_result() ;
    $statement->close() ;

   
       
    if ($result)    
    {

$file = $_POST['content_name'].'.txt';
$fh = fopen($file, 'rb');




for ($i = 0; $i < 3; $i++) {
   
    $line = fgets($fh);

    
    if ($line !== false) {
        echo $line;
    } 
}

     echo "<br>";
 echo "<br>";
 echo "<br>";



        if ($result->num_rows)  
        {
            for ($i = 0; $i < $result->num_rows; $i++)
            {
                $result->data_seek($i) ;
    
         
              $row = $result->fetch_array(MYSQLI_ASSOC) ;
              
              echo "File Name: ".$row['content_name']."<br>" ;
                echo "Content:<pre>".$row['file_content']."</pre>" ;
     
		
                echo "<br>" ;
            }
        }
        else echo "Nothing is uploaded yet" ;
        
        $result->close() ;
    }
    
}





$conn->close() ;  



function sanitizeString($str)
{
    $str = stripslashes($str) ;
    $str = strip_tags($str) ;
    return htmlentities($str);
}
function destroySession()
{
    @session_start() ;
    $_SESSION = array() ;	// delete all information in $_SESSION
    setcookie(session_name(), '', time() - 2592000, '/') ;  
    session_destroy();
}


function sanitizeMySQL($conn, $str)
{
    $str = $conn->real_escape_string($str) ;
    return sanitizeString($str);
}


function mysqlError()
{
        
            echo "<br>This page is not working please double check and try again.<br>" ;
              
}


?>