<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 16:16
 */

namespace SimpleLogger\Tests;

use PHPUnit\Framework\TestCase;
use SimpleLogger\SimpleLogger;

/**
 * Class SimpleLoggerTest
 * @package SimpleLogger\Tests
 */
class SimpleLoggerTest extends TestCase
{
    public function testWarningOutToConsole()
    {
        $logger = new SimpleLogger();

        $expectedString = '1234';
        $this->expectOutputRegex('/\[warning\]/');
        $logger->addWarning($expectedString);
        $this->expectOutputRegex('/'.$expectedString.'/');
        $logger->addWarning($expectedString);
    }

    public function testInfoOutToConsole()
    {
        $logger = new SimpleLogger();

        $expectedString = '1234';
        $this->expectOutputRegex('/\[info\]/');
        $logger->addInfo($expectedString);
        $this->expectOutputRegex('/'.$expectedString.'/');
        $logger->addInfo($expectedString);
    }

    public function testCriticalOutToConsole()
    {
        $logger = new SimpleLogger();

        $this->expectOutputRegex('/\[critical\]/');
        $logger->addCritical('');
    }

    public function testDebugOutToConsole()
    {
        $logger = new SimpleLogger();

        $expectedString = '1234';
        $this->expectOutputRegex('/\[debug\]/');
        $this->expectOutputRegex('/'.$expectedString.'/');
        $logger->addDebug($expectedString);
    }

    public function testDebugOutToConsoleWithVerbose()
    {
        $logger = new SimpleLogger(SimpleLogger::INFO);

        $expectedString = '1234';
        $this->expectOutputRegex('/^(\[debug\])/');
        $this->expectOutputRegex('/^('.$expectedString.')/');
        $logger->addDebug($expectedString);
        $expectedString = '1235';
        $this->expectOutputRegex('/\[info\]/');
        $this->expectOutputRegex('/'.$expectedString.'/');
        $logger->addInfo($expectedString);
    }
}
