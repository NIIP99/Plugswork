<?php

/*
$server = proc_open(PHP_BINARY . " src/pocketmine/PocketMine.php --no-wizard --disable-readline", [
	0 => ["pipe", "r"],
	1 => ["pipe", "w"],
	2 => ["pipe", "w"]
], $pipes);

if(!is_resource($server)){
	die('Failed to create process');
}

fwrite($pipes[0], "version\nmakeplugin Plugswork\nstop\n\n");
fclose($pipes[0]);

while(!feof($pipes[1])){
	echo fgets($pipes[1]);
}

fclose($pipes[1]);
fclose($pipes[2]);

echo "\n\nReturn value: ". proc_close($server) ."\n";
*/
$openserver = "php src/pocketmine/PocketMine.php --no-wizard --disable-readline";
$cmd = array("version", "compileplugin Plugswork", "stop");

echo $openserver;
echo $cmd[0];
echo $cmd[1];
echo $cmd[2];

if(count(glob("plugins/ImagicalDevTools/Plugswork*.phar")) === 0){
	echo "No Plugswork phar created!\n";
	exit(1);
}else{
	exit(0);
}
