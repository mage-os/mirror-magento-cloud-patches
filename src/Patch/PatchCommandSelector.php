<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CloudPatches\Patch;

/**
 * Patch command selector
 */
class PatchCommandSelector implements PatchCommandInterface
{
    /**
     * @var PatchCommandInterface[]
     */
    private $commands;

    /**
     * @param PatchCommandInterface[] $commands
     */
    public function __construct(
        array $commands
    ) {
        $this->commands = $commands;
    }

    /**
     * @inheritDoc
     */
    public function apply(string $patch)
    {
        $this->getCommand()->apply($patch);
    }

    /**
     * @inheritDoc
     */
    public function revert(string $patch)
    {
        $this->getCommand()->revert($patch);
    }

    /**
     * @inheritDoc
     */
    public function applyCheck(string $patch)
    {
        $this->getCommand()->applyCheck($patch);
    }

    /**
     * @inheritDoc
     */
    public function reverseCheck(string $patch)
    {
        $this->getCommand()->reverseCheck($patch);
    }

    /**
     * @inheritDoc
     */
    public function isInstalled(): bool
    {
        return $this->getCommand()->isInstalled();
    }

    /**
     * Return first available command
     */
    private function getCommand()
    {
        foreach ($this->commands as $command) {
            if ($command->isInstalled()) {
                return $command;
            }
        }
        throw new PatchCommandNotFound();
    }
}
