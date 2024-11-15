<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class Image implements ReadableFromDB, Renderable
{
    private int $id;
    private string $filetype;
    private string $description;
    private string $data;

    public function __construct(int $id, string $filetype, string $description, string|null $data)
    {
        $this->id = $id;
        $this->filetype = $filetype;
        $this->description = $description;
        $this->data = $data??"";
    }

    public static function createFromDb(mixed $obj): Image
    {
        return new Image($obj->id, $obj->filetype, $obj->description, $obj->data);
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new InvalidPropertyNameException($name);
        }
    }

    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new InvalidPropertyNameException($name);
        }
    }
}