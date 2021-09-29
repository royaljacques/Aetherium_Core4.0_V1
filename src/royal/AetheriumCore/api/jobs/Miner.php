<?php
namespace royal\AetheriumCore\api\jobs;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\types\Enchant;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use royal\AetheriumCore\Main;

trait Miner{
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	private function openMinerForm(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){
				case 0:
					$this->openMinerFormCommentXP($player);
			}
			return true;
		});
		$form->addButton("comment xp ?");
		(int)$level = $this->getConfig($player)->getNested("miner.level");
		(int)$xp = $this->getConfig($player)->getNested("miner.xp");
		$form->addButton("§5Niveaux:§d\n".$level);
		$form->addButton("§5xp:§d\n".$xp);
        $form->addButton("récompences");
		$player->sendForm($form);
	}
    protected function rewardMiner(Player $player){
        $form = new SimpleForm(function (Player $player, $data = null){
            if ($data === null){
                return true;
            }

            switch ($data){

                case 0:
                    if ($this->getConfig($player)->getNested("miner.reward.1") === 1){
                        $item = VanillaItems::DIAMOND_PICKAXE();
                        $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $player->getInventory()->addItem($item);
                        $player->sendMessage("tu vient de recevoir une pioche unbreaking 3");
                        $config = $this->getConfig($player);
                        $config->setNested("miner.reward.1", 2);
                        $config->save();
                    }else{
                        $player->sendMessage($this->getConfig($player)->getNested("miner.reward.1"));
                    }
                    break;
                case 1:
                    if ($this->getConfig($player)->getNested("miner.reward.2") === 1){
                        $player->sendMessage("tu viens de débloquer le craft du hammer ");
                        $config = $this->getConfig($player);
                        $config->setNested("miner.reward.2", 2);
                        $config->save();

                    }else{
                        $player->sendMessage($this->getConfig($player)->getNested("miner.reward.2"));
                    }
            }

            return true;
        });
        $form->setTitle("Aetherium-Jobs");
        //pioche enchantée soliditée 3
        $form->addButton("Niveaux 1\n".$this->getColorReward($this->getConfig($player)->getNested("miner.reward.1")));
        //craft du hammer
        $form->addButton("Niveaux 2\n".$this->getColorReward($this->getConfig($player)->getNested("miner.reward.2")));
        //graine pour armure modée

    }
    public function getColorReward(int $int): string
    {
        if ($int === 0){
            return TextFormat::GOLD."Pas récupérable";
        }elseif ($int === 1){
            return TextFormat::DARK_RED."récupérable";
        }elseif ($int === 2){
            return TextFormat::RED."déja récupéré";
        }
        return "ouvre un ticket bug";
    }
	private function openMinerFormCommentXP(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
		});
		$form->setTitle("Aetherium-Jobs");
		$form->setContent(
			"Afin de pouvoir xp, tu dois casser des block , ces block te donne pour : 
			\n §51 minerais de diamand: §d10xp
			\n §51 minerais d'azure: §d5xp
			\n §51 minerais de fer: §d3xp
			\n §51 minerais de charbon: §d1xp
			\n §51 minerais de redstone: §d1xp
			\n §51 minerais de lapis: §d2xp");
		$form->addButton("Fermer");
	}
}