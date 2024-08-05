<?php

declare(strict_types=1);

namespace Johnny\ImageToolKit\Plugin;

abstract class AbstractPlugin
{
    private $args;

    protected function setArgs(array $args)
    {
        $this->args = $args;
    }
}
