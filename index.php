<?php

header('Content-type: application/json');

$action = $_REQUEST['action'];
$station = $_REQUEST['station'];

$stations = array (
	  'BAL'
	, 'BAW'
	, 'BEE'
	, 'BRI'
	, 'CCK'
	, 'CHA'
	, 'CHE'
	, 'COW'
	, 'CPK'
	, 'DUN'
	, 'GAL'
	, 'GLE'
	, 'HAR'
	, 'KIL'
	, 'LAU'
	, 'LEO'
	, 'MIL'
	, 'RAN'
	, 'SAN'
	, 'STI'
	, 'STS'
	, 'WIN'
	, 'ABB'
	, 'BEL'
	, 'BLA'
	, 'BLU'
	, 'BUS'
	, 'CIT'
	, 'CON'
	, 'COO'
	, 'CVN'
	, 'DRI'
	, 'FAT'
	, 'FET'
	, 'FOR'
	, 'FOU'
	, 'GDK'
	, 'GOL'
	, 'HEU'
	, 'HOS'
	, 'JAM'
	, 'JER'
	, 'KIN'
	, 'KYL'
	, 'MUS'
	, 'MYS'
	, 'RED'
	, 'RIA'
	, 'SAG'
	, 'SDK'
	, 'SMI'
	, 'SUI'
	, 'TAL'
	, 'TPT'
);


/**
 * Return the contents of stations.json
 */
if ($action == 'stations') {
	$json = file_get_contents('stations.json');
	echo $json;
	exit;
}

if ($action == 'times' && in_array($_GET['station'], $stations)) {
	getStationTimes($station);
	exit;
} else {
	$error = new stdClass();
	$error->message = "Unknown station";
	echo json_encode($error);
	exit;
}



function getStationTimes($station) {
	// Awful hack, encrypt needs to be a string for some unknown reason.
	$queryParams = array(
		  'encrypt' => 'false'
		, 'stop' => $station
		, 'action' => 'forecast'
	);

	$baseUrl = 'http://luasforecasts.rpa.ie/xml/get.ashx';

	$xmlContents = file_get_contents($baseUrl . '?' . http_build_query($queryParams));
	$xml = simplexml_load_string($xmlContents);

	$time = new stdClass();
	$time->message = (string)$xml->message;

	foreach ($xml->direction[0]->tram as $key => $tram) {
		$timeEntry = new stdClass();
		$timeEntry->direction = "Inbound";
		
		$attribs = current($tram->attributes());

		$timeEntry->dueMinutes = (string)$attribs['dueMins'];
		$timeEntry->destination = (string)$attribs['destination']; 
		$time->trams[] = $timeEntry;
	}

	foreach ($xml->direction[1]->tram as $key => $tram) {
		$timeEntry = new stdClass();
		$timeEntry->direction = "Outbound";
		
			$attribs = current($tram->attributes());

			$timeEntry->dueMinutes = (string)$attribs['dueMins'];
			$timeEntry->destination = (string)$attribs['destination'];

			$time->trams[] = $timeEntry;
	}

	echo json_encode($time);
}
?>