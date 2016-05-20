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

namespace Plugswork;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use Plugswork\EventListener;
use Plugswork\Task\PwTiming;
use Plugswork\Utils\PwAPI;

class Plugswork extends PluginBase{
    
    //Constant
    const ERR = "§l§4»§r§c ";
    const ALR = "§l§6»§r§e ";
    const SUC = "§l§2»§r§a ";
    
    public $command = null, $onSetup = false;
    public $AuthEnabled, $ChatEnabled, $EconomyEnabled = true;
    private $sID, $sKey, $authConfig, $chatConfig, $economyConfig;
    
    public function onEnable(){
        new PwListener($this);
        new PwAPI($this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PwTiming($this), 1200);
        if(!is_file($this->getDataFolder()."config.yml")){
            $this->loadConfig();
            echo "- [Plugswork] Please enter the Server ID.\n";
            $this->sID = $this->readCommand();
            echo "- [Plugswork] Please enter the Secret Key.\n";
            $this->sKey = $this->readCommand();
            if(!empty($result = PwAPI::open($this->sID, $this->sKey))){
                echo "- [Plugswork] Server ID or Secret Key is invalid for this server!\n  Error:".$result;
                $this->getServer()->getPluginManager()->disablePlugin($this);
            }
            echo "\n  By using this plugin, you agree to Plugswork Terms\n".
                 "  Plugswork Terms (https://plugswork.com/terms)".
                    
                 "- [Plugswork] Do you accept Plugswork Terms? [Y/N]\n";
            $command = $this->readCommand();
            if($command != "Y"){
                echo "- [Plugswork] You need to accept the license to use Plugswork\n";
                $this->getServer()->getPluginManager()->disablePlugin($this);
            }
        }
    }
    
   private function readCommand(){
        $this->onSetup = true;
	while($this->command === null){ 
            $this->getServer()->checkConsole();
        }
	$r = $this->command;
	$this->command = null;
	$this->onSetup = false;
	return $r;
    }
    
    private function loadConfig(){
        if(!is_dir($this->getDataFolder())){
            mkdir($this->getDataFolder());
        }
        $this->saveDefaultConfig();
        $this->saveResource("auth.yml");
        $this->serverID = $this->getConfig()->getNested("serverID");
        $provider = $this->getConfig()->getNested("database.provider");
        if($provider == "mysql"){
            $options = $this->getConfig()->getNested("database.options");
            $this->provider = new MySQLProvider($options);
        }elseif($provider == "sqlite3"){
            $options = $this->getConfig()->getNested("database.options");
            $this->provider = new SQLite3Provider($options);
        }else{
            
        }
    }
    
    public static function translate($regex){
        
    }
}