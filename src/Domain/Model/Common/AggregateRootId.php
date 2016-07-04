<?php

namespace Domain\Model\Common;

use Ramsey\Uuid\Uuid;

abstract class AggregateRootId
{
    private $id;

    private function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }

    /**
     * @return static
     */
    public static function fromString(string $id)
    {
        return new static($id);
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}
