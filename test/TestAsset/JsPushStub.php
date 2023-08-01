<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\TestAsset;

use Laminas\ProgressBar\Adapter\JsPush;

class JsPushStub extends JsPush
{
    private string $lastOutput;

    public function getLastOutput(): string
    {
        return $this->lastOutput;
    }

    // @codingStandardsIgnoreStart
    protected function _outputData($data)
    {
        // @codingStandardsIgnoreEnd
        $this->lastOutput = $data;
    }
}
