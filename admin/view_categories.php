<?php 
 require("../includes/connect.php"); 
 require("../includes/function.php") ;
 require("../includes/header.php") ;
 require("../includes/sidebar_admin.php") ;
?>
<div id="content">
	<h2>Manage Categories</h2>
    <table>
    	<thead>
    		<tr>
    			<th><a href="view_categories.php?sort=cat">Categories</a></th>
    			<th><a href="view_categories.php?sort=pos">Position</th>
    			<th><a href="view_categories.php?sort=by">Posted by</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
		</thead>
        <tbody>
		<?php
			if(isset($_GET['sort'])){
				switch( $_GET['sort'] ){
					case 'cat':
						$order_by = "cat_name";
					break;

					case 'pos':
						$order_by = "position";
					break;

					case 'by':
						$order_by = "name";
					break;

					default:
					 $order_by = "position";
					break; 
				} // end switch
			} else {
				$order_by = "position";
			}
			// truy xuất csdl để hiển thị categories
			$q = "SELECT c.cat_id, c.cat_name, c.position, c.user_id, CONCAT_WS(' ', first_name, last_name) AS name ";
			$q .= " FROM categories AS c ";
			$q .= " JOIN user AS u"; 
			$q .= " USING(user_id) ";
			$q .= " ORDER BY {$order_by} ASC ";
			$r = mysqli_query($dbc,$q);
			confirm_query($r,$q);
			while($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)){
				echo "
					<tr>
						<td>{$cat['cat_name']}</td>
						<td>{$cat['position']} </td>
						<td>{$cat['name']}</td>
						<td><a class='edit' href='edit_categories.php?cid={$cat['cat_id']}'>Edit</a></td>
						<td><a class='delete' href='delete_categories2.php?cid={$cat['cat_id']}&cat_name={$cat['cat_name']}'>Delete</a></td>
					</tr>
				";
			}
		?>
    	</tbody>
    </table>
</div><!--end content-->
<?php require('../includes/footer.php') ;?>

   