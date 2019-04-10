<div id="content-container">
        <div id="section-navigation">
    	   <ul class="navi"> <!-- Menu cấp 1-->
            <?php
			    // xác định cat_id có được chọn ko để tô đậm link
                if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
                    $cid = $_GET['cid']; // chọn cat_id => $pid == null
                    $pid = NULL; 
                } elseif(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
                    $pid = $_GET['pid']; // chọn page_id => $cid == null
                    $cid = NULL;
                } else {
                    $cid = NULL; // ban đầu mới truy cập vào ko chọn cat hay page => NULL
                    $pid = NULL;
                }
                // menu 2 cấp
                // truy xuat bang categories
                $q = "SELECT cat_name, cat_id from categories ORDER BY position ASC";
                $r = mysqli_query($dbc,$q);
                confirm_query($r,$q);
                // lấy categories từ csdl
                while($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                    echo "<li><a href='index2.php?cid={$cat['cat_id']}'"; 
                    if($cat['cat_id'] == $cid) echo " class = 'selected' " ; // xác định trang người dùng chọn sẽ in đâm lên
                    echo ">".$cat['cat_name']."</a>";
                        // truy xuất bảng  page
                        $q1 = "SELECT page_id, page_name FROM page WHERE cat_id = '{$cat['cat_id']}' ORDER BY position ASC";
                        $r1 = mysqli_query($dbc,$q1);
                        confirm_query($r1,$q1);
                        echo "<ul class='pages'>"; // menu cấp 2
                            while($page = mysqli_fetch_array($r1, MYSQLI_ASSOC)){ // lấy page từ csdl
                                echo "<li><a href='index2.php?pid={$page['page_id']}'"; 
                                if($page['page_id'] == $pid) echo " class = 'selected' "; // xác định trang người dùng chọn sẽ in đâm lên
                                echo ">".$page['page_name']."</a></li>";
                            } // end while page
                        echo "</ul>"; // end menu cap 2 page
                    echo "</li>"; // end first  li
                } // end while $cat
            ?>
    	   </ul>
    </div><!--end section-navigation-->