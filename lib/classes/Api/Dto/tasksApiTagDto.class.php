<?php

final class tasksApiTagDto implements JsonSerializable
{
    use tasksApiJsonSerializableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool|null
     */
    private $favorite;

    public function __construct(int $id, string $name, ?bool $favorite)
    {
        $this->id = $id;
        $this->name = $name;
        $this->favorite = $favorite;
    }
}
