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
    private $enableM, $enableP, $enableT = false;
    private $mMessages, $pMessages, $tMessages = [];
    private $pTick, $tTick = 1;
    private $mI, $pI, $tI = null;
    
    //To dev: m = main, p = popup, t = tip :) Shortcuts!
    
    public function __construct(BroadcastModule $module, $st = []){
        
        $this->broadcast = $module;
        $this->mDiff = $st["mDiff"];
        $this->pDiff = $st["pDiff"];
        $this->tDiff = $st["tDiff"];
        $this->pDur = $st["pDur"];
        $this->tDur = $st["tDur"];
        
        if(isset($st["enableM"])){
            $this->enableM = true;
        }
        if(isset($st["enableP"])){
            $this->enableP = true;
        }
        if(isset($st["enableT"])){
            $this->enableT = true;
        }
        
        //If users don't give any messages, handle it as disable
        if(isset($st["mMessages"])){
            $this->mMessages = $st["mMessages"];
        }else{
            $this->enableM = false;
        }
        if(isset($st["pMessages"])){
            $this->pMessages = $st["pMessages"];
        }else{
            $this->enableP = false;
        }
        if(isset($st["tMessages"])){
            $this->tMessages = $st["tMessages"];
        }else{
            $this->enableT = false;
        }
    }
    
    public function onRun($xtick){ //I'm not going to use $xtick
        if(empty($this->tick)){
            $tick = 1;
            $this->mLast = $tick;
            $this->pLast = $tick;
            $this->tLast = $tick;
            $this->tick = $tick;
        }else{
            $tick = $this->tick;
        }
        if($this->enableM){
            //M = Main Broadcast
            $diff = $tick - $this->mLast;
            if($diff >= $this->mDiff){
                if($this->mI == null){
                    $this->broadcast->broadcast($this->mMessages[0]);
                }else{
                    $this->broadcast->broadcast($this->mMessages[$this->mI]);
                }
                $this->mI++;
                if($this->mI >= count($this->mMessages)){
                    $this->mI = 0;
                }
                $this->mLast = $tick;
            }
        }
        if($this->enableP){
            //P = Popup Broadcast
            $diff = $tick - $this->pLast;
            if($diff >= $this->pDiff){
                if($this->pTick < $this->pDur){
                    if($this->pI == null){
                        $this->broadcast->broadcastPopup($this->pMessages[0]);
                    }else{
                        $this->broadcast->broadcastPopup($this->pMessages[$this->pI]);
                    }
                    $this->pTick++;
                }else{
                    $this->pI++;
                    if($this->pI >= count($this->pMessages)){
                        $this->pI = 0;
                    }
                    $this->pTick = 1;
                    $this->pLast = $tick;
                }
            }
        }
        if($this->enableT){
            //T = Tip Broadcast
            $diff = $tick - $this->tLast;
            if($diff >= $this->tDiff){
                if($this->tTick < $this->tDur){
                    $this->broadcast->broadcastTip($this->tMessages[$this->tI]);
                    $this->tTick++;
                }else{
                    $this->tI++;
                    if($this->tI >= count($this->tMessages)){
                        $this->tI = 0;
                    }
                    $this->tTick = 1;
                    $this->tLast = $tick;
                }
            }
        }
        $this->tick++;
    }
}
