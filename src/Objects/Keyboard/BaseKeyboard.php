<?php

namespace Telegram\Bot\Objects\Keyboard;

use Illuminate\Support\Str;
use JsonSerializable;

abstract class BaseKeyboard implements JsonSerializable
{
    protected $items;
    protected string $type;

    /**
     * Create a new object.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
        $this->type = (static::class === ReplyKeyboardMarkup::class) ? 'keyboard' : 'inline_keyboard';
    }

    abstract public static function create();

    /**
     * Create a new row in keyboard to add buttons.
     *
     * @param array $buttons
     *
     * @return BaseKeyboard
     */
    public function row(...$buttons): self
    {
        $this->items[$this->type][] = $buttons;

        return $this;
    }

    /**
     * Dynamically build params.
     *
     * @param string $method
     * @param array  $args
     *
     * @return $this
     */
    public function __call($method, $args)
    {
        $property = Str::snake(substr($method, 3));
        $this->items[$property] = $args[0];

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->items;
    }
}
