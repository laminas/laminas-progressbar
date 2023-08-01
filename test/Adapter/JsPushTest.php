<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\Adapter;

use LaminasTest\ProgressBar\TestAsset\JsPushStub;
use PHPUnit\Framework\TestCase;

use function json_decode;
use function preg_match;
use function preg_quote;

use const JSON_THROW_ON_ERROR;

class JsPushTest extends TestCase
{
    public function testJson()
    {
        $result = [];

        $adapter = new JsPushStub(['finishMethodName' => 'Laminas\ProgressBar\ProgressBar\Finish']);
        $adapter->notify(0, 2, 0.5, 1, 1, 'status');
        $output = $adapter->getLastOutput();

        $matches = preg_match('#<script type="text/javascript">parent.'
            . preg_quote('Laminas\\ProgressBar\\ProgressBar\\Update') . '\((.*?)\);</script>#', $output, $result);
        $this->assertEquals(1, $matches);

        $data = json_decode($result[1], true, JSON_THROW_ON_ERROR);

        $this->assertEquals(0, $data['current']);
        $this->assertEquals(2, $data['max']);
        $this->assertEquals(50, $data['percent']);
        $this->assertEquals(1, $data['timeTaken']);
        $this->assertEquals(1, $data['timeRemaining']);
        $this->assertEquals('status', $data['text']);

        $adapter->finish();
        $output = $adapter->getLastOutput();

        $matches = preg_match('#<script type="text/javascript">parent.'
            . preg_quote('Laminas\ProgressBar\ProgressBar\Finish') . '\(\);</script>#', $output, $result);
        $this->assertEquals(1, $matches);
    }
}
