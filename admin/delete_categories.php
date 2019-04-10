<?php 
 ob_start();
 require("../includes/connect.php"); 
 require("../includes/function.php") ;
 require("../includes/header.php") ;
 require("../includes/sidebar_admin.php") ;
?>
<div id="content">
	<h2>Delete Categories</h2>
    <?php
		// kiểm tra biến ($_GET['cid'],$_GET['cat_name'] có tồn tại ko, biến $_GET['cid'] có thuộc kiểu dữ liệu hợp lệ ko ?
    	if(isset($_GET['cid'],$_GET['cat_name']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
			$cid = $_GET['cid'];
			$cat_name = $_GET['cat_name'];
			if(isset($_POST['submit'])){
				// XỬ lí form
				if(isset($_POST['delete']) && $_POST['delete'] == 'yes') { 
					$q = "DELETE from categories WHERE cat_id = {$cid}";
					$r = mysqli_query($dbc,$q);
					confirm_query($r, $q);
					if(mysqli_affected_rows($dbc)==1){
						$message = "<p class='success'> The category was deleted successfully</p>";
					} else {
						$message = "<p class='warning'> The category was not deleted due to a system error </p>";
					}
				} else {
					$message = "<p class='warning'> i don't want delete this category anymore </p>";
				}
			}
		} else {
			// nếu $cid ko ợp lệ thì điều hướng về trang view_categories.php	
			redirect_to("admin/view_categories.php");
		}
	?>
    <?php if(!empty($message)) echo $message; ?>
	   <form action="" method="post">
       <fieldset>
            <legend>Delete Category: <?php if(isset($cat_name)) echo htmlentities($cat_name, ENT_COMPAT, 'UTF-8') ; ?></legend>
                <label for="delete">Are you sure?</label>
                <div>
                    <input type="radio" name="delete" value="no" checked="checked" /> No
                    <input type="radio" name="delete" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure?');" /></div>
        </fieldset>
       </form>
</div><!--end content-->
<?php require('../includes/footer.php') ;?>

   