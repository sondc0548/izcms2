
<?php 
    $title = "Register";
	  require("includes/header.php"); 
	  require("includes/connect.php");
	  require("includes/function_die.php");  	 
 	  require("includes/sidebar_a.php"); 
?>
<div id="content">
<h2>Register</h2>
<form action="register.php" method="post">
    <fieldset>
   	    <legend>Register</legend>
            <div>
                <label for="First Name">First Name <span class="required">*</span></label> 
	           <input type="text" name="first_name" size="20" maxlength="20" value="" tabindex='1' />
            </div>
            
            <div>
                <label for="Last Name">Last Name <span class="required">*</span></label> 
	           <input type="text" name="last_name" size="20" maxlength="40" value="" tabindex='2' />
            </div>
            
            <div>
                <label for="email">Email <span class="required">*</span></label> 
	           <input type="text" name="email" size="20" maxlength="80" value="" tabindex='3' />
            </div>
            
            <div>
                <label for="password">Password <span class="required">*</span></label> 
	           <input type="password" name="password1" size="20" maxlength="20" value="" tabindex='4' />
            </div>
            
            <div>
                <label for="email">Confirm Password <span class="required">*</span> </label> 
	           <input type="password" name="password2" size="20" maxlength="20" value="" tabindex='5' />
            </div>
    </fieldset>
    <p><input type="submit" name="submit" value="Register" /></p>
</form>
</div><!--end content-->
<?php require("includes/sidebar_b.php"); ?>    
<?php require("includes/footer.php"); ?>