<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * The base Inline Object Class
 *
 * To initialise quickly you can use the following array to construct the object:
 */
abstract class InlineBaseObject extends Collection
{
    /** @var string Type */
    protected string $type;

    /**
     * InlineBaseObject constructor.
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', $this->type);
    }

    /**
     * Magic method to set properties dynamically.
     *
     * @param $name
     * @param $arguments
     *
     * @return $this|mixed
     */
    public function __call($name, $arguments)
    {
        if (! Str::startsWith($name, 'set')) {
            throw new \BadMethodCallException("Method {$name} does not exist.");
        }
        $property = Str::snake(substr($name, 3));
        $this->put($property, $arguments[0]);

        return $this;
    }
}
