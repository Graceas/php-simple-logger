<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-10-19
 * Time: 20:43
 */

namespace SimpleLogger;

/**
 * Class SimpleLogger
 * @package SimpleLogger
 */
class SimpleLogger
{
    /**
     * Detailed debug information
     */
    const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    const INFO = 200;

    /**
     * Uncommon events
     */
    const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    const WARNING = 300;

    /**
     * Runtime errors
     */
    const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    const ALERT = 550;

    /**
     * Urgent alert.
     */
    const EMERGENCY = 600;

    /**
     * @var int
     */
    protected $loggerLevel = self::DEBUG;

    /**
     * Logging levels from syslog protocol defined in RFC 5424
     *
     * @var array $levels Logging levels
     */
    protected static $levels = array(
        100 => 'DEBUG',
        200 => 'INFO',
        250 => 'NOTICE',
        300 => 'WARNING',
        400 => 'ERROR',
        500 => 'CRITICAL',
        550 => 'ALERT',
        600 => 'EMERGENCY',
    );

    /**
     * @var array
     */
    protected $foregroundColors = array(
        'black' => '0;30',
        'blue'  => '0;34',
        'green' => '0;32',
        'red'   => '0;31',
        'white' => '1;37',
        'brown' => '0;33',
    );

    /**
     * @var array
     */
    protected $backgroundColors = array(
        'black' => '40',
        'red'   => '41',
        'green' => '42',
        'blue'  => '44',
    );

    /**
     * SimpleLogger constructor.
     * @param int $loggerLevel
     */
    public function __construct($loggerLevel = self::DEBUG)
    {
        $this->loggerLevel = $loggerLevel;
    }

    /**
     * @param string $text
     */
    public function addWarning($text)
    {
        $this->outToConsole($text, self::WARNING);
    }

    /**
     * @param string $text
     */
    public function addCritical($text)
    {
        $this->outToConsole($text, self::CRITICAL);
    }

    /**
     * @param string $text
     */
    public function addInfo($text)
    {
        $this->outToConsole($text, self::INFO);
    }

    /**
     * @param string $text
     */
    public function addDebug($text)
    {
        $this->outToConsole($text, self::DEBUG);
    }

    /**
     * @param string $text
     * @param int    $type
     */
    public function outToConsole($text, $type = self::DEBUG)
    {
        if ($this->loggerLevel >= $type) {
            printf('%s%s%s', $this->getMark($type), $text, PHP_EOL);
        }
    }

    /**
     * @param int $type
     *
     * @return string
     */
    protected function getMark($type)
    {
        $date      = date('Y-m-d H:i:s');
        $time      = date('H:i:s');
        $timestamp = time();
        $additionalData = '['.$timestamp.']'.'['.$date.']'.'['.$time.'] ';

        switch ($type) {
            case self::DEBUG:
                return $this->getColoredString('[debug]', 'green').$additionalData;
            case self::INFO:
                return $this->getColoredString('[info]', 'blue').$additionalData;
            case self::WARNING:
                return $this->getColoredString('[warning]', 'brown').$additionalData;
            case self::CRITICAL:
                return $this->getColoredString('[critical]', 'red').$additionalData;
            default:
                return '['.$type.']'.$additionalData;
        }
    }

    /**
     * @param string $string
     * @param string $foregroundColor
     * @param string $backgroundColor
     *
     * @return string
     */
    protected function getColoredString($string, $foregroundColor = null, $backgroundColor = null)
    {
        $coloredString = "";

        // Check if given foreground color found
        if (isset($this->foregroundColors[$foregroundColor])) {
            $coloredString .= "\033[".$this->foregroundColors[$foregroundColor]."m";
        }
        // Check if given background color found
        if (isset($this->backgroundColors[$backgroundColor])) {
            $coloredString .= "\033[".$this->backgroundColors[$backgroundColor]."m";
        }

        // Add string and end coloring
        $coloredString .=  $string."\033[0m";

        return $coloredString;
    }
}
