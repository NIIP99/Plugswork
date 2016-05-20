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

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;


class PwMessages{
    
    private $messages;
    
    public function __construct($messages){
        $this->messages = $messages;
    }
    
    public static function translate($regex){
        $parts = explode("-", $regex);
        if(empty($msg = $this->messages[$parts[0]][$parts[1]])){
            return null;
        }else{
            return $msg;
        }
    }
}