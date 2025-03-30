<?php

namespace src\app\repository\models;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

#[Document(collection: 'posts')]
class Post {


    #[Id]
    public string $id;
    #[Field(type: "string")]
    public string $body;
    #[Field(type: "string")]
    public string $title;

    public function __construct( string $body = "", string $title = "")
    {
        $this->body = $body;
        $this->title = $title;
    }

}