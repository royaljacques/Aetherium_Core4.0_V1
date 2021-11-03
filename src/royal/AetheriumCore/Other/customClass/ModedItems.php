<?php
namespace royal\AetheriumCore\Other\customClass;


use pocketmine\item\Item;
use pocketmine\utils\CloningRegistryTrait;
use royal\AetheriumCore\utils\ModedId;

/**
 * @method static Item ZINC_INGOTS()
 * @method static Item OCTANITE_INGOTS)
 */
final class ModedItems{
    use CloningRegistryTrait;

    private function __construct(){

    }

    protected static function register(string $name, Item $item) : void{
        self::_registryRegister($name, $item);
    }

    public static function fromString(string $name) : Item{
        $result = self::_registryFromString($name);
        assert($result instanceof Item);
        return $result;
    }

    /**
     * @return Item[]
     */
    public static function getAll() : array{
        //phpstan doesn't support generic traits yet :(
        /** @var Item[] $result */
        $result = self::_registryGetAll();
        return $result;
    }

    public static function setup(): void
    {
        $factory = ModedItemFactory::getInstance();
        self::register("zinc_ingots", $factory->get(ModedId::ZINC_INGOTS, 0));
        self::register("octanite_ingots", $factory->get(ModedId::OCTANITE_INGOTS, 0));
    }
}