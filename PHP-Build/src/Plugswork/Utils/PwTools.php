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

use Plugswork\Utils\PwLang;

class PwTools{
    
    private $plugin;
    
    public function __construct($plugin){
        $this->plugin = $plugin;
    }
    
    public function checkData(){
        $data = $this->plugin->api->check();
        $update = "";
        echo    "\n".
                "  \e[38;5;208mPlugswork Data Checker\e[49m\n".
                "  \e[38;5;30mIP: \e[38;5;45m".$data["ip"]."\n".
                "  \e[38;5;30mRegistered: \e[38;5;45m".$data["reg"]."\n".
                "  \e[38;5;30mVersion: \e[38;5;45m".PLUGSWORK_VERSION."\n\n";
        if($data["newVer"] != PLUGSWORK_VERSION){
            echo "  \e[30;48;5;220m Update Available! ";
        }
    }
    
    public function hasUpdate($newVer){
        
    }
}
