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

class ChatModule{
    
    private $plugin;
    private $unicAllow, $adGurad, $spamGuard, $capsGuard = true;
    private $chatTime, $messages = [];
    
    public function __construct(Plugswork $plugin, $settings = []){
        $this->plugin = $plugin;
        //Settings handler
        $this->settings = $settings;
    }
    
    public function check($pn, $msg){
        $res = [];
        if(!$this->unicAllow){
            if(strlen($msg) != strlen(utf8_decode($msg))){
                $res["action"] = "chat";
                $res["message"] = "chat.unicWarning";
                return $res;
            }
        }
        if($this->spamGuard){
            $tick = $this->plugin->getServer()->getTick();
            if($this->chatTime[$pn] >= $tick){
                $res["action"] = $this->settings["spamAction"];
                $res["message"] = "chat.spamWarning";
                return $res;
            }
            $this->chatTime[$pn] = $tick + $this->options["spamRestDur"];
        }
        if($this->adGuard){
            if(preg_match("/[A-Z0-9]+\.[A-Z0-9]+/i", $msg)){
                $res["action"] = $this->settings["adAction"];
                $res["message"] = "chat.adWarning";
                return $res;
            }
        }
        if($this->capsGuard){
            $count = strlen(preg_replace('![^A-Z]+!', '', $msg));
            if($count >= $this->options["maxCaps"]){
                $res["action"] = $this->settings["capsAction"];
                $res["message"] = "chat.capsWarning";
                return $res;
            }
        }
    }
    
}