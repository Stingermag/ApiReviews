<?php
$name = $_POST['name'];
$discript = $_POST['discript'];
$raiting = $_POST['raiting'];
$photos = $_POST['photos'];
$today = date("Y-m-d H:i:s");


if(strlen($name) <= 50 && strlen($name) != 0)
{
	if(strlen($discript) <= 1000 && strlen($discript) != 0)
	{
		if($raiting == 1 || $raiting == 2 || $raiting == 3 || $raiting == 4 || $raiting == 5)
		{
			if(substr_count($photos, ' ') <=3 )
			{		


				$server_name = "localhost";
				$user_name = "root";
				$password = "password";
				$db_name = "api_review";

				$mysqli = new mysqli($server_name,$user_name,$password,$db_name);
				$mysqli->set_charset("utf8");




				$result = $mysqli->prepare("INSERT INTO `reviews`(`name`, `discript`, `raiting`, `date`, `photos`) VALUES (?,?,?,?,?)"); 
				$result->bind_param('ssiss', $name,$discript,$raiting,$today,$photos);
				$result->execute();

				$arrayName = array('id' => $mysqli->insert_id, 'return' => "added" );
				$data = json_encode($arrayName, JSON_UNESCAPED_UNICODE);


				echo $data;
				return;

			}					
		}		
	}
}
$arrayName = array('id' => 0, 'return' => "error" );
$data = json_encode($arrayName, JSON_UNESCAPED_UNICODE);
echo $data;



	

