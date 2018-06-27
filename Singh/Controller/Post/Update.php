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


class Update extends Action
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

//        if (isset($customerData['entity_id'])) {

            if($this->getRequest()->getPostValue()){
                try {


                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
                    $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                    $connection = $resource->getConnection();
                    $tableName = $resource->getTableName('scaledesk_trails');


                    $post = $this->getRequest()->getPostValue();
                    $bgImage = $this->getRequest()->getFiles('trails_url');
                    $error=array();
                    $extension=array("jpeg","jpg","png","gif");
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                    $directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');

                    $rootPath  =  $directory->getRoot();

//               define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']."/");

                    define("UPLOADS", $rootPath."/pub/media/trails/");
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
                   
                     $resource = $this->_objectManager->create('\Magento\Framework\App\ResourceConnection');
               $connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);


               setlocale(LC_ALL, "en_US.UTF8");
               $url_string=preg_replace("/[^a-z0-9]/i"," ", ltrim(rtrim(strtolower($post['trails_name']))));
               $url_string = preg_replace("/\s+/", " ", $url_string);
               $newurl_string=str_replace(" ","-",$url_string);
               $values = $connection->fetchAll('SELECT `trails_slug` FROM `scaledesk_trails` WHERE trails_slug ="'.$newurl_string.'"');
               if(!empty($values[0]['trails_slug'])){
                  $newurl_string=$newurl_string.'_';

               }else {

                   

                    $sql ="UPDATE `" . $tableName . "` SET
                        `trails_name` = '".$post['trails_name']."',
                        `trails_start_date` = '".$post['trails_start_date']."',
                        `trails_end_date` = '".$post['trails_end_date']."',
                        `trails_trip_duration` = '".$post['trails_trip_duration']."',
                        `trails_start_point` = '".$post['trails_start_point']."',
                        `trails_end_point` = '".$post['trails_end_point']."',
                        `trails_vehicle_name` = '".$post['trails_vehicle_name']."',
                         `trails_describing` = '".$post['trails_describing']."',
                         `trails_url` = '".$img_list."',
                         `trails_slug`= '".$newurl_string."'
                          WHERE `trails_id` = ".$this->getRequest()->getParam('id');

                    $connection->query($sql);
                    
                    
                    // $connection->query('INSERT INTO `url_rewrite`( `entity_type`, `request_path`,`entity_id`,`target_path`,`store_id`) VALUES ("custom","trail/'.$newurl_string. '","0","trails/post/view/id/'.$id->getId().'","1")');


                     $id = $this->getRequest()->getParam('id');

                if(!empty($values)) {
                    if ($values[0]['events_slug']) {
                        $connection->query('UPDATE `url_rewrite` SET `request_path`="trail/' . $newurl_string . '" WHERE `target_path`="trails/post/view/id/' . $id. '"');
                    }


                }else{

                    $slug = $connection->fetchAll('SELECT `request_path` FROM `url_rewrite` WHERE target_path ="'."trails/post/view/id/".$id.'"');
                    if($slug){
                        $connection->query('UPDATE `url_rewrite` SET `request_path`="trail/' . $newurl_string . '" WHERE `target_path`="trails/post/view/id/' . $id. '"');

                    }else{
                        $connection->query('INSERT INTO `url_rewrite`( `entity_type`, `request_path`,`entity_id`,`target_path`,`store_id`) VALUES ("custom","trail/'.$newurl_string. '","0","trails/post/view/id/'.$id.'","1")');

                    }

                    }



                    $this->messageManager->addSuccess(__('Trails has been updated successfully.'));

                    $this->_redirect('trails/post/users');

                    return;
                }
                    
                }
                catch (\Exception $e) {

                    $this->messageManager->addError(__('Something went wrong while updating trails.'.$e));
                }
                $this->_redirect('trails/post/users');

//           print_r($model);
//           print_r($post); die;
            }
            else {


                $this->_coreRegistry->register(self::REGISTRY_KEY_POST_ID, (int)$this->_request->getParam('id'));
                $resultPage = $this->_resultPageFactory->create();
                return $resultPage;
            }
//        }
//
//        else{
//
//
//            $this->_redirect('/');
//
//
//        }

    }
}