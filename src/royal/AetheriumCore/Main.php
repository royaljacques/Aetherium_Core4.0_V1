<?php

declare(strict_types=1);

namespace royal\AetheriumCore;

use pocketmine\block\tile\EnderChest;
use pocketmine\inventory\PlayerEnderInventory;
use royal\AetheriumCore\blocks\inventory\CraftingGridInvMenuType;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\block\BlockFactory;
use pocketmine\crafting\CraftingGrid;
use pocketmine\item\ItemFactory;
use pocketmine\permission\{
	Permission,
	PermissionManager
};
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use royal\AetheriumCore\api\RankAPI;
use royal\AetheriumCore\utils\{
	Permissions,
	Variables
};

class Main extends PluginBase{
	private static $instance;
	private static $RankAPI;
	/**
	 * @var Config
	 */
	private Config $rank;

	protected function onEnable(): void
	{
		self::$instance = $this;
		self::$RankAPI = new RankAPI($this);
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
		InvMenuHandler::getTypeRegistry()->register(Variables::INV_MENU_TYPE_WORKBENCH, new CraftingGridInvMenuType(CraftingGrid::SIZE_BIG));
		foreach (Permissions::$permissionsall as $perms){
			PermissionManager::getInstance()->addPermission(new Permission($perms));
			$this->getLogger()->info("§2 La permission: ".$perms." a bien été load");
		}
		$this->register(dirname(__FILE__) . "/commands", "Command");
		$this->register(dirname(__FILE__) . "/events", "Event");
		@mkdir($this->getDataFolder()."ranks/");
		@mkdir($this->getDataFolder()."job/");
		@mkdir($this->getDataFolder()."job/"."players");
		@mkdir($this->getDataFolder()."ranks/"."players/");
	}
	public static function getInstance(){
		return self::$instance;
	}
	public static function getRankAPI(): RankAPI{
		return self::$RankAPI;
	}
	private function register(string $dir, string $type)
	{
		foreach (scandir($dir) as $file) {
			if(!in_array($file, [".", "..", "Tool"])) {
				if(is_dir($dir . "/" . $file)) $this->register($dir . "/" . $file, $type);
				else {
					$name = "\\" . str_replace([dirname(__FILE__), "/", ".php"], ["", "\\", ""], __NAMESPACE__ . $dir . "/" . $file);
					$class = new $name($this);
					switch ($type) {
						case "Item":
							(new ItemFactory)->register($class, true);
							$this->getLogger()->info("§5adresse de l'item: ".$name);
							break;
						case "Block":
							(new BlockFactory)->register($class, true);
							$this->getLogger()->info("§badresse du block: ".$name);
							break;
						case "Command":
							$this->getServer()->getCommandMap()->register($this->getName(), $class);
							$this->getLogger()->info("§1adresse de la commande: ".$name);
							break;
						case "Event":
							$this->getServer()->getPluginManager()->registerEvents($class, $this);
							$this->getLogger()->info("§3adresse de l'event: ".$name);
							break;

						case"Task":
							$this->getScheduler()->scheduleRepeatingTask($class, $class->getEverySecond() * 20);
							$this->getLogger()->info("§6adresse de la task: ".$name);
							break;
					}
				}
			}
		}
	}
}