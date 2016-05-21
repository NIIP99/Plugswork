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

class PwAPI{
    
    private $sID, $sKey = false;
    private $PLUGSWORK_API = "http://api.plugswork.com/";
    
    public function __construct($sID, $sKey){
        $this->sID = $sID;
        $this->sKey = $sKey;
        //Check for https Warpers
        if(in_array("https", stream_get_wrappers())){
            $this->PLUGSWORK_API = "https://plugswork.com/api/";
        }
    }
    
    public static function open(){
        $result = file_get_contents($this->PLUGSWORK_API."open?id=".$sID."&key=".$sKey);
        if($result == 0){
            return PwLang::cTranslate("api.dataInvalid");
        }elseif($result >= 2){
            return PwLang::cTranslate("api.dataMismatch");
        }
        return unserialize($result);
    }
    
    public static function close(){
        
    }
}