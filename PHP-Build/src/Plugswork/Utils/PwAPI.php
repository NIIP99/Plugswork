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
    
    private $plugin;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    public static function get(){
        
    }
    
    public static function put(){
        
    }
}