    <div id="content-container">
        <div id="section-navigation">
    	   <ul class="navi">
         		<?php
					// nhận biến $_GET['cid'] từ chính cau truy vấn của trang sidebar-a
					// từ link echo "<li><a href='index.php?cid={$cat['cat_id']}'" ; 
					// kiểm tra biến $_GET['cid'] có tồn tại và đúng kiểu dữ  liệu ko?
					if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
						$cid = $_GET['cid'];
						$pid = NULL;
					} else if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
						$pid = $_GET['pid'];
						$cid = NULL;
					} else {
						$cid = NULL;
						$pid = NULL;
					}
					// menu 2 cấp
					// câu lệnh truy xuất categories
                	$q = "SELECT cat_name, cat_id from categories ORDER BY position ASC";
					$r = mysqli_query($dbc,$q);
					confirm_query($r,$q);
					// lấy categories từ CSDL
					while($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)){
						echo "<li><a href='index.php?cid={$cat['cat_id']}'" ; 
							if($cat['cat_id'] == $cid) echo " class='selected' " ;
						echo ">".$cat['cat_name']."</a>";
						   // truy xuất bảng page
						   $q1 = "SELECT page_id ,page_name FROM page WHERE cat_id = {$cat['cat_id']} ORDER BY position ASC";
						   $r1 = mysqli_query($dbc,$q1);
						   confirm_query($r1,$q1);
						   // lấy page từ CSDL
						      echo "<ul class='pages'>";
							  		while($page = mysqli_fetch_array($r1, MYSQLI_ASSOC)){
										echo "<li><a href ='index.php?pid={$page['page_id']}' "; 
										    if($page['page_id'] == $pid) echo " class='selected' " ;
										echo ">".$page['page_name']."</a></li>";
									}
							  echo "</ul>";
						echo "</li>";
					}
				?>
    	   </ul>
    </div><!--end section-navigation-->