<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ProgressBar;

use Laminas\ProgressBar\ProgressBar;

/**
 * @category   Laminas
 * @package    Laminas_Console
 * @subpackage UnitTests
 * @group      Laminas_ProgressBar
 */
class AbstractUploadHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testGetCurrentlyInProgress()
    {
        $progressData = array(
            'total'    => 1000,
            'current'  => 500,
            'rate'     => 0,
            'message'  => '',
            'done'     => false,
        );
        $stub = $this->getMockForAbstractClass(
            'Laminas\ProgressBar\Upload\AbstractUploadHandler'
        );
        $stub->expects($this->any())
            ->method('getUploadProgress')
            ->will($this->returnValue($progressData));

        $progressData['id']      = '123';
        $progressData['message'] = '500B - 1000B';
        $this->assertEquals($progressData, $stub->getProgress('123'));
    }

    /**
     * @return void
     */
    public function testGetNoFileInProgress()
    {
        $status  = array(
            'total'    => 0,
            'current'  => 0,
            'rate'     => 0,
            'message'  => 'No upload in progress',
            'done'     => true
        );
        $stub = $this->getMockForAbstractClass(
            'Laminas\ProgressBar\Upload\AbstractUploadHandler'
        );
        $stub->expects($this->any())
            ->method('getUploadProgress')
            ->will($this->returnValue(false));
        $this->assertEquals($status, $stub->getProgress('123'));
    }

    /**
     * @return array
     */
    public function progressDataProvider()
    {
        return array(
            array(array(
                'total'    => 1000,
                'current'  => 200,
                'rate'     => 0,
                'message'  => '',
                'done'     => false,
            )),
            array(array(
                'total'    => 1000,
                'current'  => 600,
                'rate'     => 300,
                'message'  => '',
                'done'     => false,
            )),
            array(array(
                'total'    => 1000,
                'current'  => 1000,
                'rate'     => 500,
                'message'  => '',
                'done'     => true,
            )),
        );
    }

    /**
     * @dataProvider progressDataProvider
     * @param array $progressData
     * @return void
     */
    public function testProgressAdapterNotify($progressData)
    {
        $adapterStub = $this->getMockForAbstractClass(
            'Laminas\ProgressBar\Adapter\AbstractAdapter'
        );
        if ($progressData['done']) {
            $adapterStub->expects($this->once())
                ->method('finish');
        } else {
            $adapterStub->expects($this->once())
                ->method('notify');
        }

        $stub = $this->getMockForAbstractClass(
            'Laminas\ProgressBar\Upload\AbstractUploadHandler'
        );
        $stub->expects($this->once())
            ->method('getUploadProgress')
            ->will($this->returnValue($progressData));
        $stub->setOptions(array(
                               'session_namespace' => 'testSession',
                               'progress_adapter'  => $adapterStub,
                          ));

        $this->assertEquals('testSession', $stub->getSessionNamespace());
        $this->assertEquals($adapterStub, $stub->getProgressAdapter());

        $this->assertNotEmpty($stub->getProgress('123'));
    }

    /**
     * @dataProvider progressDataProvider
     * @param array $progressData
     * @return void
     */
    public function testProgressBarUpdate($progressData)
    {
        $adapterStub = $this->getMockForAbstractClass(
            'Laminas\ProgressBar\Adapter\AbstractAdapter'
        );
        if ($progressData['done']) {
            $adapterStub->expects($this->once())
                ->method('finish');
        } else {
            $adapterStub->expects($this->once())
                ->method('notify');
        }
        $progressBar = new ProgressBar(
            $adapterStub, 0, $progressData['total'], 'testSession'
        );


        $stub = $this->getMockForAbstractClass(
            'Laminas\ProgressBar\Upload\AbstractUploadHandler'
        );
        $stub->expects($this->once())
            ->method('getUploadProgress')
            ->will($this->returnValue($progressData));
        $stub->setOptions(array(
           'session_namespace' => 'testSession',
           'progress_adapter'  => $progressBar,
        ));

        $this->assertEquals('testSession', $stub->getSessionNamespace());
        $this->assertEquals($progressBar, $stub->getProgressAdapter());

        $this->assertNotEmpty($stub->getProgress('123'));
    }
}
