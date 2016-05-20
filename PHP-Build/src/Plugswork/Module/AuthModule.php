<?php

#  ____  _                                    _    
# |  _ \| |_   _  __ _ _____      _____  _ __| | __
# | |_) | | | | |/ _` / __\ \ /\ / / _ \| '__| |/ /
# |  __/| | |_| | (_| \__ \\ V  V / (_) | |  |   < 
# |_|   |_|\__,_|\__, |___/ \_/\_/ \___/|_|  |_|\_\
#                |___/                             
# Plugswork - Extends your MCPE Server beyond your imagination!
# Licensed under GNU Lesser General Public License (https://github.com/deotern/Plugswork/blob/master/LICENSE)
# Version: 1.php

namespace Plugswork\Module;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use Plugswork\PlugsworkListener;

class AuthModule{
    
    private $plugin;
    
    public function __construct(Plugswork $plugin){
        $this->plugin = $plugin;
    }
}