<?php

namespace Megalodon\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;


class Edit extends Action implements HttpGetActionInterface
{
    public function execute(): Page
    {
        $pageResult = $this->createPageResult();
        $title = $pageResult->getConfig()->getTitle();
        $title->prepend(__('Posts'));
        $title->prepend(__('New Post'));

        return $pageResult;
    }

    private function createPageResult(): Page
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
