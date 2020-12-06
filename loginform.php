<?php 
include_once('includes/globals.php');
include_once('includes/html_head.php');
include_once("forms/form_head.php");
?>

<div class="row">
   
  <div class="col-md-offset-4 col-md-4">



   <div class="panel panel-default">

     <div class="panel-heading"><h1  class="text-center" id="contactus-h1">Log in</h1></div><br>

     <div class="panel-body">

    
      <form id="memberloginform" class="contactForm" method="post" action="<?=_URL_;?>takelogin.php" enctype="multipart/form-data">
    <label>Email / Username / Telephone *</label>
    <input type="text" id="emaillogin" name="emaillogin" value="" class=" form-control contactus-input" required="" /><br/>
    <label>Password *</label>
    <input type="password" id="passwordlogin" name="passwordlogin" value="" class="form-control contactus-input" required="" />
    <input type="hidden" id="memberloginformsubmit" name="memberloginformsubmit" value="true" /><br>
    <input type="submit"  class="btn btn-default"name="memberloginformsubmit">
</form>

     

    </div>
            
   </div>
  </div>
  
</div><br><br>
<?php include_once('forms/form_end.php'); ?> 




