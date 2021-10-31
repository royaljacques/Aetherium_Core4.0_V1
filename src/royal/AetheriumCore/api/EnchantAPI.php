<?php
namespace royal\AetheriumCore\api;


use pocketmine\block\Block;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\Item;
use pocketmine\utils\SingletonTrait;
use royal\AetheriumCore\api\enchantments\Foreuse;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\Other\CustomEnchantments;
use royal\AetheriumCore\utils\ModedId;

final class EnchantAPI
{
    use SingletonTrait, Foreuse;
    public const Foreuse = 50;
    public const TREFLE_VERT = 51;
    public function __construct(Main $plugin)
    {
        EnchantmentIdMap::getInstance()->register(self::Foreuse ,CustomEnchantments::FOREUSE());
        EnchantmentIdMap::getInstance()->register(self::TREFLE_VERT ,CustomEnchantments::TREFLE());
    }

    public static function getEnchantmentHammer(Item $item, Block $block)
    {
        $enchantments = $item->getEnchantments();
        if ($item->getId() === ModedId::HAMMER){
            foreach ($enchantments as $enchant) {
                if ($enchant->getType()->getName() == CustomEnchantments::FOREUSE()) {
                    self::getLevelEnchant($enchant->getLevel(), $block);
                } else {
                    self::getLevelEnchant(4, $block);
                }
            }
        }

    }
}