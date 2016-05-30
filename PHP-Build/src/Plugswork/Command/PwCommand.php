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

class PwCommand extends Command implements PluginIdentifiableCommand{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin, $name, $description){
        $this->plugin = $plugin;
        parent::__construct($name, $description);
    }
    
    public function execute(CommandSender $sender, $alias, array $args){
        switch($args[0]){
            default:
                break;
            case "check":
                break;
            case "about":
                $s->sendMessage(
                        "This server is running with Plugswork v".PLUGSWORK_VERSION."\n".
                        "Install Plugswork for your sevrer too! (https://plugswork.com)"
                );
                break;
        }
        return true;
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
}