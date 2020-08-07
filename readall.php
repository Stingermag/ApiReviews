<?php
{
	$server_name = "localhost";
	$user_name = "root";
	$password = "password";
	$db_name = "api_review";

	$mysqli = new mysqli($server_name,$user_name,$password,$db_name);
	$mysqli->set_charset("utf8");

	
	
	 $res = $mysqli->query("SELECT COUNT(*) as count FROM reviews");
	
	 $row = $res->fetch_object();


	if("$row->count" > 0)
	{
		$strquery = "SELECT id,  name, raiting, photos FROM reviews";


		$strrait = isset($_GET['strrait']) ? $_GET['strrait'] : '';
		$srtdate = isset($_GET['srtdate']) ? $_GET['srtdate'] : '';		


		$strquery = $strquery." ORDER BY ";	
		if(!strcasecmp($strrait, "desc") && (!empty($strrait)))
		{
			$strquery = $strquery. " raiting DESC ";

			if(!strcasecmp($srtdate, "desc") && (!empty($srtdate)))
			{
				$strquery = $strquery. ", date DESC";
			}
			else
			{
				$strquery = $strquery. ", date ASC";
			}
		}
		else
		{
			$strquery = $strquery." raiting ASC ";

			if(!strcasecmp($srtdate, "desc") && (!empty($srtdate)))
			{
				$strquery = $strquery. ", date DESC";
			}
			else
			{
				$strquery = $strquery. ", date ASC";
			}
		}


			

		




		$result = $mysqli->query($strquery);
		$i = 1;
		$j = 0;
		while ($rows = $result->fetch_object()) 
		{


			$arr = explode(' ',trim($rows->photos));
			$arrayName['page'.$i][] = array(
				'id' => $rows->id,
				'name' => $rows->name,
				'raiting' => $rows->raiting,
				'mainphoto' => $arr[0]  
			);
			$j++;

			if($j == 10){
				$i++;
				$j = 0;

			}


		}
		
		
		
		$data = json_encode($arrayName, JSON_UNESCAPED_UNICODE);


		print_r($data) ;

	}
	else
	{

		$arrayName = array('message' => "Бд пуста" );
		$data = json_encode($arrayName, JSON_UNESCAPED_UNICODE);


		echo $data;
	}
}