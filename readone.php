<?php
$id = $_GET['id'];


$fields = isset($_GET['fields']) ? $_GET['fields'] : '';


if(is_numeric($id))
{
	$server_name = "localhost";
	$user_name = "root";
	$password = "password";
	$db_name = "api_review";

	$mysqli = new mysqli($server_name,$user_name,$password,$db_name);
	$mysqli->set_charset("utf8");

	$res = $mysqli->query("SELECT COUNT(*) as count FROM reviews WHERE id = $id");
	
	$row = $res->fetch_object();


	if("$row->count" > 0)
	{
		$result = $mysqli->query("SELECT name, raiting, discript, photos FROM reviews WHERE id = $id");
		$rows = $result->fetch_object();


		$arr = explode(' ',trim($rows->photos));


		$arrayName = array(
				'name' => $rows->name,
				'raiting' => $rows->raiting,
				'mainphoto' => $arr[0]	
			);
		if(substr_count($fields, "discript")){
			$arrayName['discript'] = $rows->discript;

		}
		if(substr_count($fields, "photos")){		
			$arrayName['photos'] = $rows->photos;

		}

	}
	else
	{

		$arrayName = array('message' => "Запрашиваемого id нет в БД", 'id' => $id );
	}

	
}
else
{
	$arrayName = array('message' => "id не был передан");

}
$data = json_encode($arrayName, JSON_UNESCAPED_UNICODE);
echo $data;