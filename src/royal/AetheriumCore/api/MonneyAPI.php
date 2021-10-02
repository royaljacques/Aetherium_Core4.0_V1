<?php
namespace royal\AetheriumCore\api;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\Main;

trait MonneyAPI{
    private Main $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin =$plugin;
    }

    public function getConfigMonnaie(Player $player): Config
    {
        return new Config($this->plugin->getDataFolder()."monnaie/monnaie.yml");
    }
    public function getConfigToken(Player $player): Config
    {
        return new Config($this->plugin->getDataFolder()."monnaie/token.yml");
    }

    public function addMonnaie(Player $player, int $monnaie){
        $config = $this->getConfigMonnaie($player);
        $config->set($player->getName(), $monnaie);
        $config->save();
    }
    public function addToken(Player $player, int $monnaie){
        $config = $this->getConfigToken($player);
        $config->set($player->getName(), $monnaie);
        $config->save();
    }
    public function getMonnaie(Player $player){
        $config = $this->getConfigMonnaie($player);
        return $config->get($player->getName());
    }
    public function gettoken(Player $player){
        $config = $this->getConfigToken($player);
        return $config->get($player->getName());
    }
    public function delmonnaie(Player $player, int $monnaie){
        $config = $this->getConfigMonnaie($player);
        $base = $config->get($player->getName());
        $result = $base - $monnaie;
        $config->set($player->getName(), $result);
    }
}