<?php

function sensorRequests(&$data, $action) {
    if ($action == "GET/LAB_ON") 
        getLabOnView($data);
    else 
        $data["status"] = 404;
}

function getLabOnView(&$data) {

    $sql = "SELECT valor FROM sensor WHERE nome = 'LAB_ON'";

    $result = SQLGetChamp($sql);

    if (gettype($result) == "boolean" && $result == false) 
        $data["status"] = 400;
    else {
        setData($data, true, 200);
        $data["LAB_ON"] = $result;
    }
}

?>