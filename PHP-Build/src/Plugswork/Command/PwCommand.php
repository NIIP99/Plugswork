<?php

namespace Plusgwork\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;

use Plugswork\Plugswork;

class PwCommand extends Command implements PluginIdentifiableCommand{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin, $name, $description){
        $this->plugin = $plugin;
        parent::__construct($name, $description);
    }
    
    public function execute(CommandSender $s, $alias, array $args){
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