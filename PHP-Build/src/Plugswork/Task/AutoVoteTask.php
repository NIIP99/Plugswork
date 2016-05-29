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

class AutoVoteTask extends PluginTask{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin){
    	parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    
    public function onRun($tick){
        foreach($this->plugin->getSevrer()->getOnlinePlayers() as $p){
            $pn = $p->getName();
            if($this->plugin->vote->check($pn) == 1){
                if($this->plugin->vote->claim($pn)){
                    $this->plugin->vote->reward($p);
                }
            }
        }
    }
}