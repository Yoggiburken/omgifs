<?php
	
	include_once("mysql.php");
	
	session_start();
	$db = mysqli_connect("localhost", "Blue", "bluetooth", "omgifs") or die(mysql_error());
	$current_gif_id;
	$current_gif_link;
	$current_gif_title;
	if(isset($_GET['id'])) {
		$current_gif_id = $_GET['id'];
		if($current_gif_id > 199) {
			$current_gif_id = 199;
		}
		if($current_gif_id < 0) {
			$current_gif_id = 0;
		}
		$result = mysqli_query($db, "SELECT link_string, link_title, link_id FROM links WHERE link_id={$current_gif_id}") or die(mysql_error());
		$row = mysqli_fetch_array($result);
		$current_gif_id 		= $row['link_id'];
		$current_gif_link 	= $row['link_string'];
		$current_gif_title 	=	$row['link_title'];
	} else {
		$result = mysqli_query($db, "SELECT link_string, link_title, link_id FROM links WHERE link_id=0") or die(mysql_error());
		$row		= mysqli_fetch_array($result) or die(mysql_error());
		$current_gif_id = $row['link_id'];
		$current_gif_link = $row['link_string'];
		$current_gif_title 	=	$row['link_title'];
	}
	$next_gif_id = $current_gif_id +1;
	$previous_gif_id = $current_gif_id -1;
	if($next_gif_id > 199) {
		$next_gif_id = 0;
	}
	if($previous_gif_id < 0) {
		$previous_gif_id = 199;
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<script>
			function showOptions() {
				var element = document.getElementById("options");
				if(element.style.left == "-15px") {
					element.style.left = "-180px";
				} else {
					element.style.left = "-15px";
				}
			}
		</script>
		<?php echo "<style type='text/css'>
			body {
				margin:0px; 
				padding: 0px;
				width:100%;  
				height:100%;  
				background:url('{$current_gif_link}') center center no-repeat; 	
				background-size:contain;  
				overflow:hidden;  
				background-color:#121211;  
				position:relative;  
			}
		</style>" ?>
	</head>
	<body>
		<div id="options">
			<div id="showoptions" onclick="showOptions()"><img id="gear" src="gear.png"/></div>
			<div id="autodiv">
				<div>Auto</div>
				<input id="auto" type="checkbox"></input>
				<div>Timer</div>
				<input id="timer" type="text" size="3"></input>
			</div>
			<div id="redditdiv">
				<div>View on reddit!</div>
				<a href="http://www.reddit.com" target="_blank"><?php echo "www.reddit.com"?></a>
			</div>
		</div>
		<div id="BottomBar" class="bottomcontent">	
			<a id="LeftArrow" class="bottomcontent" href="/omgifs/?id=<?php echo $previous_gif_id; ?>"><img class="rotated" src="omgifs_arrow.svg"/></a>
			<div id="title" class="bottomcontent">
				<?php echo $current_gif_title;?>
			</div>
			<a id="RightArrow"  class="bottomcontent" href="/omgifs/?id=<?php echo $next_gif_id; ?>"><img src="omgifs_arrow.svg"/></a>
		</div>
	</body>
</html>

<?php
	include("user_counter.php");
	$_SESSION['current_gif_id'] = $current_gif_id;
?>
