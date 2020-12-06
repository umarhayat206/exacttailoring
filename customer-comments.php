<?php

include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");

if($_POST['commentsubmit']){

    if (empty($_POST['commentverify'])){
        $errstr = "Please validate the image code";
    }else{
        if(strtolower($_REQUEST['commentverify']) != $_SESSION['random_number']){
            $errstr = "The security code you entered was incorrect";
        }
    }
        
    if(!empty($errstr)){
        echo "<script language='javascript'  type='text/javascript'>
            alert('$errstr');
            window.location='"._URL_."customer-comments';
        </script>";
     
    }else{
		
        include_once('class.phpmailer.php');
        $mail= new PHPMailer();
        $mail->From = $_POST['commentemail'];
        $mail->FromName = $_POST['commentname'];
        
        $mail->AddAddress($smMainEmail, $smCompanyName);
        $mail->AddCC("may@silvermover.com", "Admin");
        $mail->Subject = $smCompanyName.": Customer completed comment form";

        $body="<font face='Arial' size='2'><b>$smCompanyName,</b></font><br /><br />
        <font face='Arial' size='2'>A customer has completed the comment form on the website.<br />Details as follows<br /><br />--------------------------------------</font>
        <font face='Arial' size='2'>		
        <br />Name: <b>{$_POST['commentname']}</b>
        <br />Email: <b>{$_POST['commentemail']}</b>
        <br />Message:
        <br />{$_POST['commentmessage']}
        <br /><br /></font>";
	$body .= "<br /><p>Sender IP: <strong>" . $_SERVER["REMOTE_ADDR"] . "</strong></p>";
		$body .= "<br /><p>Referer URL: <strong>" . $_SERVER['HTTP_REFERER'] . "</strong></p>";
                
        $mail->MsgHTML($body);
        if($mail->Send()) {	// send the mail
        echo "<script language='javascript'  type='text/javascript'>
            alert('Thank you for your comment.');
            window.location='"._URL_."';
        </script>";
            
        }else{
            echo "<script language='javascript'  type='text/javascript'>
                alert('Failed to send mail');
                window.location='"._URL_."';
            </script>";
        }
    }
    
}

$countItem = smComment::countComment();
$commentItem = smComment::GetAllComment(false);

?>
<div class="container">
<div class="row">


    
                
    <h1 class="text-center comment-h1">What our Customers Say</h1>
     
    <p class="text-center" style="font-size:18px;">We take pride in the reviews and feedback we receive. Below are just some of them.<br> Feel free to leave yours by filling in the form on the left-hand side of the page.</p><br>
      
                
                <!-- <div class="clearfix">
                    <ul class="unstyled blog-content-date" >
                        
                        <li ><i class="icon-calendar"></i> <?php echo date("d M, Y"); ?></li>
                        <li class="pull-left"><i class="icon-pencil"></i> <a href="#"><?php echo $smCompanyName; ?></a></li>
                    </ul>
                </div> -->
               
        
  <div class="col-lg-6">
     

            
    <h1 id="" class="text-center comment-h1">Leave Comment</h1><br>
            

            <form id="formcustomercomment" name="formcustomercomment" method="post" action="<?=_URL_;?>customer-comments" enctype="multipart/form-data">
            
                <div class="controls controls-row">
                    <input type="text" name="commentname" id="commentname" value="" placeholder="Your Name...*" required class="form-control contactus-input" /><br>
                    <input type="text" name="commentemail" id="commentemail" value="" placeholder="E-Mail...*" required class="form-control contactus-input" />
                    <br/>
                    <img src="get_captcha.php" alt="" id="captcha" />
                    <img src="refresh.jpg" alt="" id="refresh" style="width:25px; cursor:pointer; margin:0px;" />
                    <input type="text" id="commentverify" name="commentverify" placeholder="Type Code Above Here...*" value="" required style="margin-top:5px; text-transform:uppercase;" class="form-control contactus-input" /><br>
                </div>
                
                <div class="controls">
                    <textarea name="commentmessage" id="commentmessage" required placeholder="Your Message...*" class="form-control contactus-input" style="height:150px;"></textarea><br><br>
                </div>
                
                <input type="hidden" id="commentsubmit" name="commentsubmit" value="true" />
                <center><button type="submit" class="btn btn-default-shop">Add Comment</button></center>
            </form>
        
        
   <!--  <a href="<?php echo _URL_; ?>http://www.exacttailoring.com/collection/categories-mens-shirts/fabric-mauritius-">
            <img src="<?=_URL_;?>images/mauritius-montage.jpg" alt="Buy tailor made shirts online" title="Buy tailor made shirts online" style="width:100%; margin-top:10px;" />
        </a> -->
        
    
  </div>
   <div class="col-lg-6">
    <div class="span9">


        <div class="user-comments">
            
                <h1 class="text-center comment-h1">Testimonials</h1>
            

            <ul style="display: inline;list-style-type:none;">
                <?php
                foreach($commentItem as $items){ 
                
                    echo "<li>
                        <div class='media-body'>
                            
                            <i class='icon-calendar'></i> ". date("d M, Y", $items->commentDate) ."
                                <i class='icon-pencil'></i> <a>{$items->commentName}</a><br>
                            
                            ".stripcslashes($items->commentDescriptions)."
                        </div>
                    </li><br>";
                }
                ?>
            </ul>
        </div>

    </div><!--end span9-->
    </div>
    
    
</div><!--end row-->
</div>
<?php include_once('forms/form_end.php'); ?>