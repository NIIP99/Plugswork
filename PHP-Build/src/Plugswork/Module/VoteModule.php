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
    private $voteEnabled = true;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    public function load($rawSettings){
        //Settings handler
        $st = json_decode($rawSettings, true);
        if(!isset($st["enableVote"])){
            $this->voteEnabled = false;
            return;
        }
        if(isset($st["autoVote"])){
            $this->plugin->getServer()->getScheduler()->scheduleRepeatingTask(new AutoVoteTask($this), $st["autoVoteTime"] * 20);
        }
        $this->key = $st["voteKey"];
        $this->commands = explode(",", $st["voteCommands"]);
    }
    
    public function vote(Player $p){
        if($this->voteEnabled){
            $pn = $p->getName();
            if(($res = $this->check($pn)) == 1){
                if($this->claim($pn)){
                     $this->reward($p);
                     $s->sendMessage(PwLang::translate("vote.success"));
                }
            }elseif($res == 0){
                $s->sendMessage(PwLang::translate("vote.notVoted"));
            }elseif($res == 2){
                $s->sendMessage(PwLang::translate("vote.alreadyVoted"));
            }
        }else{
            echo "Player tried to vote, but VoteModule is disabled!";
        }
    }
    
    public function check($pn){
        if(isset($this->cache[$pn])){
            if($this->cache[$pn] == 2){
                return 2;
            }
        }
        $res = file_get_contents("http://minecraftpocket-servers.com/api/?object=votes&element=claim&key=".$this->key."&username=".$pn);
        $this->cache[$pn] = $res;
        return $res;
    }
    
    public function claim($pn){
        $res = file_get_contents("http://minecraftpocket-servers.com/api/?action=post&object=votes&element=claim&key=".$this->key."&username=".$pn);
        if($res == 1){
            $this->cache[$pn] = 2;
            return true;
        }else{
            return false;
        }
    }
    
    public function reward(Player $p){
        foreach($this->commands as $cmd){
            PwLang::translateConstant(PwLang::translateColor($cmd));
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $cmd);
        }
    }
}