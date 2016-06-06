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
    
    private $sID, $sKey, $hash, $folder = false;
    const PROTOCOL = "https://plugswork.com/api/";
    
    public function __construct($sID, $sKey, $hash, $folder){
        $this->sID = $sID;
        $this->sKey = $sKey;
        //Hash is not required currently
        $this->hash = $hash;
        $this->folder = $folder;
    }
    
    public function open(){
        $result = $this->getURL(self::PROTOCOL."open?id=".$this->sID."&key=".$this->sKey."&ver=".PLUGSWORK_VERSION);
        if(strlen($result) === 1){
            return $result;
        }
        return json_decode($result, true);
    }
    
    public function update($player){
        $this->getURL(self::PROTOCOL."update?player=".$player);
    }
    
    public function fetchSettings(){
        return json_decode($this->getURL(self::PROTOCOL."fetch"), true);
    }
    
    public function check(){
        return json_decode($this->getURL(self::PROTOCOL."check"), true);
    }
    
    public function close(){
        $this->getURL(self::PROTOCOL."close");
    }
    
    public function getURL($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->folder."pw.cache"); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->folder."pw.cache"); 
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}
