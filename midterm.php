

<?php
echo <<<_END
<html>
    <head>
        <title>Form Upload</title></head>
    <body>
        <form method='post' action='midterm.php' enctype='multipart/form-data'>
	      Please choose a file <br>
            <input type='file' name='file' size='10'>
            <input type='submit' value='Upload'></form>
            </body> </html>
_END;


      if ($_FILES ) 
   {
 if($_FILES['file']['name'] != "") {
  if(isset($_FILES) && $_FILES['file']['type'] != 'text/plain') {
  echo "<span>File could not be accepted ! Please upload any '*.txt' file.</span>";
  exit();
       } 
  echo "<center><span id='Content'>Contents of ".$_FILES['file']['name']." File</span></center>";
    
     $came_from = htmlentities($FILES['HTTP_REFERER']);

    $filename = $came_from['file']['tmp_name'] ;
   
    
    if ($_FILES['file']['type'] != 'text/plain')   
        echo "The file cannot be opened" ;
    else
    {
        echo "The file is uploaded<br><br>" ;
        fileFunction(file_get_contents($_FILES['file']['name'])) ;
      fclose($file);
    }
}
   }



function fileFunction($str)
{
    $str = preg_replace("/\s+/", "", $str) ;    
    
    if ((strlen($str) == 400) && preg_match("/^[0-9]*$/", $str))       {
        $numberMatrix = array_chunk(str_split($str), 20) ; 
        $result[0] = 0 ;    
        
        $result = rowsFunction($numberMatrix, $result) ;   
        $result = columnsFunction($numberMatrix, $result) ;    
        $result = diagnoalUpDown($numberMatricolumnsFunctionx, $result) ; 
        $result = diagnoalBottomUp($numberMatrix, $result) ;
        
        echo "The maximum product is $result[0]<br>" ;
           }
      else 
   {
    echo "Not the right format. Please try again." ;
}
}

 
 

function rowsFunction($matrix, $result)
{
    for ($row = 0; $row < 20; $row++)
        for ($column = 0; $column < 17; $column++)
        {
            $product = $matrix[$row][$column] * $matrix[$row][$column + 1] * $matrix[$row][$column + 2] * $matrix[$row][$column + 3] ;
            if ($product > $result[0])
            {
                $result[0] = $product ;
                $result[1] = $matrix[$row][$column] ;
                $result[2] = $matrix[$row][$column + 1] ;
                $result[3] = $matrix[$row][$column + 2] ;
                $result[4] = $matrix[$row][$column + 3] ;
            }
        }
    return $result;
}


function columnsFunction($matrix, $result)
{
    for ($column = 0; $column < 20; $column++)
        for ($row = 0; $row < 17; $row++)
        {
            $product = $matrix[$row][$column] * $matrix[$row + 1][$column]  * $matrix[$row + 2][$column] * $matrix[$row + 3][$column] ;
            if ($product > $result[0])
            {
                $result[0] = $product ;
                $result[1] = $matrix[$row][$column] ;
                $result[2] = $matrix[$row + 1][$column] ;
                $result[3] = $matrix[$row + 2][$column] ;
                $result[4] = $matrix[$row + 3][$column] ;
            }
        }
    return $result;
}

function diagnoalBottomUp($matrix, $result)
{
    for ($row = 3; $row < 20; $row++)
        for ($column = 0; $column < 17; $column++)
        {
            $product = $matrix[$row][$column] * $matrix[$row - 1][$column + 1]
            * $matrix[$row - 2][$column + 2] * $matrix[$row - 3][$column + 3] ;
            if ($product > $result[0])
            {
                $result[0] = $product ;
                $result[1] = $matrix[$row][$column] ;
                $result[2] = $matrix[$row - 1][$column + 1] ;
                $result[3] = $matrix[$row - 2][$column + 2] ;
                $result[4] = $matrix[$row - 3][$column + 3] ;
            }
        }
    return $result;
}



function diagnoalUpDown($matrix, $result)
{
    for ($row = 0; $row < 17; $row++)
        for ($column = 0; $column < 17; $column++)
        {
            $product = $matrix[$row][$column] * $matrix[$row + 1][$column + 1]
            * $matrix[$row + 2][$column + 2] * $matrix[$row + 3][$column + 3] ;
            if ($product > $result[0])
            {
                $result[0] = $product ;
                $result[1] = $matrix[$row][$column] ;
                $result[2] = $matrix[$row + 1][$column + 1] ;
                $result[3] = $matrix[$row + 2][$column + 2] ;
                $result[4] = $matrix[$row + 3][$column + 3] ;
            }
        }
    return $result;
}



function tester()
{
    fileFunction("") ;
    echo "Not the right format..<br>" ;
    
    echo "<br>" ;
    fileFunction("837726383874jasbd83749474") ;
    echo "Not the right format<br>" ;
     
	echo "<br>" ;
    fileFunction("923898437835834223837834832344u4u48958929958843858529829698548968") ;
    echo "Not the right format<br>" ;
    
    echo "<br>" ;
    fileFunction("71636269561882670428
                        85861560789112949495
                        65727333001053367881
                        52584907711670556013
                        53697817977
                        846174064
                        83972241375657056057
                        8216637048440  3199890
                        96983520312774506326
                        125406987
                        47158523863
                        6689664895 0445244523
                        0588611 6467109405077
                        16427171	479924442928
                        17866458359124566529
                        242190  22671055626321
                        071984038509
                        62455444
                        84580156166097919133
                        62229893423380308135
                        7316717653	1330624919
                        30358907296290491560
                        70172427121883989797") ;
    echo "Max product is 5832:<br>" ;
}
?>