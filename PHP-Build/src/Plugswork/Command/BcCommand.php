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

class BcCommand extends Command implements PluginIdentifiableCommand{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin, $name, $description){
        $this->plugin = $plugin;
        parent::__construct($name, $description);
    }
    
    public function execute(CommandSender $sender, $alias, array $args){
        if(!$sender->hasPermission($this->plugin->tools->getPerm("broadcast.commandPerm"))){
            $sender->sendMessage(PwLang::translate("cmd.noPerm"));
            return false;
        }
        if(!isset($args[0])){
            $sender->sendMessage("/bc <message|popup|tip> [messages]");
            return false;
        }
        $type = $args[0];
        unset($args[0]);
        $msg = implode(" ", $args);
        switch($type){
            default:
                $sender->sendMessage("/bc <message|popup|tip> [messages]");
                break;
            case "message":
                $this->plugin->broadcast->broadcast($msg);
                break;
            case "popup":
                $this->plugin->broadcast->broadcastPopup($msg);
                break;
            case "tip":
                $this->plugin->broadcast->broadcastTip($msg);
                break;
        }
        return true;
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
}