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
    private $sID, $sKey = false;
    
    public function __construct(Plugswork $plugin, $options){
        $this->plugin = $plugin;
        if(!isset($options["host"]) || !isset($options["user"]) || !isset($options["password"]) || !isset($options["database"])){
            $this->plugin->getLogger()->error("Invalid MySQL options!");
            return;
	}
        $this->database = new \mysqli($options["host"], $options["user"], $options["password"], $options["database"], isset($options["port"]) ? $options["port"] : 3306);
	if($this->database->connect_error){
            $this->plugin->getLogger()->error("An error occured while connecting to MySQL Server:".$this->database->connect_error);
            return;
	}
    }
    
    public function update($query){
        
    }
    
    public function execute($query){
        
    }
}