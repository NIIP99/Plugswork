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

namespace Plugswork\Command;

use Plugswork\Plugswork;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;

class VoteCommand extends Command implements PluginIdentifiableCommand{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin, $name, $description){
        $this->plugin = $plugin;
        parent::__construct($name, $description);
    }
    
    public function execute(CommandSender $s, $alias, array $args){
        if(!$s instanceof Player){
            $s->sendMessage(PwLang::cTranslate("main.runAsPlayer"));
            return false;
        }
        //$sn = $s->getName();
        if($args[0] == "info"){
            $s->sendMessage(PwLang::translate("vote.info"));
        }
        $this->plugin->vote->vote($s);
        return true;
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
}