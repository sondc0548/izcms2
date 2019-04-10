<?php
ob_start();
require('includes/header.php');	
require('includes/connect.php');
require('includes/function.php');
require('includes/sidebar-a.php');
?>
<div id ='content'>
<?php
	// s và p là 2 tham sô dc truyền vào từ đầu
	// tìm vị trí bắt đầu $start và 
		$display = 4;
		$start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range'=>1))) ? $_GET['s'] : 0;
    	if($uid = validate_id($_GET['uid'])){
			// nếu tồn tại $ui thì truye vấn csdl
			$q = "SELECT p.page_id, p.page_name, p.content, 
				  DATE_FORMAT(p.post_on,'%b%d %Y') AS date, 
				  CONCAT(' ',u.first_name, u.last_name) AS name, u.user_id
				  FROM page AS p
				  JOIN user AS u
				  USING(user_id)
				  WHERE	u.user_id = {$uid}
				  ORDER	BY date ASC LIMIT {$start}, {$display}";
			$r = mysqli_query($dbc,$q);	  
			confirm_query($r,$q);
			if(mysqli_num_rows($r) > 0){
				while($author = mysqli_fetch_array($r,MYSQLI_ASSOC)){
				// nếu có DL hiện thị ra trình duyệt
					echo "<div class='post'>
						  <h2><a href='single2.php?pid={$author['page_id']}'>{$author['page_name']}</a></h2>	
						  <p>".paragraph(catchu($author['content']))."...<a href='single2.php?pid={$author['page_id']}'>Read more</a></p>	
						  <p class='meta'><strong>Post by:</strong><a href='author2.php?uid={$author['user_id']}'>{$author['name']}</a>| <strong>Post on: </strong>{$author['date']}</p>
					  </div>";
				} // end while loop
			} else{
				// ko tồn tại author do bị xóa dl ->báo lỗi	
					 echo "<p class='warning'>The author you are trying to view is no longer available in database</p>";
			}
			// phan trang
			echo pagination($uid,$display);
		}else{
		 // nếu tham sô $_GET['uid'] truyền vào ko hợp lê -> điều hướng	về trang index
		 	redirect_to();
		}
	?>
</div><!--end content-->   
<?php require('includes/sidebar-b.php');?>
<?php require('includes/footer.php');?>