<?php
/**
 * Prattski - Simple Developer Toolbar
 *
 * @category    Prattski
 * @package     Prattski_SimpleDevToolbar
 * @copyright   Copyright (c) 2012 Prattski (http://prattski.com)
 * @author      Josh Pratt (josh@prattski.com)
 */

/**
 * Event Observer
 *
 * @category    Prattski
 * @package     Prattski_SimpleDevToolbar
 */
class Prattski_SimpleDevToolbar_Model_Observer
{
    /**
     * Inject html code for Lyons Developer Toolbar into the page, both on the
     * frontend and the admin.
     * 
     * @param Varien_Event_Observer $observer 
     */
    public function addDevToolbar(Varien_Event_Observer $observer)
    {
        // Get the block object from the observer
        $block = $observer->getBlock();
        
        // Look for the block types to insert into the top of the page
        if ($block->getType() == 'page/html_notices' || $block->getType() == 'adminhtml/page_notices') {
            
            // Get the html of the found block type from the transport
            $html = $observer->getTransport()->getHtml();
            
            // Insert our toolbar html
            $html = $this->_getToolbarHtml() . $html;
            
            // Send back to transport to be populated on the page
            $observer->getTransport()->setHtml($html);
        }
    }
    
    protected function _getToolbarHtml()
    {
        $html = '<div style="width: 100%; padding: 5px; border: 1px solid #333; background-color: #ccc; text-align: center">';
        
        /**
         * Enable/Disable Logging 
         */
        if (Mage::getStoreConfig('dev/log/active')) {
            $html .= '<strong>Logging:</strong> Enabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/logging/enabled/0').'">Disable</a>)';
        } else {
            $html .= '<strong>Logging:</strong> Disabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/logging/enabled/1').'">Enable</a>)';
        }
        
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        
        /**
         * Enable/Disable Template Path Hints 
         */
        if (Mage::getStoreConfig('dev/debug/template_hints')) {
            $html .= '<strong>Template Path Hints:</strong> Enabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/hints/enabled/0').'">Disable</a>)';
        } else {
            $html .= '<strong>Template Path Hints:</strong> Disabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/hints/enabled/1').'">Enable</a>)';
        }
        
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        
        /**
         * Enable/Disable Profiler
         */
        if (Mage::getStoreConfig('dev/debug/profiler')) {
            $html .= '<strong>Profiler:</strong> Enabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/profiler/enabled/0').'">Disable</a>)';
        } else {
            $html .= '<strong>Profiler:</strong> Disabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/profiler/enabled/1').'">Enable</a>)';
        }
        
        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        
        /**
         * Enable/Disable Cache
         */
        if ($this->_isCacheEnabled()) {
            $html .= '<strong>Cache:</strong> Enabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/cache/enabled/0').'">Disable</a>';
            $html .= '&nbsp;&nbsp;|&nbsp;&nbsp;';
            $html .= '<a href="'.Mage::getUrl('simpledevtoolbar/action/flushcache').'">Flush</a>)';
        } else {
            $html .= '<strong>Cache:</strong> Disabled (<a href="'.Mage::getUrl('simpledevtoolbar/action/cache/enabled/1').'">Enable</a>)';
        }
        
        /**
         * If there are unread admin notifications, display link to mark all
         * as read 
         */
        if ($this->_hasUnreadNotifications()) {
            $html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            $html .= '<a href="'.Mage::getUrl('simpledevtoolbar/action/readnotifications').'">Mark All Admin Notifications as Read</a>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Check to see if there are any cache types marked as enabled.  If one or
     * more are, this will return true.
     * 
     * @return boolean 
     */
    protected function _isCacheEnabled()
    {
        $cacheInstance = Mage::app()->getCacheInstance();
     	$cacheTypes = Mage::getModel('core/cache')->getTypes();
        $count = 0;
        
        // Loop through each cache type and get status
     	foreach ($cacheTypes as $cache) {
            $cacheInstance = $cache->getData();
            if($cacheInstance['status'] == 1) {
                $count++;
            }
     	}
        
        // If one or more are enabled
        if ($count > 0) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Check to see if there are any unread admin notifications.  If there are,
     * this will return true
     * 
     * @return boolean 
     */
    protected function _hasUnreadNotifications()
    {
        // Get unread and unremoved notifications
        $collection = Mage::getModel('adminnotification/inbox')
            ->getCollection()
            ->addFieldToFilter('is_read', 0)
            ->addFieldToFilter('is_remove', 0);
        
        // If more than 1, return true
        if (count($collection) > 0) {
            return true;
        }
        
        return false;
    }
}