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
abstract class DigiBrews_Locator_Model_Search_Point_Abstract 
    extends DigiBrews_Locator_Model_Search_Abstract
{

    /**
     * Find locations near a Lat/Long point
     *
     * @param Point $point
     * @param int $radius
     * @return DigiBrews_Locator_Model_Resource_Location_Collection
     */
    protected function pointToLocations(Point $point, $radius = null)
    {
        if(null==$radius){
            $radius = (int)Mage::getStoreConfig('locator_settings/search/default_search_distance');
        }

        $collection = $this->getSearchCollection()
                            ->addAttributeToSelect('*')
                            ->addExpressionAttributeToSelect('distance', sprintf("(3959 * acos(cos(radians('%s')) * cos(radians(latitude)) * cos(radians(longitude) - radians('%s')) + sin(radians('%s')) * sin( radians(latitude))))", $point->coords[1], $point->coords[0], $point->coords[1], $radius), array('entity_id'));

        if ($radius !== 0) {
            $collection->getSelect()->having('distance < ?', $radius);
        }

        $collection->setOrder('distance');

        return $collection;
    }
}