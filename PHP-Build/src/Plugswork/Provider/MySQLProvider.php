<?php
#  ____  _                                    _    
# |  _ \| |_   _  __ _ _____      _____  _ __| | __
# | |_) | | | | |/ _` / __\ \ /\ / / _ \| '__| |/ /
# |  __/| | |_| | (_| \__ \\ V  V / (_) | |  |   < 
# |_|   |_|\__,_|\__, |___/ \_/\_/ \___/|_|  |_|\_\
#                |___/
# @copyright (c) 2016 All rights reserved, Plugswork
# @author    Plugswork Codx
# @website   https://plugswork.com/

namespace Plugswork\Provider;

class MySQLProvider{
    
    private $plugin;
    private $database;
    
    public function __construct(Plugswork $plugin, $options){
        $this->plugin = $plugin;
        if(!isset($options["host"]) || !isset($options["user"]) || !isset($options["password"]) || !isset($options["database"])){
            $this->plugin->getLogger()->error("Invalid MySQL options!");
            return;
	}
        $this->database = new \mysqli($options["host"], $options["user"], $options["password"], $options["database"], isset($options["port"]) ? $options["port"] : 3306);
	if($this->database->connect_error){
            $this->plugin->getLogger()->error("An error has occured while connecting to the MySQL Server:".$this->database->connect_error);
            return;
	}
        //Create default table
        $this->update("CREATE TABLE IF NOT EXISTS plugswork_main (name VARCHAR(16) PRIMARY KEY, hash CHAR(128), salt CHAR(4), regtime INT, lastlogin INT, lastip VARCHAR(50), money INT);");
    }
    
    public function update($query){
        $this->database->query($query);
    }
    
    public function query($query){
        return $this->database->query($query);
    }
}
