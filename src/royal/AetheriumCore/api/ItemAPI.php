<?php
namespace royal\AetheriumCore\api;

use JetBrains\PhpStorm\Pure;
use pocketmine\inventory\CreativeInventory;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\convert\ItemTranslator;
use pocketmine\network\mcpe\protocol\ItemComponentPacket;
use pocketmine\network\mcpe\protocol\serializer\ItemTypeDictionary;
use pocketmine\network\mcpe\protocol\types\ItemComponentPacketEntry;
use pocketmine\network\mcpe\protocol\types\ItemTypeEntry;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use ReflectionObject;
use royal\AetheriumCore\items\CustomClass\AetheriumArmor;
use royal\AetheriumCore\items\CustomClass\AetheriumItem;
use royal\AetheriumCore\Main;
use Webmozart\PathUtil\Path;
use const pocketmine\RESOURCE_PATH;

class ItemAPI {

    /** @var array */
    private static array $queue = [];

    /** @var ItemComponentPacketEntry[] */
    private static array $components = [];

    /** @var ItemComponentPacket|null  */
    public static ?ItemComponentPacket $packet = null;

    /** @var array  */
    private array $coreToNetValues = [];

    /** @var array */
    public static array $entries = [];

    /** @var array */
    public static array $simpleCoreToNetMapping = [];

    /** @var array */
    public static array $simpleNetToCoreMapping = [];

    private static function loadDataFiles(): void {
        $array = ["r16_to_current_item_map" => ["simple" => []], "item_id_map" => [], "required_item_list" => []];
        foreach (self::$queue as $item) {
            $array['r16_to_current_item_map']['simple']['aetherium:' . $item->getName()] = 'aetherium:' . $item->getName();
            $array['item_id_map']['aetherium:' . $item->getName()] = $item->getId();
            $array['required_item_list']['aetherium:' . $item->getName()] = ["runtime_id" => $item->getId() + ($item->getId() > 0 ? 5000 : -5000), "component_based" => true];
        }
        $data = file_get_contents(RESOURCE_PATH . '/vanilla/r16_to_current_item_map.json');
        $json = json_decode($data, true);
        $add = $array['r16_to_current_item_map'];
        $json["simple"] = array_merge($json["simple"], $add["simple"]);
        $legacyStringToIntMapRaw = file_get_contents(RESOURCE_PATH . '/vanilla/item_id_map.json');
        $add = $array["item_id_map"];
        $legacyStringToIntMap = json_decode($legacyStringToIntMapRaw, true);
        $legacyStringToIntMap = array_merge($add, $legacyStringToIntMap);
        $simpleMappings = [];
        foreach ($json["simple"] as $oldId => $newId) {
            $simpleMappings[$newId] = $legacyStringToIntMap[$oldId];
        }
        foreach ($legacyStringToIntMap as $stringId => $intId) {
            $simpleMappings[$stringId] = $intId;
        }
        $complexMappings = [];
        foreach ($json["complex"] as $oldId => $map) {
            foreach ($map as $meta => $newId) {
                $complexMappings[$newId] = [$legacyStringToIntMap[$oldId], (int)$meta];
            }
        }


        $old = json_decode(file_get_contents(RESOURCE_PATH . '/vanilla/required_item_list.json'), true);
        $add = $array["required_item_list"];
        $table = array_merge($old, $add);
        $params = [];
        foreach ($table as $name => $entry) {
            $params[] = new ItemTypeEntry($name, $entry["runtime_id"], $entry["component_based"]);
        }
        self::$entries = $entries = (new ItemTypeDictionary($params))->getEntries();
        foreach ($entries as $entry) {
            $stringId = $entry->getStringId();
            $netId = $entry->getNumericId();
            if (isset($complexMappings[$stringId])) {
            } elseif (isset($simpleMappings[$stringId])) {
                self::$simpleCoreToNetMapping[$simpleMappings[$stringId]] = $netId;
                self::$simpleNetToCoreMapping[$netId] = $simpleMappings[$stringId];
            }
        }
        CreativeInventory::getInstance()->clear();
        $creativeItems = json_decode(file_get_contents(Path::join(RESOURCE_PATH, "vanilla", "creativeitems.json")), true);
        foreach (self::$queue as $item) {

            if (!ItemFactory::getInstance()->isRegistered($item->getId())) {
                ItemFactory::getInstance()->register($item);
                CreativeInventory::getInstance()->add($item);
            } else {
                ItemFactory::getInstance()->register($item, true);
                CreativeInventory::getInstance()->add($item);
            }
        }

        foreach($creativeItems as $data){
            $item = Item::jsonDeserialize($data);
            if($item->getName() === "Unknown"){
                continue;
            }
            CreativeInventory::getInstance()->add($item);
        }
        $instance = ItemTranslator::getInstance();
        $ref = new ReflectionObject($instance);
        $r1 = $ref->getProperty("simpleCoreToNetMapping");
        $r2 = $ref->getProperty("simpleNetToCoreMapping");
        $r1->setAccessible(true);
        $r2->setAccessible(true);
        $r1->setValue($instance, self::$simpleCoreToNetMapping);
        $r2->setValue($instance, self::$simpleNetToCoreMapping);
    }
    public static function registerItem(Item $item): void {
        if($item instanceof AetheriumItem || $item instanceof AetheriumArmor  ) {
            array_push(self::$components, new ItemComponentPacketEntry('aetherium:' . $item->getName(), $item->getNbt()));
            array_push(self::$queue, $item);
        }
    }

    public static function Init(): void{
        self::loadDataFiles();
        self::$packet = ItemComponentPacket::create(self::$components);
    }
}
