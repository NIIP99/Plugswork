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
        if($data["newVer"] != PLUGSWORK_VERSION){
            $update = "&eUpdate Available!";
        }
        echo    "\n".
                "  \e[97;48;5;214m Plugswork Data Checker\e[49m\n".
                "  \e[38;5;214;48;5;15m IP: ".$data["ip"]."\e[49m\n".
                "  \e[38;5;214;48;5;15m Registered: ".$data["reg"]."\e[49m\n".
                "  \e[38;5;214;48;5;15m Version: ".PLUGSWORK_VERSION."\e[49m\n".
                $update;
    }
    
    public function hasUpdate($newVer){
        
    }
}
