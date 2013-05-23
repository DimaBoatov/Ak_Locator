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

/**
 * @category   MageBrews
 * @package    MageBrews_Locator
 * @author     Andrew Kett
 */
abstract class MageBrews_Locator_Model_Search_Abstract extends Mage_Core_Model_Abstract
{

    protected $_collection;
    protected $_model;
    protected $_cache;

    protected abstract function search(Array $params);

    /**
     *
     * @return mixed
     */
    protected function getCache()
    {
        if(!$this->_cache){
            $this->_cache = Mage::getSingleton('core/cache');
        }

        return $this->_cache;

    }

    /**
     * Get the location collection used to search
     *
     * @return MageBrews_Locator_Model_Resource_Location_Collection
     * @deprecated use getCollection
     */
    protected function getSearchCollection()
    {
        return $this->getCollection();
    }


    /**
     * Get the collection class that will be used to find locations
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getCollection()
    {
        if(!$this->_collection){
             $this->setCollection($this->getModel()->getCollection()->addAttributeToFilter('is_enabled','1'));
        }

        return $this->_collection;
    }

    /**
     *
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getModel()
    {
        if(!$this->_model){
            $this->setModel($this->getModel()->getCollection());
        }

        return $this->_model;
    }

    /**
     * Set the collection class that will be used to find locations
     *
     * @param Mage_Eav_Model_Entity_Collection_Abstract $collection
     * @return $this
     */
    public function setCollection(Mage_Eav_Model_Entity_Collection_Abstract $collection)
    {
        $this->_collection = $collection;

        return $this;
    }

    /**
     *
     * @param Mage_Core_Model_Abstract $model
     * @return $this
     */
    public function setModel(Mage_Core_Model_Abstract $model)
    {
        $this->_model = $model;

        return $this;
    }

}
