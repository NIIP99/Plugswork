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

namespace Plugswork\Task;

use pocketmine\scheduler\PluginTask;
use Plugswork\Plugswork;

class PwTiming extends PluginTask{
    
    private $plugin;
    private $lastMemUse;
    
    public function __construct(Plugswork $plugin){
    	parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    
    public function onRun($tick){
        $player = count($this->plugin->getServer()->getOnlinePlayers())."/".$this->plugin->getServer()->getMaxPlayers();
        /*if(empty($this->lastMemUse)){
            $memDiff = memory_get_usage();
        }else{
            $memDiff = $this->lastMemUse - memory_get_usage();
        }
        $memlimit = ini_get('memory_limit');
        echo $memDiff."/".$memlimit;*/
        $this->plugin->api->update($player);
    }
}