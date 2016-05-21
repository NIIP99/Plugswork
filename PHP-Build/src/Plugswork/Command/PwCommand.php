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
    
    public function execute(CommandSender $sender, $alias, array $args){
        
        switch($alias[0]){
            default:
                break;
            case "about":
                break;
        }
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
}