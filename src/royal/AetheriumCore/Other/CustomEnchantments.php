<?php
namespace royal\AetheriumCore\Other;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Rarity;
use pocketmine\utils\RegistryTrait;


/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see build/generate-registry-annotations.php
 * @generate-registry-docblock
 *
 * @method static Enchantment FOREUSE()
 *
 * @method static Enchantment TREFLE()
 */
final class CustomEnchantments{
    use RegistryTrait;

    public const TOOL_TREFLE = ItemFlags::AXE | ItemFlags::HOE | ItemFlags::PICKAXE;
    public static function setup(): void
    {
        self::register("FOREUSE", new Enchantment("Foreuse", Rarity::MYTHIC, ItemFlags::PICKAXE, ItemFlags::SHEARS, 3));
        self::register("TREFLE", new Enchantment("TREFLE", Rarity::MYTHIC, self::TOOL_TREFLE, ItemFlags::SHEARS, 2));
    }
    protected static function register(string $name, Enchantment $member) : void{
        self::_registryRegister($name, $member);
    }

    /**
     * @return Enchantment[]
     * @phpstan-return array<string, Enchantment>
     */
    public static function getAll() : array{
        /**
         * @var Enchantment[] $result
         * @phpstan-var array<string, Enchantment> $result
         */
        $result = self::_registryGetAll();
        return $result;
    }

    public static function fromString(string $name) : Enchantment{
        /** @var Enchantment $result */
        $result = self::_registryFromString($name);
        return $result;
    }
}