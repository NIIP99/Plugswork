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
use Plugswork\Provider\MySQLProvider;
use Plugswork\Provider\SQLiteProvider;
use Plugswork\Utils\PwAPI;
use Plugswork\Utils\PwLang;

class Plugswork extends PluginBase{
    
    //Constant
    const ERR = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x34\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x63\x20";
    const ALR = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x36\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x65\x20";
    const SUC = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x32\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x61\x20";
    
    public $command = null, $onSetup = false;
    public $auth, $chat, $economy = false;
    
    public function onEnable(){
        new PwListener($this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PwTiming($this), 6000);
        $firstRun = false;
        if(!is_file($this->getDataFolder()."config.yml")){
            $firstRun = true;
        }
        $data = $this->loadConfig();
        if(empty($data[3]) || $data[3] == "xx"){
            echo "- [Plugswork] Please select console language.[en/cn]\n";
            $lang = strtolower($this->readCommand());
            if($lang != "cn"){
                $lang = "en";
            }
        }
        $lang = new PwLang($this, $lang);
        if(empty($data[0]) || $data[0] == "steve-xxxxx"){
            echo "- [Plugswork] ".PwLang::cTranslate("main.enterServerID")."\n";
            $data[0] = $this->readCommand();
            $this->getConfig()->set("server-id", $data[0]);
            $this->getConfig()->save();
        }
        if(empty($data[1]) || $data[0] == "xxxxx"){
            echo "- [Plugswork] ".PwLang::cTranslate("main.enterSecretKey")."\n";
            $data[1] = $this->readCommand();
            $this->getConfig()->set("secret-key", $data[1]);
            $this->getConfig()->save();
        }
        new PwAPI($data[0], $data[1]);
        if(!is_array($PwData = PwAPI::open())){
            echo "- [Plugswork] ".PwLang::cTranslate("main.serverDataError");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
        //Load the data
        $lang->loadUserMessages($PwData["messages"]);
        $this->auth = $PwData["auth"];
        $this->chat = $PwData["chat"];
        $this->economy = $PwData["economy"];
        if($firstRun){
            echo "\n  ".PwLang::cTranslate("main.pwTerms")."\n".
                 "  Plugswork Terms (https://plugswork.com/terms)".
                    
                 "- [Plugswork] ".PwLang::cTranslate("main.pwTermsAccept")."\n";
            $command = $this->readCommand();
            if($command != "y"){
                echo "- [Plugswork] ".PwLang::cTranslate("main.pwTermsError")."\n";
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
        $data[2] = $this->getConfig()->get("console-language");
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
    
    private function loadCommand(){
        
    }
    
}