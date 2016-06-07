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
use pocketmine\utils\Utils;

use Plugswork\Command\PwCommand;
use Plugswork\Command\BcCommand;
use Plugswork\Command\VoteCommand;
//use Plugswork\Module\AuthModule;
use Plugswork\Module\BroadcastModule;
use Plugswork\Module\ChatModule;
use Plugswork\Module\LogModule;
use Plugswork\Module\VoteModule;
use Plugswork\Provider\MySQLProvider;
use Plugswork\Provider\SQLiteProvider;
use Plugswork\Task\PwTiming;
use Plugswork\Utils\PwAPI;
use Plugswork\Utils\PwLang;
use Plugswork\Utils\PwTools;

class Plugswork extends PluginBase{
    
    //Constant
    const ERR = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x34\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x63\x20";
    const ALR = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x36\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x65\x20";
    const SUC = "\xc3\x82\xc2\xa7\x6c\xc3\x82\xc2\xa7\x32\xc3\x82\xc2\xbb\xc3\x82\xc2\xa7\x72\xc3\x82\xc2\xa7\x61\x20";
    
    public $command = null, $onSetup = false, $ssl;
    public $api;
    private $unifyLog = false;
    
    public function onEnable(){
        //Plugswork Version v2.php.bleed
        define("PLUGSWORK_VERSION", "3.php.bleed");
        new PwListener($this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new PwTiming($this), 6000);
        $firstRun = false;
        if(!is_file($this->getDataFolder()."config.yml")){
            $firstRun = true;
        }
        $data = $this->loadConfig();
        if(empty($data[2]) || $data[2] == "xx"){
            echo "- [Plugswork] Please select console language.\n\n   (en) => English\n   (cn) => Chinese\n   (ru) => Russian";
            $lang = strtolower($this->readCommand());
            if($lang != "cn" && $lang != "ru"){
                $lang = "en";
            }
            $data[2] = $lang;
            $this->getConfig()->set("console-language", $lang);
            $this->getConfig()->save();
        }
        new PwLang($this, $data[2], "H:i:s"); //TODO Customized Time Date Format
        if(empty($data[0]) || $data[0] == "steve-xxxxx"){
            echo "- [Plugswork] ".PwLang::cTranslate("main.enterServerID")."\n";
            $data[0] = $this->readCommand();
            $this->getConfig()->set("server-id", $data[0]);
            $this->getConfig()->save();
        }
        if(empty($data[1]) || $data[1] == "xxxxx"){
            echo "- [Plugswork] ".PwLang::cTranslate("main.enterSecretKey")."\n";
            $data[1] = $this->readCommand();
            $this->getConfig()->set("secret-key", $data[1]);
            $this->getConfig()->save();
        }
        $this->tools = new PwTools($this);
        $this->api = new PwAPI($data[0], $data[1], md5(Utils::getIP().$this->getServer()->getPort().Utils::getOS()), $this->getDataFolder());
        //$this->auth = new AuthModule($this);
        $this->broadcast = new BroadcastModule($this);
        $this->chat = new ChatModule($this);
        $this->vote = new VoteModule($this);
        $this->log = new LogModule($this);
        if(!is_array($PwData = $this->api->open())){
            if($PwData == 0){
                $PwData = "api.emptyDataError";
            }elseif($PwData == 1){
                $PwData = "api.serverIDError";
            }elseif($PwData == 2){
                $PwData = "api.sKeyError";
            }elseif($PwData == 3){
                $PwData = "api.validationError";
            }
            echo "- [Plugswork] ".PwLang::cTranslate("api.openError", [$PwData])."\n";
            $this->tools->checkData();
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return false;
        }
        $this->loadSettings($PwData);
        if($firstRun){
            echo "\n  ".PwLang::cTranslate("main.pwTerms")."\n".
                 "  Plugswork Terms (https://plugswork.com/terms)".
                    
                 "- [Plugswork] ".PwLang::cTranslate("main.pwTermsAgree")."\n";
            $command = $this->readCommand();
            if($command != "y"){
                echo "- [Plugswork] ".PwLang::cTranslate("main.pwTermsError")."\n";
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return false;
            }
        }
        $this->loadCommand();
        $this->getLogger()->info(
            PwLang::translateColor(
                "\n".
                "&6   ____  _                                    _     \n".
                "&6  |  _ \| |_   _  __ _ _____      _____  _ __| | __ \n".
                "&6  | |_) | | | | |/ _` / __\ \ /\ / / _ \| '__| |/ / \n".
                "&6  |  __/| | |_| | (_| \__ \\\ V  V / (_) | |  |   <  \n".
                "&6  |_|   |_|\__,_|\__, |___/ \_/\_/ \___/|_|  |_|\_\ \n".
                "&6                 |___/                              \n".
                "&b  Plugswork Version:&f v".PLUGSWORK_VERSION."\n".
                "&3  (c) 2016 All rights reserved, Plugswork.\n".
                "&6  ".PwLang::cTranslate("main.donateNote")."\n"
            )
        );
        if($this->tools->hasUpdate($PwData["newVer"])){
            echo "  \e[30;48;5;220m".PwLang::cTranslate("main.updateAvailable")."\e[49m\n\n";
        }
        $this->log->write("Server Started!");
    }
    
    public function onDisable(){
        $this->api->close();
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
            $this->getLogger()->error(PwLang::cTranslate("main.invalidProvider"));
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
        return $data;
    }
    
    private function loadCommand(){
        $cm = $this->getServer()->getCommandMap();
        
        $cm->register("pw", new PwCommand($this, "pw", "Plugswork Command"));
        $cm->register("bc", new BcCommand($this, "bc", "Broadcast Command"));
        $cm->register("vote", new VoteCommand($this, "vote", "Vote Command"));
    }
    
    public function loadSettings($data){
        //Load the settings
        PwLang::loadUserMessages($data["message_settings"]);
        $this->broadcast->load($data["broadcast_settings"]);
        $this->chat->load($data["chat_settings"]);
        $this->vote->load($data["vote_settings"]);
        $this->log->load($data["log_settings"]);
        $this->tools->load($data["main_settings"]);
    }
    
}
