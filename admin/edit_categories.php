<?php 
	  ob_start(); //  chống lỗi headers already sent by	
	  require("../includes/connect.php");
 	  require("../includes/function.php"); 
	  require('../includes/header.php') ;
	  require('../includes/sidebar_admin.php');
	  	// kiểm tra biến $_GET['cid'] có tồn tại và thuộc kiểu dữ liệu cho phép ko
	        if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range'=>1))){
				$cid = $_GET['cid'];
			} else {
				redirect_to("admin/admin.php");
			}
			if(isset($_POST['submit'])){
				$error = array(); // tạo cờ $error khi chưa có lỗi xảy ra, gán vào một mảng rỗng
				if(empty($_POST['category'])){
					$error[] = "category";
				}else{
					$cat_name = mysqli_real_escape_string($dbc,strip_tags($_POST['category']));	
					// hàm mysqli_real_escape_string(): chống sql ịnection
					// hàm strip_tags(): chống cross side script(vd như chèn câu lệnh javascript vào để điều hướng xang web khác  hay ăn cắp dữ liệu, hay câu lệnh html vào làm vỡ giao diện web)
				}
				if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array( 'min_range' =>1))){
					// hàm filter_var kiểm tra $_POST['position'] nhâp vào số nguyên có giá trị >=1, nếu ko thì gán vào hàm error[] 
					// FILTER_VALIDATE_IN ktra $_POST['position'] có phải số nguyên hay ko? đúng -> true, sai -> false cho vào mảng error[]
					// có tác dụng chống hack
					// array('min_range'=> 1)) mảng số nguyên nhập vào có giá trị >=1
					$position = $_POST['position'];
				}else{
					$error[] = "position";
				}
				if(empty($error)){ // neu ko co loi xay ra thi chen vao csdl
					$q = "UPDATE categories SET cat_name = '{$cat_name}', position = {$position} WHERE cat_id = {$cid} LIMIT 1";
					$r = mysqli_query($dbc,$q);
					confirm_query($r,$q);
					if(mysqli_affected_rows($dbc) == 1){
						$message = "<p class='success'> the category was added successfully</p>";
					}else{
						$message = "<p class='warning'> could not add to the database due a system error </p>";
					}
				}else{ // nếu $cid ko hợp lệ có lỗi xẩy ra thì hiện thông báo
					$message = "<p class='warning'> Please fill all the required field </p>";
				}						
			}// end  main IF submit
        ?>
  <div id="content">
  		<?php
        	$q = "SELECT cat_name, position FROM categories WHERE cat_id = {$cid}";
			$r = mysqli_query($dbc,$q);
			confirm_query($r, $q);
			if(mysqli_num_rows($r)==1){
				// nếu category tồn tại trong csdl, xuất dữ liệu ra trình duyệt dựa vào $cid	
				list($cat_name, $position) = mysqli_fetch_array($r, MYSQLI_NUM);
			} else {
				$message = "<p class='warning'>The category is not exits</p>";
			}
		?>
        <h2>Edit category <?php if(isset($cat_name)) echo $cat_name ;?></h2>
        <?php if(!empty($message)) echo $message ; ?>
        <form action="" method="post" id="add_cat">
        	<fieldset>
                    <legend>Add category</legend>
                        <div>
                            <label for="category">Category Name: <span class="required">*</span>
                                <?php
                                	if(isset($error) && in_array('category',$error)){
										echo "<p class='warning'> Please fill in the category name </p>";
									}
								?>                            
                            </label>
                            <input type="text" name="category" id="category" value="<?php if(isset($cat_name)) echo $cat_name ; ?>" size="20" maxlength="150" tabindex="1" />
                        </div>
                        <div>
                            <label for="position">Position: <span class="required">*</span>
                              <?php if(isset($error) && in_array('position', $error)){
								  		echo "<p class='warning'> Please pick a position </p>" ;
								  }
                              ?>
                            </label>
                            <select name="position" tabindex='2'>
                            	<?php 
									$q = "SELECT count(cat_id) AS count from categories";
									$r = mysqli_query($dbc,$q);
									confirm_query($r,$q);
									if(mysqli_num_rows($r) == 1){
										list($num) = mysqli_fetch_array($r, MYSQLI_NUM); 
										// hàm list sẽ nhanh hơn so với dùng vòng lặp while
										// gán giá trị của mảng thu dc từ hàm mysqli_fetch_array vào biến $num
										// sử dụng tham số MYSQLI_NUM sẽ nhanh hơn vì giá trị nhận về là dạng số 
										for($i=1; $i <= $num+1; $i++){
											echo "<option value='{$i}'";
												if(isset($position) && ($position == $i)){ echo "selected = 'selected'";}
											echo ">".$i."</option>";
										}
									}
								?>        
                            </select>
                        </div>
                </fieldset>
                <p><input type="submit" name="submit" value="Edit Category" /></p>
        </form>
    </div><!--end content-->
<?php require('../includes/sidebar-b.php') ;?>
<?php require('../includes/footer.php') ;?>

   