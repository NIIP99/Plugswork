<?php

#  ____  _                                    _    
# |  _ \| |_   _  __ _ _____      _____  _ __| | __
# | |_) | | | | |/ _` / __\ \ /\ / / _ \| '__| |/ /
# |  __/| | |_| | (_| \__ \\ V  V / (_) | |  |   < 
# |_|   |_|\__,_|\__, |___/ \_/\_/ \___/|_|  |_|\_\
#                |___/                             
# Plugswork - Extends your MCPE Server beyond your imagination!
# Version: 1.php
# Copyright & License: (C) 2016 Plugswork
# Licensed under MIT (https://github.com/deotern/Plugswork/blob/master/LICENSE)

namespace Plixware;

use pocketmine\plugin\PluginBase;

class Plixware extends PluginBase{
    
    //Constants
    const ERR = "§l§4»§r§c ";
    const ALR = "§l§6»§r§e ";
    const SUC = "§l§2»§r§a ";
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
    }
}