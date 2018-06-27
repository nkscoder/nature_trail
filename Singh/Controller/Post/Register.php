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


class Register extends Action
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

       if($this->getRequest()->getPostValue()){
           try {
               $post = $this->getRequest()->getPostValue();
               $bgImage = $this->getRequest()->getFiles('trails_url');
               $error=array();
               $extension=array("jpeg","jpg","png","gif");
               $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

               $directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');

                $rootPath  =  $directory->getRoot();

//               define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']."/");

               define("UPLOADS", $rootPath."/pub/media/singh/");
               if (!file_exists(UPLOADS)) {
                   mkdir(UPLOADS, 0777);

               }
               // echo '<pre>';
//                echo UPLOADS;
               $loop = 0;
               $file_name_new='';
               // print_r($_FILES);
               // Preprocess the array
               $preProcessedArr = array();
               foreach($_FILES['trails_url'] as $key=>$tmp) {
                   // find the length inside (number of files)
                   $i = count($tmp);
                   for($j = 0; $j < $i; $j++) {
                       $preProcessedArr[$j][$key] = $tmp[$j];
                   }
               }
                // echo "<pre>";
                // print_r($preProcessedArr); die;
               $img_list = null;
               foreach($preProcessedArr as $file){
                   
                   // var_dump($file); die();
                   $filename = $file['name'];
                   $filetmp = $file['tmp_name'];
                   $file_ext = explode('.',$filename);
                   $file_ext = strtolower(end($file_ext));
                   
                   $tmp_name = md5("trails_" . rand(10000,99999). $filename) . "." . $file_ext;
                   
                   //$file_name_new = uniqid('',true) .'.'. $file_ext;
                   $file_destination = UPLOADS .$tmp_name;
                   
                   if(!$img_list==null){
                        $img_list.=','.$tmp_name;
                   }else{
                        $img_list.=$tmp_name;
                       
                   }
                  
                   
                   move_uploaded_file($filetmp, $file_destination);

                   
               }
            // echo  $img_list; die;
//               die('success');

               $resource = $this->_objectManager->create('\Magento\Framework\App\ResourceConnection');
               $connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);


               setlocale(LC_ALL, "en_US.UTF8");
               $url_string=preg_replace("/[^a-z0-9]/i"," ", ltrim(rtrim(strtolower($post['trails_name']))));
               $url_string = preg_replace("/\s+/", " ", $url_string);
               $newurl_string=str_replace(" ","-",$url_string);
               $values = $connection->fetchAll('SELECT `trails_slug` FROM `scaledesk_trails` WHERE trails_slug ="'.$newurl_string.'"');
               if(!empty($values[0]['trails_slug'])){
                   $this->messageManager->addError(__('Trail name already exists! please type another trail name.'));

               }else {



               $model = $this->_objectManager->create('Nitesh\Singh\Model\Post');
               $model->setData('singh_name', $post['singh_name']);
               $model->setData('singh_start_date', $post['singh_start_date']);
               $model->setData('singh_end_date', $post['singh_end_date']);
               $model->setData('singh_trip_duration', $post['singh_trip_duration']);
               $model->setData('singh_start_point', $post['singh_start_point']);
               $model->setData('singh_end_point', $post['singh_end_point']);
               $model->setData('singh_vehicle_name', $post['singh_vehicle_name']);
               $model->setData('singh_describing', $post['singh_describing']);
               $model->setData('singh_url', $img_list);
               $model->setData('entity_id', $customerSession->getCustomer()->getId());
               $model->setData('singh_slug', $newurl_string);

               $id =$model->save() ;
               $connection->query('INSERT INTO `url_rewrite`( `entity_type`, `request_path`,`entity_id`,`target_path`,`store_id`) VALUES ("custom","trail/'.$newurl_string. '","0","trails/post/view/id/'.$id->getId().'","1")');





               $this->messageManager->addSuccess(__('Trails has beem saved successfully.'));

               $this->_redirect('singh/post/register');

               return;
               }
               }
               catch (\Exception $e) {

                $this->messageManager->addError(__('Something went wrong while saving trails.'.$e));
                }
               $this->_redirect('singh/post/register');

//           print_r($model);
//           print_r($post); die;
       }
       else {
           $this->_coreRegistry->register(self::REGISTRY_KEY_POST_ID, (int)$this->_request->getParam('id'));
           $resultPage = $this->_resultPageFactory->create();
           return $resultPage;
       }
    }
    
     else{


           $this->_redirect('/');


       }
    
}
}