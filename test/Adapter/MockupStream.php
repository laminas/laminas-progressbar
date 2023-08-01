<?php

declare(strict_types=1);

namespace LaminasTest\ProgressBar\Adapter;

use function parse_url;
use function strlen;
use function substr;

use const SEEK_CUR;
use const SEEK_END;
use const SEEK_SET;

class MockupStream
{
    private int $position;

    private string $test;

    /** @var array<string, string> */
    public static $tests = [];

    // @codingStandardsIgnoreStart
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        // @codingStandardsIgnoreEnd
        $url            = parse_url($path);
        $this->test     = $url["host"];
        $this->position = 0;

        static::$tests[$url["host"]] = '';
        return true;
    }

    // @codingStandardsIgnoreStart
    public function stream_read($count)
    {
        // @codingStandardsIgnoreEnd
        $ret             = substr(static::$tests[$this->test], $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }

    // @codingStandardsIgnoreStart
    public function stream_write($data)
    {
        // @codingStandardsIgnoreEnd
        $left                       = substr(static::$tests[$this->test], 0, $this->position);
        $right                      = substr(static::$tests[$this->test], $this->position + strlen($data));
        static::$tests[$this->test] = $left . $data . $right;
        $this->position            += strlen($data);
        return strlen($data);
    }

    // @codingStandardsIgnoreStart
    public function stream_tell()
    {
        // @codingStandardsIgnoreEnd
        return $this->position;
    }

    // @codingStandardsIgnoreStart
    public function stream_eof()
    {
        // @codingStandardsIgnoreEnd
        return $this->position >= strlen(static::$tests[$this->test]);
    }

    // @codingStandardsIgnoreStart
    public function stream_seek($offset, $whence)
    {
        // @codingStandardsIgnoreEnd
        switch ($whence) {
            case SEEK_SET:
                if ($offset < strlen(static::$tests[$this->test]) && $offset >= 0) {
                    $this->position = $offset;
                    return true;
                } else {
                    return false;
                }
                break;

            case SEEK_CUR:
                if ($offset >= 0) {
                    $this->position += $offset;
                    return true;
                } else {
                    return false;
                }
                break;

            case SEEK_END:
                if (strlen(static::$tests[$this->test]) + $offset >= 0) {
                    $this->position = strlen(static::$tests[$this->test]) + $offset;
                    return true;
                } else {
                    return false;
                }
                break;

            default:
                return false;
        }
    }

    public function __destruct()
    {
        unset(static::$tests[$this->test]);
    }
}
