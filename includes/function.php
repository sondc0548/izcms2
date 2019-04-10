<?php
	// khai bao hằng số BASE_URL để sau này đưa lên host sẽ dễ hơn
	define('BASE_URL','http://localhost/izcms2/');
	function redirect_to($page = 'index.php'){
		$url = BASE_URL.$page;	
		header("location:$url");
	 	exit(); 
	 }
	// kiểm tra xem giá trị trả về có đúng ko
	function confirm_query($result, $query){
		global $dbc;
		if(!$result){
			die("Query {$query} \n<br/> Mysql Error: ".mysqli_error($dbc));
		}
	}
	// hàm  này dùng cho chức năng read more trong trang index, va` trang view_pages.php
	function catchu($text){
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');	// choosng cross side script actrack
		if(strlen($sanitized) > 400 ){ 							// >400 kí tự tiến hành cắt chuỗi
			$cutstring = substr($sanitized,0,400);              // cawts 400 kí tự rồi gán vào biến $cutstring làm mốc
			$word = substr($cutstring, 0, strrpos($cutstring, ' ')); // cắt 400 chũ
			return $word;
		} else {
			return $sanitized ;
		}
	}
	// hàm này thay cho câu lệnh if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1)))
	// giúp code gọn hơn
	function validate_id($id){
		if(isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range'=>1))){
			$val_id = $id;
			return $val_id;
		}else{
			return NULL;	
		}
	}
	// giúp code gọn hơn, dùng trong trang single.php, truy vấn bảng page + user trong csdl
	// hàm xác định trang dựa vào p.page_id ->-> cho menu cấp 1
	function get_page_by_id($id){
			global $dbc;
			$q = "SELECT p.page_name, p.page_id, p.content, ";
			$q.= " DATE_FORMAT(p.post_on,'%b %d %Y') AS date, ";
			$q.= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
			$q.= " FROM page AS p ";
			$q.= " JOIN user AS u ";
			$q.= " USING(user_id) ";
			$q.= " WHERE p.page_id = {$id} ";
			$q.= " ORDER BY date ASC ";
			$result = mysqli_query($dbc,$q);	
			confirm_query($result, $q);			
			return $result;
	}
	// tối ưu giúp code gọn hơn, dùng trong trang index.php, truy vấn bảng page + user
	// hàm xác định trang dựa vào p.cat_id -> cho menu cấp 1
		function get_page_by_cid($id){
			global $dbc;
			$q = " SELECT p.page_name, p.page_id, p.content, ";
			$q.= " DATE_FORMAT(p.post_on,'%b %d %Y') AS date, ";
			$q.= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
			$q.= " FROM page AS p ";
			$q.= " JOIN user AS u ";
			$q.= " USING(user_id) ";
			$q.= " WHERE p.cat_id = {$id} ";
			$q.= " ORDER BY date ASC ";
			$result = mysqli_query($dbc,$q);	
			confirm_query($result, $q);			
			return $result;
	}
	// tối ưu giúp code gọn hơn, dùng trong trang index.php
	function get_page_by_pid($id){
		  global $dbc;	
		  $q = "SELECT p.page_name, p.content, 
				 DATE_FORMAT(p.post_on, '%b %d,  %y') AS date, 
				 CONCAT_WS('  ', u.first_name, u.last_name) AS name, u.user_id,  
				 COUNT(c.comment_id) AS count 
				 FROM user AS u 
				 JOIN page AS p 
				 USING(user_id) 
				 LEFT JOIN comments AS c 
				 ON p.page_id = c.page_id 
				 WHERE p.page_id = {$id} 
				 GROUP BY p.page_name 
				 ORDER BY date ASC ";
			$result = mysqli_query($dbc,$q);	 
			confirm_query($result,$q);
			return $result;
	}
	
	// tạo paragraph từ csdl, dùng trong trang single.php
	function paragraph($text){
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');// chống crossside script trong phần content
		return str_replace(array("\r\n", "\n"),array("<p>","</p>"),$sanitized);	// THAY $TEXT = $SANITIZED
	}
	// function captcha dùng trong trang comment_form.php để chống spam
	function captcha(){
			$qna = array( 
						   1 => array('question' => 'ăn 1 quả khế trả ... cục vàng', 'answer' => 1 ),	
						   2 => array('question' => 'Xe đạp có mấy bánh ?', 'answer' => 2 ),	
						   3 => array('question' => 'Con chó có mấy chân ?', 'answer' => 4 ),	
						   4 => array('question' => 'Con gà có mấy cánh ?', 'answer' => 2 ),	
						   5 => array('question' => 'Thằng bờm có mấy cái quạt mo ?', 'answer' => 1 ),	
						   6 => array('question' => 'Phú ông xin đổi mấy con bò ?', 'answer' => 3 )				
						 );	
			$rand_key = array_rand($qna);
			$_SESSION['q'] = $qna[$rand_key];
			return $question = $qna[$rand_key]['question']; 
	 } // end function 
   // hàm phân trang
   function pagination($uid, $display = 4){
	   	  global $dbc; 
		  global $start;
	      if(isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range'=>1))){
				$page = $_GET['p'];
			} else {
				// nếu ko có biến p sẽ truy vấn csdl để tìm xem có bao nhiêu page để hiển thị	
				$q = "SELECT COUNT(page_id) FROM page" ;	
				$r = mysqli_query($dbc,$q);
				confirm_query($r,$q);
				list($record) = mysqli_fetch_array($r, MYSQLI_NUM);
				if($record >$display){
					$page = ceil($record/$display);
				} else {
					$page = 1;
				}
			}
	   // Phân trang
		$output = "<ul class='pagination'>";
			if($page > 1){ // nếu tổng số trang >1 -> phân trang
				$current_page = ($start/$display) + 1 ; // +1 bù cho trường hợp ban đầu khi $start = 0
				$next = $start + $display ;
				$prev = $start - $display;
				if($current_page != 1){ // nếu  ko phải ở trang 1 _ xuất hiện nút Prev
					$output .= "<li><a href='author.php?uid={$uid}&s=0&p={$page}' class='link'>First</a></li>"; //->nút First xuất hiện khi s = 0;
					$output .= "<li><a href='author.php?uid={$uid}&s={$prev}&p={$page}' class='link'>Prev</a></li>"; // -> nút Prev
				}
				//Phân đoạn
				$begin = $current_page - 2;
				if($begin < 1){
					$begin = 1;
				}
				$end = $current_page + 2;
				if($end > $page){
					$end = $page;
				}
				//  tìm các vị trí con lại
				for($i = $begin; $i<= $end; $i++){
					if($current_page == $i){
						$output .= "<li class='active'>$i</li>";	
					} else {
						$Y = ($i-1) * $display;
						$output .= "<li><a href='author.php?uid={$uid}&s={$Y}&p={$page}' class='link'>$i</a></li>";	
					}
				}
				if($current_page != $page){ // nếu  ko ở trang cuối ->  nút Next
					$output .= "<li><a href='author.php?uid={$uid}&s={$next}&p={$page}' class='link'>Next</a></li>";
					$last = ($page-1) * $display;
					$output .= "<li><a href='author.php?uid={$uid}&s={$last}&p={$page}' class='link'>Last</a></li>"; // nut Last
				}
				
			}
		$output .= "<ul>";
		return $output;
		// end phân trang
   }


?>