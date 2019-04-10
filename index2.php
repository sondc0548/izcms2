<?php 
	require('includes/connect.php');
 	require('includes/function.php');
	require('includes/header.php') ;
 	require('includes/sidebar-a2.php') ;
?>
    <div id="content">
    <?php
		// nhận tham số $_GET['cid'] từ trang sidebar-a.php truyền xang
		// kiểm tra xem biến $_GET['cid'] có tồn tại ko và kiểu dữ liệu của nó có tồn tại ko?		
		//if($cid = validate_id($_GET['cid'])){ 
		if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
			$set = get_page_by_cid($cid);
			if(mysqli_num_rows($set) > 0){ // có page trong csdl, thay $r = $set vì $set lấy kết quả từ hàm get_page_by_cid($cid)
				while($page = mysqli_fetch_array($set, MYSQLI_ASSOC)){
					echo " <div class='post'>
							<h2><a href='single2.php?pid={$page['page_id']}'>{$page['page_name']}</a></h2>
							<p>".catchu($page['content'])."...<a href='single2.php?pid={$page['page_id']}'>Read more</a></p>
							<p class='meta'><strong>Post by: </strong><a href='author2.php?uid={$page['user_id']}'>{$page['name']}</a>| <strong>Post on:</strong> {$page['date']} </p>
						</div> ";
				} // end while loop
		   } else {
			    $message = "<p>There are currently no post in database</p>";
		   }
	   } else if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1))){//$pid = validate_id($_GET['pid'])
		   $set = get_page_by_pid($pid);
			if(mysqli_num_rows($set) > 0){ // có $page trong csdl
				while($page = mysqli_fetch_array($set, MYSQLI_ASSOC)){
					echo " <div class='post'>
							<h2><a href='single2.php?pid={$pid}'>{$page['page_name']}</a></h2>
							<p class='comments'><a href='single2.php?pid={$pid}#disscuss'>{$page['count']}</a></p>
							<p>".catchu($page['content'])."...<a href='single2.php?pid={$pid}'>Read more</a></p>
							<p class='meta'><strong>Post by: </strong><a href='author2.php?uid={$page['user_id']}'>{$page['name']}</a> | <strong>Post on: </strong> {$page['date']} </p>
						</div> ";
				} // end while loop
			} // end if 
		  } else {
	?>
        <h2>Welcome To izCMS</h2>
        <div>
            <p>
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
            </p>
            
            <p>
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
            </p>
            
            <p>
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
            </p>
        </div>
        <?php  } ?>
    </div><!--end content-->
<?php require('includes/sidebar-b.php') ;?>
<?php require('includes/footer.php') ;?>

   