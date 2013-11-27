<?php
	mysqli_query($db, "UPDATE views SET gifs_shown = gifs_shown + 1") or die(mysqli_error());
	if(!isset($_SESSION['current_gif_id'])) {
		mysqli_query($db, "UPDATE views SET visits = visits + 1") or die(mysqli_error());
		$unique_ips = mysqli_query($db, "SELECT unique_ip FROM unique_visitors") or die(mysqli_error());
		$rows = array();	
		while($row = mysqli_fetch_array($unique_ips)) {
			array_push($rows, $row['unique_ip']);
		}
		if(check_if_unique_ip($rows)) {
			$ip_address = $_SERVER["REMOTE_ADDR"];
			mysqli_query($db, "INSERT INTO `unique_visitors` (`unique_ip`) VALUES ('$ip_address')");
			mysqli_query($db, "UPDATE views SET unique_visitors = unique_visitors + 1");
		}
	}

	function check_if_unique_ip($ips) {
		foreach($ips as &$row) {
			if($row == $_SERVER["REMOTE_ADDR"]) {
				return false;
			}
		}
		return true;
	}
?>
