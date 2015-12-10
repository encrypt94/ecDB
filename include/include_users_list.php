<?php
class User {
	public function UsersList() {

		require_once('login/auth.php');
		include('mysql_connect.php');

		$owner = 0;

		if(isset($_SESSION['SESS_MEMBER_ID']) == true)
		{
			$owner = $_SESSION['SESS_MEMBER_ID'];
		}

		$GetUsersAll = "SELECT member_id, login, count(login) AS components FROM members INNER JOIN data ON members.member_id = data.owner WHERE data.public = 'Yes' AND member_id != $owner GROUP BY login";
		$sql_exec = mysqli_query($GLOBALS["___mysqli_ston"],$GetUsersAll);

		while($showDetails = mysqli_fetch_array($sql_exec)) {
			echo "<tr>";
			echo "<td><a href=\"/?owner=".$showDetails['member_id']."\">".$showDetails['login']."</a></td>";
			echo "<td>".$showDetails['components']."</td>";
			echo "</tr>";
		}
	}
}
?>
