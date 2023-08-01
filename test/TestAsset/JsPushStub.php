<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\TestAsset;

use Laminas\ProgressBar\Adapter\JsPush;

class JsPushStub extends JsPush
{
    // @codingStandardsIgnoreStart
    protected $_lastOutput = null;
    // @codingStandardsIgnoreEnd

    public function getLastOutput()
    {
        return $this->_lastOutput;
    }

    // @codingStandardsIgnoreStart
    protected function _outputData($data)
    {
        // @codingStandardsIgnoreEnd
        $this->_lastOutput = $data;
    }
}
