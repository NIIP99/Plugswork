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

namespace Plugswork\Module;

use pocketmine\Player;
use pocketmine\command\ConsoleCommandSender;

use Plugswork\Plugswork;
use Plugswork\Utils\PwLang;
use Plugswork\Task\AutoVoteTask;

class VoteModule{
    
    private $plugin;
    private $cache = [];
    private $key;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    public function load($rawSettings){
        //Settings handler
        $st = json_decode($rawSettings, true);
        if(isset($st["autoVote"])){
            $plugin->getServer()->getScheduler()->scheduleRepeatingTask(new AutoVoteTask($this), $st["autoVoteTime"] * 20);
        }
        $this->key = $st["voteKey"];
    }
    
    public function check($pn){
        if(isset($this->cache[$pn]) && $this->cache[$pn] == 2){
            return 2;
        }
        return file_get_contents("http://minecraftpocket-servers.com/api/?object=votes&element=claim&key=".$this->key."&username=".$pn);
    }
    
    public function claim($pn){
        $res = file_get_contents("http://minecraftpocket-servers.com/api/?action=post&object=votes&element=claim&key=".$this->key."&username=".$pn);
        if($res == 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function reward(Player $p){
        foreach($this->settings["voteCommands"] as $cmd){
            str_replace(
                    array("{USERNAME}","{NICKNAME}"),
                    array($p->getName(),$p->getDisplayName()),
                    PwLang::translateColor($cmd)
            );
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $cmd);
        }
    }
}