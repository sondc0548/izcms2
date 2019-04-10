<?php 
	require('includes/header.php');
	require('includes/connect.php');
	require('includes/function.php');
	require('includes/sidebar-a.php');
?>
<div id="content">
    <?php
	// nhận biến $_GET['cid'] truyền xang từ trang sidebar-a.php 
	// kiểm tra xem có tồn tại $_GET['cid'] hay ko và kiểm tra kiểu dữ liệu của nó
	if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
	//if($cid = validate_id($_GET['cid'])){
		$set = get_page_by_cid($cid);
		if (mysqli_num_rows($set) > 0) { // co' page trong csdl, thay $r = $set vì $set lấy kết quả từ hàm get_page_by_id($pid)
			while ($page = mysqli_fetch_array($set, MYSQLI_ASSOC)) {
				echo " <div class='post'>
							<h2><a href='single.php?pid={$page['page_id']}'>{$page['page_name']}</a></h2>
							<p>" . paragraph(catchu($page['content'])) . "...<a href='single.php?pid={$page['page_id']}'>Read more</a></p>
							<p class='meta'><strong>Post by:</strong> <a href='author.php?uid={$page['user_id']}'>{$page['name']}</a> | <strong>Post on:</strong> {$page['date']}</p>
						</div> ";
			} // end while loop
		} else {
			$message = "<p class='warning'>There are currently no page in database</p>";
		}
	} else if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) { // $pid = validate_id($_GET['pid']
		$set = get_page_by_pid($pid); // tối ưu giúp code gọn hơn
		if (mysqli_num_rows($set) > 0) { // nếu có kq trả về hiện ra trình duyệt
			while ($page = mysqli_fetch_array($set, MYSQLI_ASSOC)) {
				echo " <div class='post'>
							<h2><a href='single.php?pid={$pid}'>{$page['page_name']}</a></h2>
							<p class='comments'><a href='single.php?pid={$pid}#disscuss'>{$page['count']}</a></p>
							<p>" . paragraph(catchu($page['content'])) . "...<a href='single.php?pid={$pid}'>Read more</a></p>
							<p class='meta'><strong>Post by:</strong> <a href='author.php?uid={$page['user_id']}'>{$page['name']}</a> | <strong>Post on:</strong> {$page['date']}</p>
						</div> ";
			} // end while loop
		} else {
			// nếu  ko có kq hoặc pid tồn tại  ko hợp lệ(do bị xóa)
			$message = "<p class='warning'> The article you are viewing is not available </p>";
		}
	} else { // nếu ko tồn tại $cid hay $pid mới hiển thị nội dung bên dưới
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
    <?php 
}  ?>
</div>
<!--end content-->
<?php require('includes/sidebar-b.php'); ?>
<?php require('includes/footer.php'); ?> 