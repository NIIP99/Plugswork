<?php

#  ____  _                                    _    
# |  _ \| |_   _  __ _ _____      _____  _ __| | __
# | |_) | | | | |/ _` / __\ \ /\ / / _ \| '__| |/ /
# |  __/| | |_| | (_| \__ \\ V  V / (_) | |  |   < 
# |_|   |_|\__,_|\__, |___/ \_/\_/ \___/|_|  |_|\_\
#                |___/                             
# Plugswork - Extends your MCPE Server beyond your imagination!
# Licensed under GNU Lesser General Public License (https://github.com/deotern/Plugswork/blob/master/LICENSE)
# Version: 1.php

namespace Plugswork;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use Plugswork\PlugsworkListener;

class Plugswork extends PluginBase{
    
    //Constants
    const ERR = "§l§4»§r§c ";
    const ALR = "§l§6»§r§e ";
    const SUC = "§l§2»§r§a ";
    
    public $command = null, $onSetup = false;
    
    public function onEnable(){
        new PlugsworkListener($this);
        if(!is_file($this->getDataFolder()."main.yml")){
            echo "- [Plugswork] Do you want to start Plugswork with default settings? [Y/N]\n";
            $command = $this->readCommand();
            if($command == "N"){
                //TODO Load Customized Config
                $this->loadConfig();
            }else{
                $this->loadConfig();
            }
            echo "\n  Plugswork is free software: you can redistribute it and/or modify\n".
                 "  it under the terms of the GNU Lesser General Public License as published by\n".
                 "  the Free Software Foundation, either version 3 of the License, or\n".
                 "  (at your option) any later version.\n\n".
                    
                 "- [Plugswork] Do you accept the license? [Y/N]\n";
            $command = $this->readCommand();
            if($command != "Y"){
                echo "- [Plugswork] You need to accept the license to use Plugswork\n";
                $this->getServer()->getPluginManager()->disablePlugin($this);
            }
        }
    }
    
   private function readCommand(){
        $this->onSetup = true;
	while($this->command === null){ 
            $this->getServer()->checkConsole();
        }
	$r = $this->command;
	$this->command = null;
	$this->onSetup = false;
	return $r;
    }
    
    private function loadConfig(){
        if(!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
        }
        $this->saveDefaultConfig();
        $this->saveResource("auth.yml");
    }
    
    
}