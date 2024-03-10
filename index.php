<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

include_once("libs/maLibSQL.php");
include_once("libs/maLibUtils.php");

include_once("models/sensor.php");

//get request method
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") die("ok - OPTIONS");

//it is the return variable
$data = array("version" => 2.1);
$data["success"] = false;
$data["status"] = 400;


if (validate("request")) {

    $requestParts = explode('/', $_REQUEST["request"]);

    if (count($requestParts) == 2) {

        $action = $method . "/" . $requestParts[1]; 

        if ($requestParts[0] == "sensor") {
            sensorRequests($data, $action);
        }

    }
}


switch ($data["status"]) {
	case 200: header("HTTP/1.0 200 OK");
		break;
	case 201: header("HTTP/1.0 201 Created");
		break;
	case 202: header("HTTP/1.0 202 Accepted");
		break;
	case 204: header("HTTP/1.0 204 No Content");
		break;
	case 400: header("HTTP/1.0 400 Bad Request");
		break;
	case 401: header("HTTP/1.0 401 Unauthorized");
		break;
	case 403: header("HTTP/1.0 403 Forbidden");
		break;
	case 404: header("HTTP/1.0 404 Not Found");
		break;
	default:
		header("HTTP/1.0 200 OK");
}

echo json_encode($data);

?>