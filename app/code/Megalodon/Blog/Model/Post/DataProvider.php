<?php

declare(strict_types=1);

namespace Megalodon\Blog\Model\Post;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Megalodon\Blog\Model\Post;
use Megalodon\Blog\Model\PostFactory;
use Megalodon\Blog\Model\ResourceModel\Post as PostResource;
use Megalodon\Blog\Model\ResourceModel\Post\CollectionFactory;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var array
     */
    private array $loadedData;
    private PostFactory $postFactory;
    private PostResource $resource;
    private RequestInterface $request;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param PostResource $resource
     * @param PostFactory $postFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        PostResource $resource,
        PostFactory $postFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->request = $request;
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $post = $this->getCurrentPost();
        $this->loadedData[$post->getId()] = $post->getData();

        return $this->loadedData;
    }

    /**
     * @return Post
     */
    private function getCurrentPost(): Post
    {
        $postId = $this->getPostId();
        $post = $this->postFactory->create();
        if (!$postId) {
            return $post;
        }

        $this->resource->load($post, $postId);

        return $post;
    }

    /**
     * @return int
     */
    private function getPostId()
    {
        return $this->request->getParam($this->getRequestFieldName());
    }
}
