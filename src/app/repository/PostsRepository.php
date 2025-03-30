<?php
namespace src\app\repository;

require_once "models/Post.php";

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use src\repository\models\Post;
use Throwable;

class PostsRepository {

    private DocumentManager $mongoDbDocumentManager;

    public function __construct(DocumentManager $mongoDb) {
        $this->mongoDbDocumentManager = $mongoDb;
    }

    /**
     * @throws MongoDBException
     */
    public function getAllPosts(): array
    {
        $job  =
            $this->mongoDbDocumentManager
            ->createQueryBuilder(User::class)
            ->find();
        $result = $job->getQuery()->execute();
        return $result->toArray();
    }

    /**
     * @throws MongoDBException
     * @throws Throwable
     */
    public function savePost(Post $post): void
    {
        $this->mongoDbDocumentManager->persist($post);
        $this->mongoDbDocumentManager->flush();
    }

    /**
     * @throws MongoDBException
     */
    public function deleteAllPosts(): int
    {
        $deleteResult = $this->mongoDbDocumentManager
            ->createQueryBuilder(Post::class)
            ->remove()
            ->getQuery()
            ->execute();
        return $deleteResult->getDeletedCount();
    }
}