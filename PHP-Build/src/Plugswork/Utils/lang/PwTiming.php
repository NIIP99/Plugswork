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

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use Plugswork\PlugsworkListener;

class PwTiming{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    //Kick if a player is not authed yet
    public function onRun($tick){
        file_get_contents($filename);
    }
}