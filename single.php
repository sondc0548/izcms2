<?php
	ob_start();
	require('includes/connect.php');
 	require('includes/function.php');
	// nhận tham số $_GET['pid'] từ trang sidebar-a.php truyền xang
	// kiểm tra xem biến $_GET['pid'] có tồn tại ko và kiểu dữ liệu của nó có tồn tại ko?		
		if($pid = validate_id($_GET['pid'])){ //nếu $pid họp  lệ truy xuất bảng page + user đổ dl ra trình duyệt
			$set = get_page_by_id($pid);      // thay $r = $set vì $set lấy kết quả từ hàm get_page_by_id($pid)
			$post = array();                  // tạo 1 mảng rỗng để luu gia tri va su dung sau nay cho phan noi dung
			if(mysqli_num_rows($set) > 0){    //có page trong csdl, thay $r = $set vì $set lấy kết quả từ hàm get_page_by_id($pid)
				$page = mysqli_fetch_array($set, MYSQLI_ASSOC);
				$title = $page['page_name']; // đặt tên cho trang sẽ gọi ra trong phần header => tốt cho SEO
				$post[] = array( // gán giá trị của array vào mảng $post ở trên
							'page_name' => $page['page_name'],	
							'content' => $page['content'],
							'author' => $page['name'],
							'post_on' => $page['date'],
							'uid' => $page['user_id']
				          );				
			} else {
				$message = "<p>There are currently no post in database</p>";
			}
		} else {
			redirect_to(); // nếu ko tồn tại $pid thì điều hướng về trang index.php
		}	
	require('includes/header.php') ;
 	require('includes/sidebar-a2.php') ;
?>
    <div id="content">
    <?php
			foreach($post as $value) { // lặp mảng ở trên và xuất ra trình duyệt = foreach
					// gọi hàm paragraph() để chia đoạn văn bản trong phần content
					echo " <div class='post'>
							<h2>{$value['page_name']}</h2>
							<p>".paragraph($value['content'])."</p> 
							<p><strong>Post by: </strong><a href='author.php?uid={$value['uid']}'>{$value['author']}</a>| <strong>Post on:</strong> {$value['post_on']} </p>
						   </div> ";
			}	
	?>    
    <?php 	require('includes/comment_form.php') ;	?>
    </div><!--end content-->
<?php require('includes/sidebar-b.php') ;?>
<?php require('includes/footer.php') ;?>

   