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

namespace Plugswork;

use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\server\ServerCommandEvent;

use Plugswork\Utils\PwLang;

class PwListener implements Listener{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin){
	Server::getInstance()->getPluginManager()->registerEvents($this, $plugin);
        $this->plugin = $plugin;
    }
    
    public function onCommand(ServerCommandEvent $e){
        if($this->plugin->onSetup){
            $this->plugin->command = $e->getCommand();
            $e->setCommand("");
            $e->setCancelled();
        }
    }
    
    public function onPlayerJoin(PlayerJoinEvent $e){
        if($this->plugin->AuthEnabled){
            $p = $e->getPlayer();
            $p->sendMessage(PwMessages::translate("auth-join"));
        }
    }
    
    public function onPlayerChat(PlayerChatEvent $e){
        $p = $e->getPlayer();
        $res = $this->plugin->chat->check($e->getMessage());
        switch($res["action"]){
            case "chat":
                $e->setCancelled();
                $p->kick(PwLang::translate($res["message"]));
                break;
            case "censor":
                $e->setMessage(PwLang::translate("chat.censorMessage"));
                $p->sendMessage(PwLang::translate($res["message"]));
                break;
            case "kick":
                $e->setCancelled();
                $p->kick(PwLang::translate($res["message"]));
                break;
            case "ban":
                $e->setCancelled();
                break;
        }
    }
}