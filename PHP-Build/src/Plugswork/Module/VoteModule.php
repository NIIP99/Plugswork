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

use Plugswork\Utils\PwLang;

class VoteModule{
    
    private $plugin;
    private $cache = [];
    
    public function __construct(Plugswork $plugin, $settings = []){
        $this->plugin = $plugin;
        //Start settings handler
        $this->key = $settings["voteKey"];
    }
    
    public function check($pn){
        $cache = $this->cache[$pn];
        if(isset($this->cache[$pn]) && $cache == 2){
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