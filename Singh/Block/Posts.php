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

class Posts extends Template
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
    
    
    public function getFeaturedTrails() {

        $postCollection = $this->_postCollectionFactory->create();
        $postCollection->addFieldToSelect('*');
        $postCollection->addFieldToFilter('singh_featured',1);
        $postCollection->load();
        //var_dump($postCollection->getSelect()->__toString());

        return $postCollection->getItems();

    }
    
    
    
    
    
      public function getAllTrails()


    {
        /** @var PostCollection $postCollection */


        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 1;
        $postCollection = $this->_postCollectionFactory->create();
        $search = trim($this->getRequest()->getParam('search'));
        $sort = trim($this->getRequest()->getParam('sort'));
        $postCollection->getSelect()->join( array('customer_entity'=> $postCollection->getTable('customer_entity')), 'customer_entity.entity_id = main_table.entity_id');

        if($search != '') {
            $postCollection->addFieldToFilter('singh_name',
                array('like' => '%' . $search . '%'));
        }
        if ($sort != '') {

            if($sort== '0'){
                
                $postCollection->addFieldToFilter('singh_popular','1');
                // $postCollection->setOrder('trails_popular', '1');

            }
            if($sort== '1'){
                $postCollection->setOrder('singh_id', 'desc');

            }
            if($sort== '2'){
                $postCollection->setOrder('singh_name', 'asc');

            }
//            $postCollection->setOrder('trails_id', ($sort==1 ? 'asc':'desc'));

        }

        $postCollection->setPageSize(21); $postCollection->setCurPage($page);
        return $postCollection;

    }


    protected function _prepareLayout() {
        parent::_prepareLayout();
        if ($this->getAllTrails()) {
            $pager = $this->getLayout()->createBlock( 'Magento\Theme\Block\Html\Pager' )->setAvailableLimit(array(21=>21,41=>41,61=>61))->setShowPerPage(true)->setCollection( $this->getAllTrails() );
            $this->setChild('pager', $pager);
            $this->getAllTrails()->load();
        }
        return $this;
       }


    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    
    public function searchKey(){
        return trim($this->getRequest()->getParam('search'));
    }
    
  
}