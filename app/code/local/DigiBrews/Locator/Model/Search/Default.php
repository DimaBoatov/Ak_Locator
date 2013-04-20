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
 * @category   DigiBrews
 * @package    DigiBrews_Locator
 * @author     Andrew Kett
 */
class DigiBrews_Locator_Model_Search_Default
    extends DigiBrews_Locator_Model_Search_Abstract
{
    /**
     * Perform a search based on the default search settings in the database
     *
     * @param Array $search
     * @return DigiBrews_Locator_Model_Resource_Location_Collection
     */
    public function search(Array $params = null)
    {
        $params['s'] = Mage::getStoreConfig('locator_settings/search/default_search_string');
        return Mage::getModel('digibrews_locator/search_point_string')->search($params);

        //@todo rework this so that the database config can define what type of search is performed for default search
        /* 
        switch ($defaulSearchType) {
            case 'string':
                $params['s'] = Mage::getStoreConfig('locator_settings/search/default_search_string');
                $search = Mage::getModel('digibrews_locator/search_point_string');
                break;

            case 'latlong':
                $search['lat'] = Mage::getStoreConfig('locator_settings/search/...');
                $search['long'] = Mage::getStoreConfig('locator_settings/search/...');
                $search = Mage::getModel('digibrews_locator/search_point_latlong');         
            etc.....
            break;
        }
        return $search->search($params);
        */
    }
}
