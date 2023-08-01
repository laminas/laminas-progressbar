<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\Adapter;

use Laminas\ProgressBar\Adapter;

class ConsoleStub extends Adapter\Console
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

    public function getCharset(): string
    {
        return $this->charset;
    }
}
