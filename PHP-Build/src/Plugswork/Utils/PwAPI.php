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

use Plugswork\PlugsworkListener;

class PwAPI{
    
    private $sID, $sKey = false;
    
    public function __construct($sID, $sKey){
        $this->sID = $sID;
        $this->sKey = $sKey;
    }
    
    public static function open(){
        $result = file_get_contents("https://plugswork.com/api/open?id=".$sID."&key=".$sKey);
        if($result == 0){
            return "Either Server ID or Secret Key given is invalid! Please check config.yml if you fill in the correct Server ID";
        }elseif($result >= 2){
            return "Either Server IP, Port, Software or other data has been changed, please check if all data is up to date at Control Panel";
        }
        return unserialize($result);
    }
    
    public static function close(){
        
    }
}