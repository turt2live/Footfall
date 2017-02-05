<?php

require_once('includes/dbconnect.php');
header('Content-type: application/json');

if (ini_get('magic_quotes_gpc')) {
    foreach ($_GET as $k => $v) {
        $_GET[$k] = stripslashes($v);
    }
    foreach ($_POST as $k => $v) {
        $_POST[$k] = stripslashes($v);
    }
}

// Setup search parameters
if (isset($_GET['interval']) && intval($_GET['interval'])) {
    $interval = intval($_GET['interval']);
} else {
    $interval = 3600; // 1 hour (seconds)
}

$query = "
    SELECT FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timestamp)/" . $interval . ")*" . $interval . ") AS timekey,
           SUM(event) as movement,
           SUM(IF(event > 0, event, 0)) AS peoplein,
           SUM(IF(event < 0, ABS(event), 0)) AS peopleout,
           zone
    FROM data
    WHERE DATE(timestamp) = DATE(NOW())
    GROUP BY timekey, zone
    ORDER BY timekey ASC
";

$get = $DBH->prepare($query);
$get->execute();

if(!$get){
    http_response_code(500);
    echo json_encode(array("error" => "Could not execute query. Exit code = " . $get->errorCode()));
    exit;
}

if($get->rowCount() == 0) {
    echo json_encode(array());
    exit;
}

//[
//    {
//        "zone": "my zone",
//        "totals" : {
//            "current_count": 10,
//            "total_in": 10
//        },
//        "events": [
//            { "timekey": "Y-m-d H:i:s", "movement": 0, "people_in": 0, "people_out": 0 }
//        ]
//    }
//]

$zones = array();
while ($row = $get->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($zones[$row["zone"]])) {
        $zones[$row["zone"]] = array("totals" => array("current_count" => 0, "total_in" => 0), "events" => array());
    }

    $zone = $zones[$row["zone"]];
    $zone["totals"]["current_count"] += $row["movement"];
    $zone["totals"]["total_in"] += $row["peoplein"];
    $zone["events"][] = array(
        "timekey" => $row["timekey"],
        "people_in" => $row["peoplein"],
        "people_out" => $row["peopleout"],
        "movement" => $row["movement"]
    );

    $zones[$row["zone"]] = $zone;
}

echo json_encode($zones);
