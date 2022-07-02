<?php

declare(strict_types=1);

namespace Krishvy\SimpleRepair;

use pocketmine\plugin\PluginBase;
use Krishvy\SimpleRepair\RepairCommand;

class SimpleRepair extends PluginBase
{
    public function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register("repair", new RepairCommand());
    }
}
