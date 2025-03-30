<?php

namespace root;

ini_set('memory_limit', '10M');
set_time_limit(360);

require_once __DIR__ . '/vendor/autoload.php';

include_once(__DIR__."/src/app/repository/PostsRepository.php");
include_once(__DIR__."/src/app/repository/models/Post.php");

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AttributeDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
use MongoDB\Client;
use PHPUnit\Framework\TestCase;
use src\app\repository\models\Post;
use src\app\repository\PostsRepository;


$config = new Configuration();
$config->setProxyDir(__DIR__ . '/src/app/repository/Proxies');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/src/app/repository/Hydrators');
$config->setHydratorNamespace('Hydrators');
$config->setDefaultDB('stream_processing');
$config->setMetadataDriverImpl(AttributeDriver::create(__DIR__ . '/src/app/repository/Documents'));
$connectionString = "mongodb://127.0.0.1:27017";
$client = new Client($connectionString);
$dm = DocumentManager::create($client, $config);

$target = new PostsRepository($dm);

$resultsIterator = $target->getAllPostsCursor();

foreach ($resultsIterator as $document) {
   echo $document["title"];
}
