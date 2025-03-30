<?php
namespace src\app\repository;

require_once "models/Post.php";

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use src\app\repository\models\Post;
use Throwable;
use MongoDB\Driver\Cursor;
use Doctrine\ODM\MongoDB\Iterator\Iterator;

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
            ->createQueryBuilder(Post::class)
            ->find();
        $result = $job->getQuery()->execute();
        return $result->toArray();
    }

    /**
     * @throws MongoDBException
     */
    public function getAllPostsCursor(): Cursor
    {
        $mongoCollection = $this->mongoDbDocumentManager->getDocumentCollection(Post::class);
        $cursor = $mongoCollection->find([], ['typeMap' => ['root' => 'array', 'document' => 'array']]);
        return $cursor;
    }


    /**
     * @throws MongoDBException
     */
    public function getAllPostsIterator(): Iterator
    {
        $job  =
            $this->mongoDbDocumentManager
            ->createQueryBuilder(Post::class)
            ->hydrate(false)
            ->setRewindable(false)
            ->readonly()
            ->find();
        return $job->getQuery()->execute();
    }

    /**
     * @throws MongoDBException
     */
    public function getAllPostsIteratorHydrated(): Iterator
    {
        $job  =
            $this->mongoDbDocumentManager
            ->createQueryBuilder(Post::class)
            ->setRewindable(false)
            ->readonly()
            ->find();
        return $job->getQuery()->execute();
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