<?php

namespace Megalodon\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Megalodon\Blog\Model\ResourceModel\Post as ResourceModel;

class Post extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'megalodon_blog_post_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
