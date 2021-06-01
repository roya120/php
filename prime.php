<?php

prime_functionTester() ;


function prime_function($number)
{
    // checking if smaller than 2. No need to print anything
    if ($number < 2)
    {
        
        return " ";
    }
    
    $result = "" ;
    for ($i = 2; $i < $number; $i++)    
    {
        $counter = 0 ;
        
        for ($j = 1; $j <= $i; $j++)    // checking if the number is prime
            if ($i % $j == 0)
                $counter++ ;
            
        if ($counter == 2)              // add to the result
            $result .= $i." " ;
    }
                           
    return $result;
}


function prime_functionTester()

{
	  
    echo 'Testing prime_function(10)<br> The results are <br>' ;
    echo prime_function(10);     // calling the function to print the results
 		echo '<br>'; 


    $test = prime_function(10);
    $test1="2 3 5 7 ";


     if($test == $test1)  // checking is the test passed 
 {
     echo 'test passed';
 }
   else{
    echo 'did not match<br>';
  }
     
	echo '<br>'; 
	echo '<br>'; 

    echo 'Testing prime_function(100)<br> The results are <br>' ;
    echo prime_function(100);   // calling the function to print the results
	echo '<br>'; 
     $test = prime_function(100);
     $test1="2 3 5 7 11 13 17 19 23 29 31 37 41 43 47 53 59 61 67 71 73 79 83 89 97 ";
   
     if($test == $test1)   //checking if test passed
 {
     echo 'test passed';
 }
   else{
    echo 'did not match<br>';
  }
     
  echo '<br>'; 

   
    
    echo '<br>Testing prime_function(1)<br>' ;
    echo  'The result is an empty string<br>' ;


    echo prime_function(1) ; // calling the function to print the results
   $test = prime_function(1);
    $test1=" ";


     if($test == $test1)   			//checking if test passed

 	{
     echo 'test passed';
	 }
   else{
    echo 'did not match<br>';
  	}
     

     echo '<br>'; 

   
    
    echo '<br>Testing prime_function(20)<br>' ;
    echo  'The result are <br>' ;


    echo prime_function(20) ;    // calling the function to print the results
   $test = prime_function(20);
    $test1="2 3 5 7 11 13 17 19 ";
       echo '<br>';


     if($test == $test1)     //checking if test passed

 	{
     echo 'test passed';
	 }
   else{
    echo 'did not match<br>';
  	}

    
    
    
    }
?>