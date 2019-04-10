<?php
	//session_start();
	if(isset($_POST['submit'])){
		 $error = array();
		 if(empty($_POST['name'])){
			 $error[] = "name";
		 } else {
			$name = mysqli_real_escape_string($dbc,strip_tags($_POST['name']));
		 }
		// nêu đi kèm với filter_var -> dùng isset
		 if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			 $email = mysqli_real_escape_string($dbc, strip_tags($_POST['email']));	
		 } else {
			 $error[] = "email";
		 }
		 if(empty($_POST['comment'])){
		 	$error[] = "comment";
		 } else {
			 //ko cần strip_tags vi sẽ cho vào hàm htmlentities ở dưới input form	
			$comment = mysqli_real_escape_string($dbc, $_POST['comment']) ;			
		 }
		 if(isset($_POST['captcha']) && trim($_POST['captcha']) != $_SESSION['q']['answer'] ){
            $error[] = "wrong" ;	
        }
		 // salt pot captcha
		 if(!empty($_POST['question'])){
			 $error[] = "delete";
		 }
		 // honey pot captcha
		 if(!empty($_POST['url'])){
			 redirect_to("thankyou.html");
			 exit();
		 }
		 if(empty($error)){
		     $q = "INSERT INTO comments(page_id, author, email, comment, comment_date) 
                  VALUES({$pid}, '{$name}', '{$email}', '{$comment}', NOW())";	   
			 $r = mysqli_query($dbc,$q);	
			 confirm_query($r,$q);
			 if(mysqli_affected_rows($dbc)==1){
			 	$message = "<p class='success'> Thank for your comment </p>";
			 } else {
			    $message = "<p class='warning'> your comment could not be posted due to a system error</p>";
			 }			 
		 } else {
		 		$message = "<p class='warning'> Please fill in all required field</p>";
		 }
	}
?>
<?php 
	// đồ dl từ CSDL ra form
	$q = "SELECT author, comment, DATE_FORMAT(comment_date,'%b %d %Y') AS date FROM comments WHERE page_id = {$pid}";
	$r = mysqli_query($dbc,$q);
	confirm_query($r, $q);
	if(mysqli_num_rows($r) > 0){ // có comment trong csdl
		echo "<ul id='disscuss'>";
			while(list($author, $comment, $date) = mysqli_fetch_array($r, MYSQLI_NUM)){
				echo "<li class='comment-wrap'>
						<p class='author'>{$author}</p>
						<p class='comment-sec'>{$comment}</p>
						<p class='date'>{$date}</p>
				      </li>";				
			} // end while loop
		echo "</ul>";
	} else { // ko có  comments trong csdl do bị xóa trc đó hoặc ko có
		$message = "<p class='warning'> be the first to leave a comment </p>";
	}
?>

<form id="comment-form" action="" method="post">
<?php if(!empty($message)) echo $message ;?>
    <fieldset>
    	<legend>Leave a comment</legend>
            <div>
            <label for="name">Name: <span class="required">*</span>
            	<?php if(isset($error) && in_array('name',$error)) echo "<p class='warning'> Please fill in the name </p>"; ?>
            </label>
            <input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8' ) ;?>" size="20" maxlength="80" tabindex="1" />
        </div>
        <div>
                <label for="email">Email: <span class="required">*</span>
                <?php if(isset($error) && in_array('email',$error)) echo "<p class='warning'> Please fill in the email </p>"; ?>
                </label>
                <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo strip_tags($_POST['email']) ;?>" size="20" maxlength="80" tabindex="2" />
        </div>
        <div>
            <label for="comment">Your Comment: <span class="required">*</span>
            <?php if(isset($error) && in_array('comment',$error)) echo "<p class='warning'> Please fill in the comment </p>"; ?>
            </label>
            <div id="comment"><textarea name="comment" rows="10" cols="50" tabindex="3"><?php if(isset($_POST['comment'])) echo htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8') ;?></textarea></div>
        </div>
        
        <div>
        <label for="captcha">Answer question with number: <?php echo captcha() ; ?> <span class="required">*</span>
   		<?php if(isset($error) && in_array('wrong', $error)){ echo "<p class='warning'>Please enter a correct answer</p>"; } ?>
        </label>
            <input type="text" name="captcha" id="captcha" value="" size="20" maxlength="10" tabindex="4" />
        </div>
                
        <div>
            <label for="question">Xóa giá trị ở trường dưới trước khi submit: <span class="required">*</span>
            <?php if(isset($error) && in_array('delete', $error)) echo "<p class='warning'> Bạn chưa xóa ở đây</p>"; ?>
            </label>
            <input type="text" name="question" id="question" value="Xóa giá trị này" size="20" maxlength="40" tabindex="5" />
        </div>
        
        <div class="website">
            <label for="website"> Nếu bạn nhìn thấy giá trị này thì ĐỪNG điền gì cả</label>
            <input type="text" name="url" id="url" value="" size="20" maxlength="40" tabindex="5" />
        </div>         
    </fieldset>
    <div><input type="submit" name="submit" value="Post Comment" /></div>
</form>