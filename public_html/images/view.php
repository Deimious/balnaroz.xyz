<?php
	$host = 'localhost';
	$uname = 'baal';
	$pwd = 'Azazel15';
	$name = 'wdc2';
	$db = new mysqli($host, $uname, $pwd, $name);
	if($db->connect_error){
		die("Connection failed: " . $db->connect_error);
	}
	$query = "select * from images";
	$result = is_array($result);
	$result = $db->query($query);
	while($row = $result->fetch_assoc()){
		$fullpath = $row['fpath'];
		$type = $row['type'];
		if($type == 'zip'){
			continue;
		}
		$size = $row['size'];
		$timestamp = $row['uploaded'];
		$fpath = str_replace("/home/djbzf5/balnaroz.xyz/public_html/images/","",$fullpath);
		$name = str_replace("uploads/","",$fpath);
		echo "<div width=\"100%\" style=\"overflow:auto;background-color: #486348;padding: 15px;margin: 20px;\">";
		echo "<img src=\"$fpath\" style=\"float:left;\" height=\"30%\"/><br/>";
		echo "<p style=\"overflow-wrap:break-word;font-family:monospace;font-size:14pt;padding:15px;float:left;overflow:auto;\">Type: $type<br/>";
		echo "Size: $size<br/>";
		echo "Uploaded: $timestamp<br/>";
		echo "Name: $name<br/>";
		echo "Location on disk: $fullpath<br/>";
		echo "</div>";
	}
?>
