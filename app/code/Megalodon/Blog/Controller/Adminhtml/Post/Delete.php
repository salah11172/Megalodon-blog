<?php

namespace Megalodon\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Megalodon\Blog\Model\PostFactory;
use Megalodon\Blog\Model\ResourceModel\Post as PostResource;

class Delete extends Action implements HttpPostActionInterface
{
    private PostResource $resource;
    private PostFactory $postFactory;

    public function __construct(
        Context      $context,
        PostResource $resource,
        PostFactory  $postFactory
    ) {
        $this->postFactory = $postFactory;
        $this->resource = $resource;
        parent::__construct($context);
    }
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $postId = $this->getRequest()->getParam('post_id');

        if (!$postId) {
            $this->messageManager->addErrorMessage(__('can\'t find post'));
            return $resultRedirect->setPath('*/*/');
        }
        $model = $this->postFactory->create();

        try {
            $this->resource->load($model, $postId);
            $this->resource->delete($model);
            $this->messageManager->addSuccessMessage(__('The post has been deleted'));

        } catch (\Throwable $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
