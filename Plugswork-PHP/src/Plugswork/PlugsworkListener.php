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

use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\utils\TextFormat;

class PlugsworkListener implements Listener{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin){
	Server::getInstance()->getPluginManager()->registerEvents($this, $plugin);
        $this->plugin = $plugin;
    }
    
    public function onCommand(ServerCommandEvent $e){
        if($this->plugin->onSetup){
            $this->plugin->command = $e->getCommand();
            $e->setCommand("");
            $e->setCancelled();
        }
    }
}