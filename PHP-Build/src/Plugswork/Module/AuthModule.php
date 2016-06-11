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

use pocketmine\Player;

class AuthModule{
    
    private $plugin, $auth;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    public function load(){
        
    }
    
    public function isAuth(){
        
    }
    
    public function register(Player $p, $pwd, $email){
        if($this->plugin->auth["email"]){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $p->sendMessage(Plugswork::ERR.PwMessages::translate("auth-emailInvalid"));
                return;
            }
            if($this->plugin->provider->query("SELECT email FROM `plugswork_auth` WHERE email='$email'")->fetch_assoc()){
                $p->sendMessage(Plugswork::ERR.PwMessages::translate("auth-emailRegistered"));
                return;
            }
        }
        switch($this->plugin->auth["hash"]){
            case 0:
                //Default Hash
                $Hpwd = hash("sha256", $pwd.$salt);
                break;
            case 1:
                //SimpleAuth Hash
                $Hpwd = bin2hex(hash("sha512", $pwd.$salt, true) ^ hash("whirlpool", $salt.$password, true));
                break;
            case 2:
                //SMF Forum Software Hash
                $Hpwd = sha1($spn.$pwd);
                break;
         }
    }
        
    public function login(){
        
    }
}