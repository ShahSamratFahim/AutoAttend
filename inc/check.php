<?php

date_default_timezone_set('Asia/Dhaka');


$client_list_file = 'clients.txt';

if(!file_exists($client_list_file)){
	$client_list = "Name	MAC";
	  file_put_contents($client_list_file,$client_list); 

}

$client_list = file_get_contents($client_list_file);
$client_list = explode("\n", $client_list);

 $client_list_heading = explode("	", $client_list[0]);

 unset($client_list[0]);

 $clients = array();

foreach ($client_list as $client) {
     $client = explode("	", $client);

     $name = $client[0];
     $mac = preg_replace('/\s*/m', '', $client[1]);

	 $clients[$name] = $mac;
}



// Get the IP adresses

	ob_start();
		system('arp -a');
		$cmd_result = ob_get_contents();
	ob_clean();

	$ip_list = explode("\n", $cmd_result); // Create array for each entry

	unset($ip_list[0],$ip_list[1],$ip_list[2]); // Remove unecessary values
	
	 
//Process each entry

foreach ($ip_list as $value){

    // Remove extra blank space
	$value =explode(" ",  preg_replace('/\s+/', ' ', trim($value))); 

	//Check if the exploded entry has a mac address
	if (isset($value[1])){
		$ip = $value[0]; 
		$mac = strtoupper($value[1]);// uppercase 

		$ip_list_new[$ip] = $mac;
	}

}


	
//Ping each client
foreach ($clients as $name => $mac){

	$ip = array_search($mac, $ip_list_new );
	
	ob_start();
	   system('ping -n 1 '.$ip);
	   $cmd_result = ob_get_contents();
	ob_clean();

	 if (strpos($cmd_result,'Received = 1') != FALSE){
	 	$clients[$name] = 'Online';

}
	else{
		$clients[$name] = 'Offline';

	}

}
	
var_dump($clients);

?>