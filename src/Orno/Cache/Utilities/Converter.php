<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see LICENSE file)
 */
namespace Orno\Cache\Utilities;

/**
 * Converter
 *
 * Utility class to convert date
 *
 * @author Michael Bardsley <me@mic-b.co.uk>
 */
class Converter
{
    /**
     * Converts a time string into seconds
     *
     * e.g.
     * 1w = 1 Week
     * 6d = 6 Days
     * 12h = 12 Hours
     * 55m = 55 Minutes
     * 12s = 12 seconds
     *
     * This can be place in a string seperated by spaces
     *
     * "6w 20d 19h 15m 43s"
     *
     * @param string $string
     * @return int
     */
    public function timeStringToSeconds($string)
    {
        $ex = explode(" ", $string);
        $value = 0;

        foreach ($ex as $key => $segment) {
            $segment = strtolower($segment);
            $timeUnit = $this->extractString($segment);

            switch ($timeUnit) {
                case 'w':
                    //week
                    $multiplier = 60 * 60 * 24 * 7;
                    break;
                case 'd':
                    //day
                    $multiplier = 60 * 60 * 24;
                    break;
                case 'h':
                    //hour
                    $multiplier = 60 * 60;
                    break;
                case 'm':
                    //minutes
                    $multiplier = 60;
                    break;
                case 's':
                default:
                    //seconds
                    $multiplier = 0;
                    break;
            }

            $value += (int) $this->extractNumbers($segment) * $multiplier;
        }
        return $value;
    }

    protected function extractNumbers($string)
    {
        $matches = [];
        preg_match('/([\d]+)/', $string, $matches);
        return (! empty($matches)) ? $matches[0] : false;
    }

    protected function extractString($string)
    {
        $matches = [];
        preg_match('/([w|d|h|m|s])/', $string, $matches);
        return (! empty($matches)) ? $matches[0] : false;
    }
}
