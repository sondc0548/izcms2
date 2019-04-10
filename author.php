<?php
ob_start();
require('includes/header.php');	
require('includes/connect.php');
require('includes/function.php');
require('includes/sidebar-a.php');
?>
<div id ='content'>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<?php
    	if($uid = validate_id($_GET['uid'])){
			// tìm s và p
			// tìm $page 
			$display = 4;
			// xác định vị trí $start
			$start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range'=>1))) ? $_GET['s'] : 0 ; 
			// nếu tồn tại tham số $_GET['uid'] hợp lệ thì truy xuất csdl
			$q = " SELECT p.page_id, p.page_name, p.content, 
				   DATE_FORMAT(p.post_on,'%b %d %Y') AS date,
				   CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id
				   FROM page AS p
				   JOIN user AS u
				   USING(user_id)
				   WHERE u.user_id = {$uid}
				   ORDER BY date ASC LIMIT {$start}, {$display} ";
			 $r = mysqli_query($dbc,$q);	   
			 confirm_query($r,$q);
			 if(mysqli_num_rows($r) > 0){ // nếu co dl thì hiển thị 
				 while($author = mysqli_fetch_array($r,MYSQLI_ASSOC)){
					 echo "<div class='post'>
					 		   <h2><a href='single.php?pid={$author['page_id']}'>{$author['page_name']}</a></h2>
					 		   <p>".paragraph(catchu($author['content']))."...<a href='single.php?pid={$author['page_id']}'>Read more</a></p>
							   <p class='meta'><strong>Post by:</strong> <a href='author.php?uid={$author['user_id']}'>{$author['name']}</a>| <strong>Post by: </strong>{$author['date']}</p>
					 	  </div>";
				} // end while loop
				echo pagination($uid, $display);	
			 } else {
				 echo "<p class='warning'>The author you are trying to view is no longer available in database</p>";
			 }
		} else {
			// nếu tham số $_GET['uid'] ko hợp lê -> redirect về trang index.php	
			redirect_to();
		}
	?>
</div><!--end content-->   
<?php require('includes/sidebar-b.php');?>
<?php require('includes/footer.php');?>