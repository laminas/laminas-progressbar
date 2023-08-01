<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\TestAsset;

use Laminas\ProgressBar\Adapter\JsPull;

class JsPullStub extends JsPull
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
