<?php

namespace PulseChat;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;

class PulseChat extends PluginBase{
    
    //Constants
    const ERR = "§l§4»§r§c ";
    const ALR = "§l§6»§r§e ";
    const SUC = "§l§2»§r§a ";
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onJoin(PlayerJoinEvent $e){
        
    }
    
}