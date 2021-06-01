<?php
  
   
  test();

	

    function convert($str) {
		
    $i = strlen($str);
    $sum = 0;
    while($i >= 0){
        switch($str[$i]){
                case 'I':
                    if($sum < 5)
                        $sum += 1;
                    else
                        $sum -= 1;
                    break;
                case 'V':
                    $sum += 5;
                    break;
                case 'X':
                    if($sum < 50)
                        $sum += 10;
                    else
                        $sum -= 10;
                    break;
                case 'L':
                    $sum += 50;
                    break;
                case 'C':
                    if($sum <500)
                        $sum += 100;
                    else $sum -= 100;
                    break;
                case 'D':
                    $sum += 500;
                    break;
                case 'M':
                    $sum += 1000;
                    break;
		
        } $i--;
	    }
  if($sum == 0)
	{
		echo "invalid";
         }
  else

    return $sum; 
}


	function test()
   {
	  echo 'Testing convert(h) should print invalid <br>';
      	  echo convert("h") ;
  

   	echo '<br> Testing convert(V) should print 5 <br>';
      	echo convert("V") ;

  	 echo '<br> Testing convert(VV) should print 10 <br>';
      	echo convert("VV") ;
	echo '<br> Testing convert(IX) should print 9 <br>';
      	echo convert("IX") ;


	echo '<br>Testing convert(MCMLIV) should print 1954<br> ' ;
    	echo convert("MCMLIV") ;

   	echo '<br>Testing convert(2) should print invalid <br>';
      	echo convert("2") ;

	 echo '<br>Testing convert(CCLVI) should print 256 <br> ' ;
    	  echo convert("CCLVI") ;
		
			

           echo '<br>Testing convert(CCLVX) should print 265 <br> ' ;
    	   echo convert("CCLVX") ;

	    echo '<br>Testing convert(CCLVLLXC) should print 445 <br> ' ;
    	    echo convert("CCLVLLXC") ;

	   echo '<br>Testing convert(VI) should print 6 <br> ' ;
    	   echo convert("VI") ;
		
	    echo '<br>Testing convert(IV) should print 4 <br> ' ;
    	    echo convert("IV") ;

	  echo '<br>Testing convert(MCMXC) should print 1990 <br> ' ;
    	    echo convert("MCMXC") ;


	


  }



	

?>