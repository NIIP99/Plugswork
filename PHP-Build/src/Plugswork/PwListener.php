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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

use Plugswork\Utils\PwLang;

class PwListener implements Listener{
    
    private $plugin;
    private $enableUniversal = false;
    
    public function __construct(Plugswork $plugin){
	$plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
        $this->plugin = $plugin;
    }
    
    public function load($rawSettings){
        $st = json_decode($rawSettings, true);
        if(isset($st["enableUniversal"])){
            $this->enableUniversal = true;
        }
    }
    
    public function onCommand(ServerCommandEvent $e){
        if($this->plugin->onSetup){
            $this->plugin->command = $e->getCommand();
            $e->setCommand("");
            $e->setCancelled();
        }
    }
    
    public function onDataPacket(DataPacketReceiveEvent $e){
        //EXPERIMENTAL Please don't ever use this hack... Not implemented yet...
        /*$pk = $e->getPacket();
        if($pk->pid() != ProtocolInfo::LOGIN_PACKET){
            return;
        }
        if($this->enableUniversal){
            if($pk->protocol1 != ProtocolInfo::CURRENT_PROTOCOL){
                if(in_array($pk->protocol1, $this->acceptedProtocol)){
                    $pk->protocol1 = ProtocolInfo::CURRENT_PROTOCOL;
                    $this->plugin->log->write($pk->username." protocol is overwritten to current protocol!", true);
                }
            }
        }*/
    }
    
    public function onPlayerJoin(PlayerJoinEvent $e){
        /*if($this->plugin->AuthEnabled){
            $p = $e->getPlayer();
            $p->sendMessage(PwLang::translate("auth.join"));
        }*/
    }
    
    public function onPlayerChat(PlayerChatEvent $e){
        $p = $e->getPlayer();
        if($this->plugin->perm->checkPerm($p, "chat.bypassPerm")){
            return;
        }
        $res = $this->plugin->chat->check($p->getName(), $e->getMessage());
        switch($res["action"]){
            case "chat":
                $e->setCancelled();
                $p->sendMessage(PwLang::translateColor(PwLang::translate($res["message"])));
                break;
            case "censor":
                $e->setMessage(PwLang::translateColor(PwLang::translate("chat.censorMessage")));
                $p->sendMessage(PwLang::translateColor(PwLang::translate($res["message"])));
                break;
            case "kick":
                $e->setCancelled();
                $p->kick(PwLang::translateColor(PwLang::translate($res["message"])));
                break;
            case "ban":
                $e->setCancelled();
                break;
        }
    }
}
