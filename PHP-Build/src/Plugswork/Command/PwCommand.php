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
use Plugswork\Utils\PwLang;

use pocketmine\Player;
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
            case "about":
                $s->sendMessage(
                        "This server is running Plugswork v".PLUGSWORK_VERSION."\n".
                        "Install Plugswork for your server too! (https://plugswork.com)"
                );
                break;
            case "check":
                if($sender instanceof Player){
                    PwLang::cTranslate("main.runAsConsole");
                    return false;
                }
                $this->plugin->tools->checkData();
                break;
            case "getlog":
                if(!$this->plugin->perm->checkPerm($sender, "pw.getLogPerm")){
                    $sender->sendMessage(PwLang::translate("cmd.noPerm"));
                    return false;
                }
                if(empty($args[1])){
                    $args[1] = "main";
                }
                if(empty($args[2])){
                    $sender->sendMessage($this->plugin->log->get($args[1]));
                }else{
                    $sender->sendMessage($this->plugin->log->get($args[1], explode("-", $args[2])));
                }
                break;
            case "reloadlog":
                $this->plugin->getLogger()->info(PwLang::cTranslate("log.reloading"));
                $this->plugin->log->loadCache();
                $this->plugin->getLogger()->info(PwLang::cTranslate("log.reloadSucessful"));
                break;
            case "reload":
                if($sender instanceof Player){
                    PwLang::cTranslate("main.runAsConsole");
                    return false;
                }
                $this->plugin->getLogger()->info(PwLang::cTranslate("main.reloading"));
                $this->plugin->loadSettings($this->plugin->api->fetchSettings());
                $this->plugin->getLogger()->info(PwLang::cTranslate("main.reloadSucessful"));
                break;
        }
        return true;
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
}
