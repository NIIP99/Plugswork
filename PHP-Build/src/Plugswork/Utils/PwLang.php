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

namespace Plugswork\Utils;

use pocketmine\utils\Config;

class PwLang{
    
    private static $plugin, $maxP, $messages, $cMessages;
    private static $format = "H:i:s";
    
    public function __construct($plugin, $lang, $format){
        if(!is_file($plugin->getDataFolder()."lang-".$lang.".yml")){
            $plugin->saveResource("lang-".$lang.".yml");
        }
        self::$cMessages = new Config($plugin->getDataFolder()."lang-".$lang.".yml", Config::YAML);
        if(self::$cMessages->get("version") < PLUGSWORK_VERSION){
            unlink($plugin->getDataFolder()."lang-".$lang.".yml");
            $plugin->saveResource("lang-".$lang.".yml");
            self::$cMessages = new Config($plugin->getDataFolder()."lang-".$lang.".yml", Config::YAML);
        }
        self::$plugin = $plugin;
        self::$maxP = $plugin->getServer()->getMaxPlayers();
        self::$format = $format;
    }
    
    public static function loadUserMessages($rawMessages){
        $messages = json_decode($rawMessages, true);
        //Checking isset won't be needed in the future
        if(isset($messages)){
            foreach($messages as $key => $message){
                $keys = explode("-", $key);
                self::$messages[$keys[0]][$keys[1]] = $message;
            }
        }
    }
    
    //Translate user messages, uses message editor data
    public static function translate($key){
        $keys = explode(".", $key);
        if(isset(self::$messages[$keys[0]][$keys[1]])){
            return self::$messages[$keys[0]][$keys[1]];
        }else{
            return $key;
        }
    }
    
    //Translate console messages, uses local language file
    public static function cTranslate($key, $vars = []){
        if(empty($msg = self::$cMessages->getNested($key))){
            return $key;
        }else{
            $i = 0;
            foreach($vars as $var){           
                $msg = str_replace("%$i%", self::cTranslate($var), $msg);
                $i++;
            }
            return $msg;
        }
    }
    
    public static function translateColor($msg){
        return preg_replace_callback(
            "/(\\\&|\&)[0-9a-fk-or]/",
            function($matches){
                return str_replace("§r", "§r§f", str_replace("\\§", "&", str_replace("&", "§", $matches[0])));
            },
            $msg
        );
    }
    
    public static function translateConstant($msg, $name){
        return str_replace(
            array(
                "{PLAYER}",
                "{TIME}",
                "{TOTALPLAYERS}",
                "{MAXPLAYERS}"
            ),
            array(
                $name,
                date(self::$format),
                count(self::$plugin->getServer()->getOnlinePlayers()),
                self::$maxP
            ),
            $msg
        );
    }
}