<?php
/**
 * Created by PhpStorm.
 * User: nitesh
 * Date: 16/4/18
 * Time: 4:59 PM
 */



namespace Nitesh\Singh\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Nitesh\Singh\Model\ResourceModel\Post\Collection as PostCollection;
use \Nitesh\Singh\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use \Nitesh\Singh\Model\Post;

class Users extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $_postCollectionFactory = null;
    public $sortOrder = 0;
    /**
     * Constructor
     *
     * @param Context $context
     * @param PostCollectionFactory $postCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory,
        array $data = []
    ) {
        $this->_postCollectionFactory = $postCollectionFactory;
        parent::__construct($context, $data);
        $this->sortOrder = $this->getRequest()->getParam('sort');
    }

    /**
     * @return Post[]
     */
    public function getPosts()
    {
        /** @var PostCollection $postCollection */

        $postCollection = $this->_postCollectionFactory->create();
        $search = trim($this->getRequest()->getParam('search'));
        $sort = trim($this->getRequest()->getParam('sort'));
        $postCollection->addFieldToSelect('*');
        $postCollection->getSelect()->join( array('customer_entity'=> $postCollection->getTable('customer_entity')), 'customer_entity.entity_id = main_table.entity_id');

        if($search != '') {
            $postCollection->addFieldToFilter('singh_name',
                array('like' => '%' . $search . '%'));
        }
        if ($sort != '') {

            // $postCollection->setOrder('created_at', ($sort==1 ? 'asc':'desc'));
            $postCollection->setOrder('singh_id', ($sort==1 ? 'asc':'desc'));

        }
        //   var_dump($postCollection->getSelect()->__toString()); die();

        $postCollection->load();

        return $postCollection->getItems();


    }

    /**
     * For a given post, returns its url
     * @param Post $post
     * @return string
     */
    public function getPostUrl(
        Post $post
    ) {
        return $this->getUrl().'singh/post/view/id/'. $post->getId();
    }




}