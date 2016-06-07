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

class LogModule{
    
    private $plugin;
    private $logsFolder, $unifyLog;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
        $this->logsFolder = $this->plugin->getDataFolder()."logs/";
        if(!file_exists($this->logsFolder)){
            mkdir($this->logsFolder, 0777, true);
        }
    }
    
    public function load($rawSettings){
        //Settings handler
        $st = json_decode($rawSettings, true);
        if(isset($st["unifyLog"])){
            $this->unifyLog = true;
        }else{
            $this->unifyLog = false;
        }
        $this->settings = $st;
        $types = glob($this->logsFolder."*.{log}", GLOB_BRACE);
        foreach($types as $type){
            $file = new \SplFileObject($type);
            for($i = 0; $i <= 5; $i++){
                echo $file->seek($i);
                $type = basename($type, ".log");
                $this->$type[$i + 1] = $file->current();
            }
        }
    }
    
    public function write($log, $type = null){
        if($this->unifyLog || $type == null){
            file_put_contents($this->logsFolder."main.log", date("[Y-m-d H:i:s] ").$log."\n", FILE_APPEND);
        }else{
            file_put_contents($this->logsFolder.$type.".log", date("[Y-m-d H:i:s] ").$log."\n", FILE_APPEND);
        }
    }
    
    public function get($type, $lines = []){
        $c = count($lines);
        if($c === 0){
            return implode("\n", $this->$type);
        }elseif($c === 1){
            return $this->$type[$lines[0]];
        }elseif($c === 2){
            for($i == $lines[0]; $i <= $lines[1]; $i++){
                $string .= "\n".$this->$type[$i];
            }
            return $string;
        }
    }
    
    public function getWarning($type = null){
        
    }
}