<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\TestAsset;

use Laminas\ProgressBar\Adapter\AbstractAdapter;

class MockUp extends AbstractAdapter
{
    // @codingStandardsIgnoreStart
    protected float $_current;
    protected float $_max;
    protected float $_percent;
    protected int $_timeTaken;
    protected int|null $_timeRemaining;
    protected string $_text;
    // @codingStandardsIgnoreEnd

    /** @inheritDoc */
    public function notify($current, $max, $percent, $timeTaken, $timeRemaining, $text)
    {
        $this->_current       = $current;
        $this->_max           = $max;
        $this->_percent       = $percent;
        $this->_timeTaken     = $timeTaken;
        $this->_timeRemaining = $timeRemaining;
        $this->_text          = $text;
    }

    public function finish()
    {
    }

    public function getCurrent(): float
    {
        return $this->_current;
    }

    public function getMax(): float
    {
        return $this->_max;
    }

    public function getPercent(): float
    {
        return $this->_percent;
    }

    public function getTimeTaken(): int
    {
        return $this->_timeTaken;
    }

    public function getTimeRemaining(): int|null
    {
        return $this->_timeRemaining;
    }

    public function getText(): string
    {
        return $this->_text;
    }
}
