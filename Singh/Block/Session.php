<?php
/**
 * Created by PhpStorm.
 * User: nitesh
 * Date: 17/4/18
 * Time: 7:31 PM
 */

namespace Nitesh\Singh\Block;


use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Nitesh\Singh\Model\ResourceModel\Post\Collection as PostCollection;
use \Nitesh\Singh\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use \Nitesh\Singh\Model\Post;

class Session  extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $_postCollectionFactory = null;
    protected $customerSession;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PostCollectionFactory $postCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession,

        array $data = []
    )
    {
        $this->customerSession = $customerSession;

        parent::__construct($context, $data);
    }

    /**
     * @return Post[]
     */
    public function getCustomersId()
    {
        /** @var PostCollection $postCollection */
//       var_dump($this->customerSession->getCustomer()->getId()); die();
        return  $this->customerSession->getCustomer()->getId();

    }

    /**
     * For a given post, returns its url
     * @param Post $post
     * @return string
     */
    public function getPostUrl(
        Session $post
    ) {
        return '/singh/post/view/id/' . $post->getId();
    }

}