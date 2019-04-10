<?php 
	ob_start(); 
	require('includes/connect.php');
 	require('includes/function.php');
	// nhận biến $_GET['pid'] truyền xang từ trang sidebar-a.php 
	// kiểm tra xem có tồn tại $_GET['pid'] hay ko và kiểm tra kiểu dữ liệu của nó
	if($pid = validate_id($_GET['pid'])){
			$set = get_page_by_id($pid);
			$post = array(); // tạp 1 mảng rỗng để gán giá trị của phần nội dung sau này để đổ ra trình duyệt
			if(mysqli_num_rows($set) > 0){ // co' page trong csdl
				$page = mysqli_fetch_array($set, MYSQLI_ASSOC) ;
				$title = $page['page_name'];	// đặt tên cho trang sau này sẽ gọi ra trong trang header
				$post[] = array(				// gán giá trị của array thu dc từ biến $page vào mảng rỗng của biến $post ở trên
							  'page_name' => $page['page_name'],
							  'content' => $page['content'],
							  'author' => $page['name'],
							  'post_on' => $page['date'],
							  'uid' => $page['user_id']
							  );
			} else {
				$message = "<p class='warning'>There are currently no page in database</p>";
			}
		} else {
			redirect_to(); // nếu  ko tồn tại $pid thì điều hướng về trang index.php
		}
	require('includes/header.php') ;
 	require('includes/sidebar-a2.php') ;
?>
    <div id="content">
    <?php	
		foreach($post as $value){ // hiển thị giá trị của mảng $post[] thu dc ở trên ra trình duyệt
        // gọi hàm paragraph() để chia đoạn văn bản trong phần content
			echo " <div class='post'>
					<h2>{$value['page_name']}</h2>
					<p>".paragraph($value['content'])."</p>
					<p class='meta'><strong>Post by:</strong> <a href='author2.php?uid={$value['uid']}'>{$value['author']}</a> | <strong>Post on:</strong> {$value['post_on']}</p>
				</div> ";
		}
		require('includes/comment_form2.php') ;
	?> 
    </div><!--end content-->
<?php require('includes/sidebar-b.php') ;?>
<?php require('includes/footer.php') ;?>

   