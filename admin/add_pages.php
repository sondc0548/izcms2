<?php require("../includes/connect.php"); ?>
<?php require("../includes/header.php") ;?>
<?php require("../includes/sidebar_admin.php") ;?>
    	<?php
			if(isset($_POST['submit'])){
				$error = array(); // tao flag
				if(empty($_POST['page_name'])){
					$error[] = "page_name";	
				} else {
					$page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page_name']));
					// hàm mysqli_real_escape_string chống sql injection
					// hàm strip_tags chống crossside script
					// lưu ý : phải có biến $dbc là tham số
				}
				if(isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range' => 1))){
					$cat_id = $_POST['category']; // chỉ lấy giá trị cat_id rồi gán vào biến
				} else {
					$error[] = "category";	
				}
				if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' =>1))){
					$pos = $_POST['position'];
				} else {
					$error[] = "position";		
				}
				if(empty($_POST['content'])){
					$error[] = 'content';
				} else {
					$content = mysqli_real_escape_string($dbc, $_POST['content']);
					// phần content ko cần dùng hàm strip_stags	-> cho người dùng nhập nội dung in đậm, in nghiêng, ...										 					// cho nó chạy qua hàm htmlentities để chồng cross side script
				}
				if(empty($error)){ // nếu ko có lỗi thi chèn vào csdl
					$q = "INSERT INTO page( user_id, cat_id, page_name, content, position, post_on ) 
					      VALUES(3, {$cat_id},'{$page_name}','{$content}', $pos, NOW())";
					$r = mysqli_query($dbc,$q);	  
					if(mysqli_affected_rows($dbc) == 1){
						$message = "<p class='success'>The page was added successfully</p>";
					} else {
						$message = "<p class='warning'>The page could not added due to a system error</p>";
					}
				 } else {
						$message = "<p class='warning'> please fill all required fill</p>";
				 }					
			}// end  main IF submit
        ?>
  <div id="content">
        <h2>Create a Page</h2>
        <?php if(!empty($message)) echo $message ; ?>
        <form id="login" action="" method="post">
            <fieldset>
            	<legend>Add a Page</legend>
                    <div>
                        <label for="page">Page Name: <span class="required">*</span>
                           <?php	
								if(isset($error) && in_array('page_name',$error)){
									echo "<p class='warning'> Please fill in the page name </p>";						   
								}
						   ?>
                        </label>
                        <input type="text" name="page_name" id="page_name" value="<?php if(isset($_POST['page_name'])) echo strip_tags( $_POST['page_name']) ; ?>" size="20" maxlength="80" tabindex="1" />
                    </div>
                    
                    <div>
                        <label for="category">All categories: <span class="required">*</span>
                            <?php
                            	if(isset($error) && in_array('category',$error)){
									echo "<p class='warning'>Please pick a category</p>";
								}
							?>
                        </label>                       
                        <select name="category">
                        	<option>Select a category</option>
                            <?php
                            	$q = "SELECT cat_id, cat_name FROM categories ORDER BY position";
								$r = mysqli_query($dbc,$q) or die("Query {$q} \n<br/> Mysql error: ".mysqli_error($dbc));
								if(mysqli_num_rows($r) > 0){ // có nhiều giá trị trả về
									while($cats = mysqli_fetch_array($r,MYSQLI_NUM)){ 
									// gán giá trị của mảng mysqli_fetch_array vào biến $cats
									// dùng tham số MYSQLI_NUM sẽ nhanh hơn vì ở đây chỉ lấy 2 giá trị là cat_id, cat_name
									// => gán cat_id == $cats[0], cat_ name == $cats[1]
										echo "<option value='$cats[0]'" ; 
										if(isset($_POST['category']) && $_POST['category'] == $cats[0]) echo "selected='selected'";
								    // nếu tồn tại $_POST['category'] và $_POST['category'] == cat_id => $cat[0]) -> lựa chọn
										echo ">".$cats[1]."</option>";
									}
								}
							?>
                        </select>
                    </div>
                    <div>
                        <label for="position">Position: <span class="required">*</span>
                            <?php 
								 if(isset($error) && in_array('position',$error) ){
                                    echo "<p class='warning'> please pick a position</p>";
								  }
							?>
                        </label>
                        <select name="position">
                           <option>Select a position</option>
                           	<?php
                            	  $q = "SELECT count(page_id) AS count from page";
								  $r = mysqli_query($dbc,$q) or die("Query {$q} \n<br/> Mysql error:" . mysqli_error($dbc));
								  if(mysqli_num_rows($r)==1){
									  list($num) = mysqli_fetch_array($r,MYSQLI_NUM);
									  for($i=1; $i <= $num+1; $i++){
										  echo "<option value='{$i}'"; 
										  if(isset($_POST['position']) && $_POST['position'] == $i){ echo "selected = 'selected'";}	
										  echo ">".$i."</option>";
									  }
								  }
							?>
                        </select>
                    </div>                
                    <div>
                        <label for="page-content"> content <span class="required">*</span>
                        	<?php
                            	if(isset($error) && in_array('content',$error)){
									echo "<p class='warning'>Please fill in the content </p>";
								}
							?>
                        </label>
                        <textarea name="content" cols="50" rows="20"></textarea>
                    </div>
            </fieldset>
            <p><input type="submit" name="submit" value="Add Page" /></p>
        </form>
    </div><!--end content-->
<?php require('../includes/sidebar-b.php') ;?>
<?php require('../includes/footer.php') ;?>

   