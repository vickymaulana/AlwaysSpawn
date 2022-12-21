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
  $level = $this->getServer()->getDefaultLevel();
  $spawn = $level->getSafeSpawn();

  // Cek Block / object yang menutupi spawn
  $block = $level->getBlock($spawn);
  if($block->getId() !== Block::AIR){
    // Cari Lokasi Spawn
    $searchPos = $spawn;
    $foundFreeSpace = false;
    for($i = 1; $i <= 5; $i++){
      // Periksa blok di atas lokasi spawn
      $searchPos->y += 1;
      $block = $level->getBlock($searchPos);
      if($block->getId() === Block::AIR){
        $foundFreeSpace = true;
        break;
      }
      // Periksa blok di sekitar spawn
      for($j = 0; $j < 4; $j++){
        $searchPos->y -= 1;
        switch($j){
          case 0:
            $searchPos->x -= 1;
            break;
          case 1:
            $searchPos->z -= 1;
            break;
          case 2:
            $searchPos->x += 1;
            break;
          case 3:
            $searchPos->z += 1;
            break;
        }
        $block = $level->getBlock($searchPos);
        if($block->getId() === Block::AIR){
          $foundFreeSpace = true;
          break 2;
        }
      }
    }
    if(!$foundFreeSpace){
      // Spawn Player ke Lokasi awal kalo gaada tempat buat spawn
      $player->sendMessage("[ERROR] Tidak dapat menemukan lokasi yang tersedia di sekitar lokasi spawn, menggunakan lokasi default.");
      $player->teleport($spawn);
      return;
    }
    $spawn = $searchPos;
  }

  $player->teleport($spawn);
}
