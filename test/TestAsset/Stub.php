<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\TestAsset;

use Laminas\ProgressBar\ProgressBar;

class Stub extends ProgressBar
{
    /** @var MockUp */
    protected $adapter;

    public function sleep(int $seconds): void
    {
        $this->startTime -= $seconds;
    }

    public function getCurrent(): float
    {
        return $this->adapter->getCurrent();
    }

    public function getMax(): float
    {
        return $this->adapter->getMax();
    }

    public function getPercent(): float
    {
        return $this->adapter->getPercent();
    }

    public function getTimeTaken(): int
    {
        return $this->adapter->getTimeTaken();
    }

    public function getTimeRemaining(): int|null
    {
        return $this->adapter->getTimeRemaining();
    }

    public function getText(): string
    {
        return $this->adapter->getText();
    }
}
