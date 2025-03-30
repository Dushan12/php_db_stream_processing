<?php

namespace exploratory;

include_once(__DIR__."/../../src/app/repository/PostsRepository.php");
include_once(__DIR__."/../../src/app/repository/models/Post.php");

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AttributeDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
use MongoDB\Client;
use PHPUnit\Framework\TestCase;
use src\app\repository\models\Post;
use src\app\repository\PostsRepository;

final class fillMongoDbWithDataTest extends TestCase
{

    private DocumentManager $dm;

    protected function setUp(): void
    {
        $config = new Configuration();
        $config->setProxyDir(__DIR__ . '/../../src/app/repository/Proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir(__DIR__ . '/../../src/app/repository/Hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setDefaultDB('stream_processing');
        $config->setMetadataDriverImpl(AttributeDriver::create(__DIR__ . '/../../src/app/repository/Documents'));
        $connectionString = "mongodb://127.0.0.1:27017";
        $client = new Client($connectionString);
        $this->dm = DocumentManager::create($client, $config);
    }

    protected function tearDown(): void
    {

    }


    /**
     * @throws \Throwable
     * @throws MongoDBException
     */
    public function testUsersRepositoryCrudUsersTest()
    {
        $target = new PostsRepository($this->dm);
        $target->deleteAllPosts();
        $input = new Post('Post Body', 'Post Title');
        $target->savePost($input);
        $actual  = $target->getAllPosts();
        $firstElement = $actual[0];
        $arrayLength = sizeOf($actual);
        $this->assertSame($arrayLength, 1);
        $this->assertSame($firstElement->body,'Post Body');
        $this->assertSame($firstElement->title, 'Post Title');
        $target = new PostsRepository($this->dm);
        $deleteResult = $target->deleteAllPosts();
        $this->assertSame($deleteResult, 1);
    }

}