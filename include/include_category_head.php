<?php
class NameHead {

	public function Head() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['subcat'])) {
			$headcat = (int)$_GET['subcat'];

			if ($headcat < 999) {
				$cat = substr($headcat, -3, 1);
			}
			else {
				$cat = substr($headcat, -4, 2);
			}
		}

		$CategoryName = "SELECT * FROM category_head ORDER by name ASC";
		$sql_exec_catname = mysql_Query($CategoryName);

		echo '<li>';
		echo '<a href=".';
		echo '">';
		echo "All";
		echo '</a></li> ';

		while ($ShowDetailsCatname = mysql_fetch_array($sql_exec_catname)) {
			echo '<li>';
			echo '<a href="category.php?cat=';
			echo $ShowDetailsCatname['id'];
			echo '" ';

			// Makes the head category "selected" when that category is viewed.
			if(isset($_GET['cat'])) {
				$cat = (int)$_GET['cat'];
				if ($ShowDetailsCatname['id'] == $cat) {
					echo 'class="selected"';
				}
			}

			// Makes the head category "selected" when a sub category of that category is viewed.
			if(isset($_GET['subcat'])) {
				$headcat = (int)$_GET['subcat'];

				if ($headcat < 999) {
					$cat = substr($headcat, -3, 1);
				}
				else {
					$cat = substr($headcat, -4, 2);
				}

				if ($cat == $ShowDetailsCatname['id']) {
					echo 'class="selected"';
				}
			}


			echo '>';
			echo $ShowDetailsCatname['name'];

			// Shows if component exists in category
			$sql_exec_component_catname = mysql_query("SELECT category FROM data WHERE owner = $owner");
			while($showDetailsComponentCatname = mysql_fetch_array($sql_exec_component_catname)) {

				$component_cat = $showDetailsComponentCatname['category'];
				if ($component_cat < 999) {
					$comp_cat = substr($component_cat, -3, 1);
				}
				else {
					$comp_cat = substr($component_cat, -4, 2);
				}
				if($comp_cat == $ShowDetailsCatname['id']){
					echo ""; // What should be echoed if components exists in category?
					break; // We only need one component to be in this category for this to be true.
				}
			}


			echo '</a></li> ';
		}
	}
}
?>