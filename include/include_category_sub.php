<?php
class NameSub {

	public function Sub() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['cat']))
		{
			$cat = intval($_GET['cat']);
		}

		if(isset($_GET['subcat']))
		{
			// convert subcat to cat
			$subcat = intval($_GET['subcat']);
			$SubCategoryName = "SELECT category_id FROM category_sub WHERE id = ".$subcat."";
			$sql_exec_subcatname = mysqli_query($GLOBALS["___mysqli_ston"], $SubCategoryName);
			$ShowDetailsSubCatname = mysqli_fetch_array($sql_exec_subcatname);
			$cat = $ShowDetailsSubCatname["category_id"];
		}

		$SubCategoryName = "SELECT * FROM category_sub WHERE category_id = ".$cat." ORDER by subcategory ASC";
		$sql_exec_subcatname = mysqli_query($GLOBALS["___mysqli_ston"], $SubCategoryName);

		while ($ShowDetailsSubCatname = mysqli_fetch_array($sql_exec_subcatname))
		{
			echo '<li>';
			echo '<a href="category.php?subcat=';
			echo $ShowDetailsSubCatname['id'];
			if(isset($_GET['owner'])){
			   echo "&owner=".htmlentities($_GET['owner']);
 			}
			echo '" ';

			if(isset($_GET['subcat']))
			{
				if ($ShowDetailsSubCatname['id'] == $subcat)
				{
					echo 'class="selected"';
				}
			}

			// Shows if component exists in category
			$sql_exec_component_catname = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT category FROM data WHERE owner = $owner"); // Get the category ID from all components.
			while($showDetailsComponentCatname = mysqli_fetch_array($sql_exec_component_catname)) {
				if($showDetailsComponentCatname['category'] == $ShowDetailsSubCatname['id']){ // Compare current category ID with components category ID.
					echo ' class="isComponents"'; // What should be echoed if components exists in category?
					break; // We only need one component to be in this category for this to be true.
				}
			}

			echo '>';
				echo $ShowDetailsSubCatname['subcategory'];
			echo '</a></li> ';
		}
	}
}
?>
