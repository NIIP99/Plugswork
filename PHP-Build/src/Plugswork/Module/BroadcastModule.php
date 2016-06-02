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

use Plugswork\Plugswork;

class BroadcastModule{
    
    private $plugin;
    private $toConsole = false;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    public function load($rawSettings){
        //Settings handler
        $st = json_decode($rawSettings, true);
        if(isset($st["toConsole"])){
            $this->toConsole = true;
        }
        $this->settings = $st;
    }
    
    public function broadcast($msg){
        /*
         * This is intended to make the constant variable {USERNAME}, {NICKNAME} to be worked
         * Please don't change it to broadcastMessage()
         */
        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
            $Tmsg = PwLang::translateConstant(PwLang::translateColor($msg));
            $p->sendMessage($Tmsg);
            if($this->toConsole){
                $this->plugin->info($Tmsg);
            }
        }
    }
}