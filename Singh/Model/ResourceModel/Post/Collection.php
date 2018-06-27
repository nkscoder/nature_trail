<?php
namespace Nitesh\Singh\Model\ResourceModel\Post;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Remittance File Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Nitesh\Singh\Model\Post', 'Nitesh\Singh\Model\ResourceModel\Post');
    }
}