<?php
/*
if($_POST['password']!=""){ //Attempted login
	if($_POST['password']=="silvermover"){ 
		$_SESSION['auth']='true';
	}
}

if($_SESSION['auth']=='true'){ 
*/
        include("dataOutput2Xml.php");
		
        $sql="
                SELECT * FROM ts_fabrics
			
			INNER JOIN
			    ts_fabric_type
			ON
			    f_ft_id=ft_id
			    
			ORDER BY
			    f_ft_id, f_code
                        ";
                        
        $agentName="Exact Personal Tailoring Services";
        $setting=array(
			
                        "dbname" =>"exacttai_exact2db" ,
                        "dbuser" => "exacttai_exaUser",
                        "dbpassword" => "tcaxe428",

			
			/*
                        "dbname" =>"db_exact" ,
                        "dbuser" => "root",
                        "dbpassword" => "root",
			*/
			
                        "dbhost" => "localhost" ,
                        "url" => "http://exacttailoring.com/"
                );
        
	//echo $sql;
        $data=new DataOutput2Xml($sql,$agentName,$setting);
        $data->output();
        //$data->test();

//}else{ 	//User needs to login
?>
    <!--<form id="login2" style="width:500px; margin:20px 10px;" action="<?php //echo($_SESSION['PHP_SELF']);?>" method="post">
	<div style="float:left;">
            <span style="margin:10px; color:#000;">Enter Password </span>
            <input name="password" id="password" type="password" value="" style="margin-right:5px;" />
            <input name="firstlogSubmit"  id="firstlogSubmit" type="submit" value="Login" />
	</div>
    </form>-->
<? //} ?>

