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

use Plugswork\Task\PwTiming;
use Plugswork\Utils\PwAPI;
use Plugswork\Provider\MySQLProvider;
use Plugswork\Provider\SQLiteProvider;

class Plugswork extends PluginBase{
    
    //Constant
    const ERR = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x34\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x63\x20";
    const ALR = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x36\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x65\x20";
    const SUC = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x32\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x61\x20";
    
    public $command = null, $onSetup = false;
    public $AuthEnabled, $ChatEnabled, $EconomyEnabled = true;
    private $authConfig, $chatConfig, $economyConfig = false;
    
    public function onEnable(){
        new PwListener($this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PwTiming($this), 6000);
        if(!is_file($this->getDataFolder()."config.yml")){
            $data = $this->loadConfig();
            if(empty($data[0])){
                echo "- [Plugswork] Please enter the Server ID.\n";
                $data[0] = $this->readCommand();
            }
            if(empty($data[1])){
                echo "- [Plugswork] Please enter the Secret Key.\n";
                $data[1] = $this->readCommand();
            }
            new PwAPI($data[0], $data[1]);
            if(!empty($result = PwAPI::open())){
                echo "- [Plugswork] Server ID or Secret Key is invalid for this server!\n  Error: ".$result."\n  Still having issue? Contact us!";
                $this->getServer()->getPluginManager()->disablePlugin($this);
            }
            echo "\n  By using this plugin, you agree to Plugswork Terms\n".
                 "  Plugswork Terms (https://plugswork.com/terms)".
                    
                 "- [Plugswork] Do you accept Plugswork Terms? [Y/N]\n";
            $command = $this->readCommand();
            if($command != "Y"){
                echo "- [Plugswork] You need to accept Plugswork Terms to use Plugswork\n";
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
        $data = [];
        $data[0] = $this->getConfig()->get("server-id");
        $data[1] = $this->getConfig()->get("secret-key");
        $provider = $this->getConfig()->get("provider");
        if($provider == "mysql"){
            $options = $this->getConfig()->get("options");
            $this->provider = new MySQLProvider($options);
        }elseif($provider == "sqlite"){
            $this->provider = new SQLiteProvider();
        }else{
            $this->getLogger()->error("Invalid 'provider' is selected in config.yml");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
        return $data;
    }
    
}