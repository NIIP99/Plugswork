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

use pocketmine\Server;
use pocketmine\scheduler\Task;
use Plugswork\Module\VoteModule;

class AutoVoteTask extends Task{
    
    private $vote;
    
    public function __construct(VoteModule $vote){
        $this->vote = $vote;
    }
    
    public function onRun($tick){
        foreach(Server::getInstance()->getOnlinePlayers() as $p){
            $pn = $p->getName();
            if($this->vote->check($pn) == 1){
                if($this->vote->claim($pn)){
                    $this->vote->reward($p);
                }
            }
        }
    }
}