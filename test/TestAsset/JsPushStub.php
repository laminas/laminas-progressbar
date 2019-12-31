<?php

namespace LaminasTest\ProgressBar\TestAsset;

class JsPushStub extends \Laminas\ProgressBar\Adapter\JsPush
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
