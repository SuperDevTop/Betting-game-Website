<?php

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;

function flash($message, $level = 'info', $class = 'info-bg')
{
    session()->flash('flash_message', $message);
    session()->flash('flash_class', $class);
    session()->flash('flash_message_level', $level);
}

function mpr($d, $echo = true)
{
    if ($echo) {
        echo '<pre>'.print_r($d, true).'</pre>';
    } else {
        return '<pre>'.print_r($d, true).'</pre>';
    }
}

function mprd($d)
{
    mpr($d);
    die;
}

function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function randomInteger($num=6)
{
    $value = 1;
    $start = str_pad($value, $num, '0', STR_PAD_RIGHT);
    $end   = ($start*10) - 1;
    return mt_rand($start, $end);
}

function serializeEnc($array)
{
    return encrypt(serialize($array));
}

function serializeDec($array)
{
    return unserialize(decrypt($array));
}
function truncateDateToDay($time)
{
    $reset = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $stamp = strtotime('today', $time);
    date_default_timezone_set($reset);
    return $stamp;
}
