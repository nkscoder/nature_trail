<?php
/**
 * Created by PhpStorm.
 * User: nitesh
 * Date: 16/4/18
 * Time: 4:17 PM
 */


namespace Nitesh\Singh\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;
use \Nitesh\Singh\Api\Data\PostInterface;

/**
 * Class File
 * @package Nitesh\Post\Model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Post extends AbstractModel implements PostInterface, IdentityInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'nitesh_singh';

    /**
     * Post Initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Nitesh\Singh\Model\ResourceModel\Post');
    }


//    get Function  for all field

    /**
     * Return identities
     * @return string[]
     */


    public function getTrailsName()
    {
        return $this->getData(self::TRAILS_NAME);
    }
    public function getId()
    {
        return $this->getData(self::TRAILS_ID);
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getTrailsStartDate()
    {
        return $this->getData(self::TRAILS_START_DATE);
    }
    public function getTrailsEndDate()
    {
        return $this->getData(self::TRAILS_END_DATE);
    }
    public function getTrailsTripDuration()
    {
        return $this->getData(self::TRAILS_TRIP_DURATION);
    }

    public function getTrailsStartPoint()
    {
        return $this->getData(self::TRAILS_START_POINT);
    }

    public function getTrailsEndPoint()
    {
        return $this->getData(self::TRAILS_END_POINT);
    }

    public function getTrailsVehicleName()
    {
        return $this->getData(self::TRAILS_VEHICLE_NAME);
    }
    public function getTrailsDescribing()
    {
        return $this->getData(self::TRAILS_DESCRIBING);
    }
    public function getTrailsUrl()
    {
        return $this->getData(self::TRAILS_URL);
    }
    public function getTrailsCreateAt()
    {
        return $this->getData(self::CREATED_AT);
    }
    
    
        public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }


    public function getTrailsPopular()
    {
        return $this->getData(self::TRAILS_POPULAR);
    }


    public function getFirstName(){
        return $this->getData(self::FIRST_NAME);
    }
    public function getMiddleName(){
        return $this->getData(self::MIDDLE_NAME);
    }
    public function getLastName(){
        return $this->getData(self::LAST_NAME);
    }
    public function getCoustomerProfileImage(){
        return $this->getData(self::COUSTOMER_PROFILE_IMAGE);
    }


    public function getTrailsFeatured(){
        return $this->getData(self::TRAILS_FEATURED);
    }


    public function getTrailsSlug(){
        return $this->getData(self::TRAILS_SLUG);
    }

    public function getCoustomerDescription(){
        return $this->getData(self::COUSTOMER_DESCRIPTION);
    }




 public function setCoustomerDescription($coustomerdescription){
        return $this->setData(self::COUSTOMER_DESCRIPTION, $coustomerdescription);
    }

    public function setTrailsName($name){
        return $this->setData(self::TRAILS_NAME, $name);
    }
    public function setId($id){
        return $this->setData(self::TRAILS_ID, $id);
    }
    public function setTrailsStartDate($startDate){
        return $this->setData(self::TRAILS_START_DATE, $startDate);
    }
    public function setTrailsEndDate($endDate){
        return $this->setData(self::TRAILS_END_DATE, $endDate);
    }
    public function setTrailsTripDuration($tripDuration){
        return $this->setData(self::TRAILS_TRIP_DURATION, $tripDuration);
    }
    public function setTrailsStartPoint($startPoint){
        return $this->setData(self::TRAILS_START_POINT, $startPoint);
    }
    public function setTrailsEndPoint($endPoint){
        return $this->setData(self::TRAILS_END_POINT, $endPoint);
    }
    public function setTrailsVehicleName($vehicleName){
        return $this->setData(self::TRAILS_VEHICLE_NAME, $vehicleName);
    }
    public function setTrailsDescribing($describing){
        return $this->setData(self::TRAILS_DESCRIBING, $describing);
    }
    public function setTrailsUrl($url){
        return $this->setData(self::TRAILS_URL, $url);
    }
    public function setTrailsCreateAt($createAt){
        return $this->setData(self::CREATED_AT, $createAt);
    }
    
    public function setEntityId($entityId)
    {

        return $this->setData(self::ENTITY_ID, $entityId);

    }

    public function setTrailsPopular($popular)
    {
        return $this->setData(self::TRAILS_POPULAR, $popular);
    }

    public function setFirstName($firstName){
        return $this->setData(self::FIRST_NAME, $firstName);

    }
    public function setMiddleName($middleName){
        return $this->setData(self::MIDDLE_NAME, $middleName);

    }
    public function setLastName($lastName){
        return $this->setData(self::LAST_NAME, $lastName);

    }
    public function setCoustomerProfileImage($coustomerProfileImage){
        return $this->setData(self::COUSTOMER_PROFILE_IMAGE, $coustomerProfileImage);

    }

    public function setTrailsFeatured($featured){
        return $this->setData(self::TRAILS_FEATURED, $featured);
    }

    public function setTrailsSlug($slug){
        return $this->setData(self::TRAILS_SLUG, $slug);
    }

}