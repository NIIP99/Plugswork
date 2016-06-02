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

namespace Plugswork\Task;

//use pocketmine\Server;
use pocketmine\scheduler\Task;
use Plugswork\Module\BroadcastModule;

class BroadcastTask extends Task{
    
    private $broadcast;
    private $lastTick, $tickDiff, $popupDur, $tipDur;
    private $messages, $pMessages, $Tmessages = [];
    
    //To dev: m = main, p = popup, t = tip :) Shortcuts!
    
    public function __construct(BroadcastModule $vote, $st = []){
        $this->broadcast = $vote;
        $this->mDiff = $st["mainDiff"];
        $this->pDiff = $st["pDiff"];
        $this->tDiff = $st["tDiff"];
        $this->pDur = $st["pDur"];
        $this->tDur = $st["tDur"];
        $this->messages = $st["messages"];
        foreach($st as $key => $value){
            if(in_array($key, array("enableBroadcast", "enablePopup", "enableTip"))){   
                if(isset($value)){
                    $this->$key = true;
                    //unset($st[$key]);
                }
            }
        }
        $this->i = 0;
    }
    
    public function onRun($tick){
        if(empty($this->mLast)){
            //Maybe checking mainLastTick is enough to prove the starts of BroadcastTask
            $this->mLast = $tick;
            $this->pLast = $tick;
            $this->tLast = $tick;
        }
        if($this->enableM){
            //M = Main Broadcast
            $diff = $tick - $this->mLast;
            if($diff >= $this->tickDiff && $this->enableBroadcast){
                $this->broadcast->broadcast($this->msg[$this->i]);
                $this->i++;
                if($this->i >= count($this->messages)){
                    $this->i = 0;
                }
            }
        }
        if($this->enableP){
            //P = Popup Broadcast
            if($diff >= $this->pDiff && $this->enablePopup){
                if($this->inPopup){
                    $this->broadcast->broadcastPopup($this->msg[$this->i]);
                }else{
                    $this->pi++;
                    if($this->pi >= count($this->messages)){
                        $this->pi = 0;
                    }
                }
            }
        }
    }
}