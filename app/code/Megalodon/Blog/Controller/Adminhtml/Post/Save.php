<?php

namespace Megalodon\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Megalodon\Blog\Model\PostFactory;
use Megalodon\Blog\Model\ResourceModel\Post as PostResource;

class Save extends Action implements HttpPostActionInterface
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
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->postFactory->create();
            if (empty($data['post_id'])) {
                $data['post_id'] = null;
            }

            $model->setData($data);

            try {
                $this->resource->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $exception) {
                $this->messageManager->addExceptionMessage($exception);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the post.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
