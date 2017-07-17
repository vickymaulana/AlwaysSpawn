<?php

namespace AlwaysSpawn;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\math\Vector3;

class Loader extends Plugin implements Listener{
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getServer()->getLogger()->info("AlwaysSpawn Enable!");
    }
  
  public function onDisable(){
    $this->getServer()->getLogger()->info("AlwaysSpawn Disable!");
    }
  
  public function onPlayerLogin(PlayerLoginEvent $event){
    $player = $event->getPlayer();
    $x = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
    $y = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
    $z = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
    $player->setLevel($level);
    $player->teleport(new Vector3($x, $y, $z, $level));
    }
  }
