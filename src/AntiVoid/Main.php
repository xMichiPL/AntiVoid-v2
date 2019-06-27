<?php

namespace AntiVoid;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\level\Position;

use pocketmine\level\sound\EndermanTeleportSound;

use pocketmine\event\player\PlayerMoveEvent;

use pocketmine\command\CommandSender;

use AntiVoid\Main;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
        $this->getLogger()->info("Enabled.");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		@mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
		$level = $this->getConfig()->get("LevelName");
        if($player->getLevel()->getFolderName() === $this->getConfig()->get("LevelName")){
			if($event->getTo()->getFloorY() < 0){
				$player->setGamemode(0);
				$player->setAllowFlight(false);
				$player->teleport(Server::getInstance()->getLevelByName($this->getConfig()->get("LevelName"))->getSafeSpawn());
				$player->getLevel()->addSound(new EndermanTeleportSound($player));
			}
		}
	}

    public function onDisable(){
        $this->getLogger()->info("Disabled.");
    }
}