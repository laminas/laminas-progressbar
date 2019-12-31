<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ProgressBar\Adapter;

use Laminas\ProgressBar\Adapter;

class ConsoleStub extends Adapter\Console
{
    protected $lastOutput = null;

    public function getLastOutput()
    {
        return $this->lastOutput;
    }

    protected function _outputData($data)
    {
        $this->lastOutput = $data;
    }

    public function getCharset()
    {
        return $this->charset;
    }
}
