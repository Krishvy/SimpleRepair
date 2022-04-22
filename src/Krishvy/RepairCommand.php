<?php

declare(strict_types=1);

namespace Krishvy;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Durable;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class RepairCommand extends Command
{
    public function __construct()
    {
        parent::__construct("repair", "Repair all items in your inventory or repair the item in ur hand");
        $this->setPermission("repaircommand.use");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(!$sender instanceof Player){
            return true;
        }
        if(!$this->testPermission($sender)){
            return true;
        }
        if(count($args) < 1) {
            $sender->sendMessage(TextFormat::RED . "Usage: /repair [all/hand/armor]");
            return true;
        }
        switch($args[0]){
            case "all":
                foreach($sender->getInventory()->getContents() as $index => $item){
                    if($item instanceof Durable){
                        $sender->getInventory()->setItem($index, $item->setDamage(0));
                    }
                }
                $sender->sendMessage(TextFormat::GREEN."Successfully repaired all items in your inventory.");
                break;
            case "hand":
                $index = $sender->getInventory()->getHeldItemIndex();
                $item = $sender->getInventory()->getItem($index);
                if(!$item instanceof Durable){
                    $sender->sendMessage(TextFormat::RED."Cannot repair item.");
                }
                $sender->getInventory()->setItem($index, $item->setDamage(0));
                break;
            case "armor":
                foreach($sender->getArmorInventory()->getContents() as $index => $item) {
                    if (!$item instanceof Durable) {
                        return true;
                    }
                        $sender->getArmorInventory()->setItem($index, $item->setDamage(0));
                }
                $sender->sendMessage(TextFormat::GREEN."Successfully repaired all your equipped armor.");
                break;
        }
        return true;
    }
}