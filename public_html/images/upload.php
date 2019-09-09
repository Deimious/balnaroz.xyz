<?php

	//initialize status message
	$statusline = '';

	//file upload path
	$target_dir = '/home/djbzf5/balnaroz.xyz/public_html/images/uploads/';

	//get the file name
	$filename = basename($_FILES['file']['name']);

	//take the directory of the stored images and concat the filename to the end to get the full image path
	$target_path = $target_dir . $filename;

	//get the extension of the file
	$file_type = pathinfo($target_path,PATHINFO_EXTENSION);

	//check that an image was submitted via post
	if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {

		//get the file size
		$size = filesize($_FILES["file"]["tmp_name"]);
		//echo $size;
		if($size >= 2048000){

			die("Please select a file that is < 2MB");
		}

		//allow certain file formats
		$allowed_exts = array('jpg','png','jpeg','gif','pdf','zip');

		//check to see if the retrieved file type exists in the permitted file types
		if(in_array($file_type, $allowed_exts)){

			//upload file to server
			if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)){
				//database info
				$host = 'localhost';
				$uname = 'baal';
				$pwd = 'Azazel15';
				$name = 'wdc2';
				$db = new mysqli($host,$uname,$pwd,$name);
				if($db->connect_error){
					$statusline = "error connecting to DB<br/>";
					echo $statusline;
					die("DB Connection failed: " . $db->connect_error);
				}
				$timestamp = date("Y-m-d H:i:s");
				$del_query = "delete from images where fpath = '$target_path'";
				$delete = $db->query($del_query);
				$query = "insert into images (path,size,type,fpath,uploaded) VALUES ('$target_dir',$size,'$file_type','$target_path','$timestamp');";
				//echo "dir = $target_dir,<br/>  size = $size,<br/> type = $file_type,<br/> path = $target_path,<br/> date = $timestamp,<br/> query = $query<br/>";
				
				$insert = $db->query($query);
				if(!$insert){
					echo "failed to insert into the database<br/><br/><br/>";
				}
				$statusline = "The file ".$filename. " has been uploaded.";
			}else{
				//status line for failed upload
				$statusline = "<h1>Sorry, there was an error uploading your file. Ensure your file is < 2MB and try again.</h1>";
			}
		}else{
			//status line for bad extension
			$statusline = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
		}
	}else{
		//status line for empty uploads
		$statusline = 'Please select a file to upload.';
	}

	//display status line
	echo $statusline;

	header("Location:view.php");

?>
