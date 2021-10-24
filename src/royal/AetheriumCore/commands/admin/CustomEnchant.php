<?php
namespace royal\AetheriumCore\commands\admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\Rarity;
use pocketmine\item\Item;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\Other\CustomEnchantments;

class CustomEnchant extends Command{
    public function __construct(Main $plugin)
    {
        parent::__construct("customenchant", "enchanter manuellement un item ", '', ["/ca <list, enchant>"]);
    }
    public const RARITY_COLORS = [
        Rarity::COMMON => TextFormat::GREEN,
        Rarity::UNCOMMON => TextFormat::DARK_GREEN,
        Rarity::RARE => TextFormat::YELLOW,
        Rarity::MYTHIC => TextFormat::GOLD
    ];

    public static function lvlToRomanNum(int $level) : string {
        $romanNumeralConversionTable = [
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1
        ];
        $romanString = "";
        while($level > 0){
            foreach($romanNumeralConversionTable as $rom => $arb){
                if($level >= $arb){
                    $level -= $arb;
                    $romanString .= $rom;
                    break;
                }
            }
        }
        return $romanString;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }
        if (!isset($args[0])){
            return $sender->sendMessage("tu dois faire : /ca <list, enchant> <name> level");
        }
        if ($args[0] === "list"){
            $contents = [
                "Voici les Enchantements customs éxistants :",
                "   - Foreuse, level 3 max",
                "   - Trefle, level 2 max "
            ];
            $sender->sendMessage(implode("\n", $contents));
            return true;
        }
        if(!isset($args[1])){
            return $sender->sendMessage("tu dois faire : /ca <list, enchant> <name> level");
        }
        if(!isset($args[2])){
            return $sender->sendMessage("tu dois faire : /ca <list, enchant> <name> level");
        }
        if($args[0] === "enchant"){
            $item = $sender->getInventory()->getItemInHand();
            if($item->isNull()){
                $sender->sendMessage(KnownTranslationFactory::commands_enchant_noItem());
                return true;
            }
            try{
                $enchantment = CustomEnchantments::fromString($args[1]);
            }catch(\InvalidArgumentException $e){
                $sender->sendMessage(KnownTranslationFactory::commands_enchant_notFound($args[1]));
                return true;
            }
            if ($item instanceof Item) {
                $item->addEnchantment(new EnchantmentInstance($enchantment, $args[2]));
                $lores = [];
                $enchants = array_filter($item->getEnchantments(), function ($enchantment) {
                    return $enchantment->getType()->getName();
                });
                foreach ($enchants as $enchantment) {
                    $lores[] = TextFormat::RESET . self::RARITY_COLORS[$enchantment->getType()->getRarity()] . $enchantment->getType()->getName() . " " . self::lvlToRomanNum($enchantment->getLevel());
                }
                $item->setLore($lores);
            }
            if($sender instanceof Player)$sender->getInventory()->setItemInHand($item);

        }else{
            $sender->sendMessage(KnownTranslationFactory::commands_enchant_notFound($args[1]));

        }
        return true;
    }
}