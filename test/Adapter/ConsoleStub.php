<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\Adapter;

use Laminas\ProgressBar\Adapter;

class ConsoleStub extends Adapter\Console
{
    protected $lastOutput;

    public function getLastOutput()
    {
        return $this->lastOutput;
    }

    // @codingStandardsIgnoreStart
    protected function _outputData($data)
    {
        // @codingStandardsIgnoreEnd
        $this->lastOutput = $data;
    }

    public function getCharset()
    {
        return $this->charset;
    }
}
