<?php
	if(isset($_POST['user']) && isset($_POST['password'])){
		if($_POST['user'] == "staff" && $_POST['password']){
			ShowStats();
		}
		else {
			ShowLogin();
		}
	}
	else {
		ShowLogin();
	}
	exit();
	
	// Functions ---------------------------------------------------
	
	function ShowLogin() {
		echo '
			<html><body><h1>PDomains Download Tracker</h1>
			<form action="downloadtracker.php" method="post">
			Username:<br>
			<input type="text" name="user"><br><br>
			Password:<br>
			<input type="password" name="password"><br><br>
			<input type="submit" name="submit" value="login">
			</form></body></html>
		';
	}
	
	function ShowStats() {
			$link = mysql_connect('mysql.sdsc.edu:3312','sergey','pd0mains') or die('Could not connect to database.');
			mysql_select_db('pdomains') or die('Unable to select database.');
			$query = "SELECT fname,lname,institution,country,bench1c,bench1,bench2raw,bench2,bench3raw,bench3,ts FROM downloads";
			$result = mysql_query($query);
			
			echo '
			<html><body><h1>PDomains Download Tracker</h1>
			<table border="1">
				<tr>
					<td>#</td><td>Name</td><td>Institution</td><td>Country</td><td>Bench 1 Cons</td><td>Bench 1</td><td>Bench 2 Raw</td><td>Bench 2</td><td>Bench 3 Raw</td><td>Bench 3</td><td>Date</td>
				</tr>
			';
			
			$i = 1;
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)) {
					echo '<tr>';
					echo '<td>'. $i .'</td><td>'. $row[0] .' '. $row[1] .'</td><td>'. $row[2] .'</td><td>'. $row[3] .'</td><td>'. MakeFriendly($row[4]) .'</td><td>'. MakeFriendly($row[5]) .'</td><td>'. MakeFriendly($row[6]) .'</td><td>'. MakeFriendly($row[7]) .'</td><td>'. MakeFriendly($row[8]) .'</td><td>' .MakeFriendly($row[9]) .'</td><td>'. $row[10] .'</td>';
					echo '</td>';
					$i++;
				}
			}
			
			echo '</table></form></body></html>';
			
			mysql_free_result($result);
			mysql_close($link);
	}
	
	function MakeFriendly($in){
		if($in == 1){
			return "X";
		}
		return "&nbsp;";
	}

?>