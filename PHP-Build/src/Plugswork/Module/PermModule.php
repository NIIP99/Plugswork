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

use Plugswork\Plugswork;
use Plugswork\Utils\PwLang;
use pocketmine\Player;

class PermModule{
    
    private $plugin;
    private $permNodes = [];
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
    
    public function load($rawSettings){
        //Settings handler
        $perms = json_decode($rawSettings, true);
        foreach($perms as $key => $node){
            $key = str_replace("-", ".",$key);
            $this->permNodes[$key] = $node;
        }
    }
    
    public function checkPerm($s, $key){
        if(isset($this->permNodes[$key])){
            $perm = $this->permNodes[$key];
            if($s->hasPermission($perm)){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
}