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

//use Plugswork\Utils\PwLang;

class PwTools{
    
    private $plugin;
    private $allowBleed = false;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
    }
    
    public function load($rawSettings){
        //Settings handler
        $st = json_decode($rawSettings, true);
        if(isset($st["allowBleed"])){
            $this->allowBleed = true;
        }
    }
    
    public function checkData(){
        $data = $this->plugin->api->check();
        echo    "\n".
                "  \e[38;5;208mPlugswork Data Checker\e[49m\n".
                "  \e[38;5;30mIP: \e[38;5;45m".$data["ip"]."\n".
                "  \e[38;5;30mRegistered: \e[38;5;45m".$data["reg"]."\n".
                "  \e[38;5;30mVersion: \e[38;5;45m".PLUGSWORK_VERSION."\n\n";
        if($this->hasUpdate($data["newVer"])){
            echo "  \e[30;48;5;220m Update Available! ";
        }
    }
    
    public function hasUpdate($newVer){
        $cV = explode(PLUGSWORK_VERSION);
        $nV = explode(".", $newVer);
        if(nV[0] >= $cV[0]){
            $toBleed = false;
            if(isset($nV[2]) && empty($cV[2])){
                if($nV[2] == "bleed"){
                    $toBleed = true;
                }
            }
            if($toBleed){
                if($this->allowBleed){
                    return true;
                }else{
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
