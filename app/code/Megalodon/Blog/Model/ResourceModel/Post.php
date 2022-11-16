<?php

namespace Megalodon\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'megalodon_blog_post_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('megalodon_blog_post', 'post_id');
        $this->_useIsObjectNew = true;
    }
}
