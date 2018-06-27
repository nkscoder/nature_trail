<?php
/**
 * Created by PhpStorm.
 * User: nitesh
 * Date: 17/4/18
 * Time: 8:07 PM
 */

namespace Nitesh\Singh\Controller\Post;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\View\Result\Page;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\Registry;


class Users extends Action
{
    const REGISTRY_KEY_POST_ID = 'nitesh_singh_singh_id';

    /**
     * Core registry
     * @var Registry
     *
     */
    protected $customerSession;


    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     *
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory





    ) {
        parent::__construct(
            $context
        );
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;



    }

    /**
     * Saves the blog id to the register and renders the page
     * @return Page
     * @throws LocalizedException
     */

    public function execute()
    {

        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $om->get('Magento\Customer\Model\Session');
        $customerData = $customerSession->getCustomer()->getData();
        if (isset($customerData['entity_id'])) {

            $this->_coreRegistry->register(self::REGISTRY_KEY_POST_ID, (int)$this->_request->getParam('id'));
            $resultPage = $this->_resultPageFactory->create();
            return $resultPage;

        } else {


            $this->_redirect('/');


        }
    }

}