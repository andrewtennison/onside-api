<?php
namespace Onside;

interface Log
{
    public function __construct(Config $config);
    public function write($message, $level = null);
}
