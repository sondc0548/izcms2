<?php 
	 ob_start();
	 require("../includes/connect.php"); 
 	 require("../includes/function.php") ;
 	 require("../includes/header.php") ;
 	 require("../includes/sidebar_admin.php") ;
?>
<div id="content">
	<?php 
		// kiểm tra biến $_GET['cid'], $_GET['cat_name'] có tồn tại ko ? và kiểm tra kiểu dũ liệu biến $_GET['cid'] có phải kiểu int ko
		if(isset($_GET['pid'],$_GET['pn']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
			$pid = $_GET['pid'];
			$page_name = $_GET['pn'];			
			// nếu tồn tại $pid và $page_name thì xóa page khỏi csdl
			if(isset($_POST['submit'])){
				if(isset($_POST['delete']) && ($_POST['delete'] == 'yes')){
					$q = "DELETE FROM page WHERE page_id = {$pid} LIMIT 1";
					$r = mysqli_query($dbc, $q);
					confirm_query($r, $q);
					if(mysqli_affected_rows($dbc) == 1){
						$message = "<p class='success'> The page was deleted successfully</p>";
					} else {
						$message = "<p class='warning'> The page could not deleted due to a system error</p>";
					}
				} else {
					$message = "<p class='warning'> i thought so too! shouldn't be delete </p>";
				}
			} // end if submit
		} else {
			// nếu ko tồn tại $pid và $page_name điều hướng về trang view_pages.php"
			redirect_to("admin/view_pages.php");
		}
	?>
	<h2>Delete Page:<?php if(isset($page_name)) echo $page_name ;?></h2>
	<?php if(isset($message)) echo $message; ?>
    <form action="" method="post">
       <fieldset>
            <legend>Delete Page:</legend>
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

   