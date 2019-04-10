<?php 
 require("../includes/connect.php"); 
 require("../includes/function.php") ;
 require("../includes/header.php") ;
 require("../includes/sidebar_admin.php") ;
?>
<div id="content">
	<h2>Manage Pages</h2>
    <table>
    	<thead>
    		<tr>
    			<th><a href="view_pages.php?sort=page">Page name</a></th>
    			<th><a href="view_pages.php?sort=on">Post on</th>
    			<th><a href="view_pages.php?sort=by">Posted by</th>
                <th>Content</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
		</thead>
        <tbody>
		<?php
			if(isset($_GET['sort'])){
				switch( $_GET['sort'] ){
					case 'page':
						$order_by = "page_name";
					break;

					case 'on':
						$order_by = "date";
					break;

					case 'by':
						$order_by = "name";
					break;

					default:
					 $order_by = "date";
					break; 
				} // end switch
			} else {
				$order_by = "date";
			}
			// truy xuất csdl để hiển thị categories
			$q = "SELECT p.page_id, p.page_name, p.content, DATE_FORMAT(p.post_on, '%b %d %Y') AS date, CONCAT_WS(' ', first_name, last_name) AS name ";
			$q .= " FROM page AS p ";
			$q .= " JOIN user AS u"; 
			$q .= " USING(user_id) ";
			$q .= " ORDER BY {$order_by} ASC ";
			$r = mysqli_query($dbc,$q);
			confirm_query($r,$q);
			if(mysqli_num_rows($r) > 0 ){ // nếu có page thì hiển thị ra trình duyệt
				while($page = mysqli_fetch_array($r, MYSQLI_ASSOC)){
					echo "
						<tr>
							<td>{$page['page_name']}</td>
							<td>{$page['date']} </td>
							<td>{$page['name']}</td>
							<td>".catchu($page['content'])."</td>
							<td><a class='edit' href='edit_page.php?pid={$page['page_id']}'>Edit</a></td>
							<td><a class='delete' href='delete_page.php?pid={$page['page_id']}&pn={$page['page_name']}'>Delete</a></td>
						</tr>
					";
				}// end while
			} else {
				// nếu ko có page để hiển thị báo lỗi, hoặc báo người dùng add page
				$message = "<p class='warning'> There are no any page in database, please create a page first</p>";
			}
		?>
    	</tbody>
    </table>
</div><!--end content-->
<?php require('../includes/footer.php') ;?>

   