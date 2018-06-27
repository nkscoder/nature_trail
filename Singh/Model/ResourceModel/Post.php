<?php

namespace Nitesh\Singh\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    /**
     * Post Abstract Resource Constructor
     * @return void
     */
    protected function _construct()
    {
            $this->_init('nitesh_singh', 'singh_id');
    }
}