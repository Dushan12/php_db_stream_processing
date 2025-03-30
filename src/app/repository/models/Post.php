<?php

namespace src\repository\models;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

#[Document(collection: 'posts')]
class Post {

    #[Id(type: 'string')]
    public ?string $id;
    #[Field(type: "string")]
    public string $body;
    #[Field(type: "string")]
    public string $title;

    public function __construct(?string $id = null, string $body = "", string $title = "")
    {
        $this->id = $id;
        $this->body = $body;
        $this->title = $title;
    }

}