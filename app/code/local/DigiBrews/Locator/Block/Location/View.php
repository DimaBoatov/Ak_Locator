<?php
/**
 * Location extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @copyright   Copyright (c) 2013 Andrew Kett. (http://www.andrewkett.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class DigiBrews_Locator_Block_Location_View extends Mage_Core_Block_Template
{

    public function __construct(){
        parent::__construct();
        $this->setTemplate('locator/location/view.phtml');
    }

    protected function _prepareLayout()
    {
        $locations = $this->getLocations()->getItems();
        $location = reset($locations);
        $layout = $this->getLayout();

        if ($headBlock = $layout->getBlock('head')) {

          $headBlock->setTitle($location->getTitle());
          // $headBlock->setDescription('Locations near ');
          // $headBlock->setKeywords('');

        }

        $initLocator = $layout->createBlock('core/template');
        $initLocator->setTemplate('locator/page/html/head/init-locator.phtml');

        $initSearch = $layout->createBlock('core/template');
        $initSearch->setTemplate('locator/page/html/head/init-store.phtml')->setData('locations', $this->getLocations());

        $headBlock->append($initLocator);
        $headBlock->append($initSearch);

        $listBlock = $this->getLayout()->createBlock('digibrews_locator/location_info')->setData('locations', $this->getLocations());
        $mapBlock = $this->getLayout()->createBlock('digibrews_locator/location_map')->setData('locations', $this->getLocations());


        $nearbyBlock = $this->getLayout()->createBlock('digibrews_locator/search_list_point')->setData('locations', $this->getNearbyLocations())->setTemplate('locator/location/others.phtml');


        $this->setChild('others', $nearbyBlock);
        $this->setChild('info', $listBlock);
        $this->setChild('map', $mapBlock);

        return parent::_prepareLayout();
    }


    /**
     * Retrieve current location model
     *
     * @return DigiBrews_Locator_Model_Location
     */
    public function getLocations()
    {
        if (!Mage::registry('locator_locations')) {

          $id = $this->getRequest()->getParam('id');

          $locations = Mage::getModel('digibrews_locator/location')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id',$id)
            ->load();

            Mage::register('locator_locations', $locations);
        }
        return Mage::registry('locator_locations');
    }


    public function getLocation()
    {
      $locations = $this->getLocations()->getItems();
      return reset($locations);
    }

    public function getNearbyLocations()
    {
        $location = $this->getLocation();
        
        $results = Mage::getModel('digibrews_locator/search_point_latlong')->search(array('lat'=>$location->getLatitude(), 'long'=>$location->getLongitude()));
        $results->addAttributeToFilter('entity_id', array('neq'=>$location->getId()));

        return $results;
    }


    public function asJson()
    {
        $obj = new Varien_Object();
        $obj->setLocations($this->getLocations()->toJson());
        $obj->setOutput($this->getLayout()->createBlock('digibrews_locator/search_list')->setData('locations', $this->getLocations())->toHtml());
        return $obj->toJson();
    }
}
