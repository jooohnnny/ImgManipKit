<?php

declare(strict_types=1);

namespace Johnny\ImageToolKit;

use Johnny\ImageToolKit\Factory\Contract;

class ImageToolKit implements Contract
{
    private $args;

    private $driver;

    public function __construct($args = [])
    {
        $this->args = $args;
    }

    public function driver($method)
    {
        $ilass = __NAMESPACE__.'\\Plugin\\'.ucfirst($method);
        if (class_exists($ilass)) {
            $this->driver = new $ilass($this->args);
            return $this;
        }

        throw new \InvalidArgumentException("Driver [{$method}] is not supported.");
    }

    /**
     * Constructs a new plugin object with an associative array of default driver.
     */
    public function __call($method, $args)
    {
        if (method_exists($this->driver, $method)) {
            // return $this->driver->$method(...$args);
            return tap($this->driver->$method(...$args), function ($result) {
            });
        }

        throw new \InvalidArgumentException("Method [{$method}] is not supported.");
    }
}
