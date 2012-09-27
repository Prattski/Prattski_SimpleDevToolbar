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
 * Actions Controller
 *
 * @category    Prattski
 * @package     Prattski_SimpleDevToolbar
 */
class Prattski_SimpleDevToolbar_ActionController extends Mage_Core_Controller_Front_Action
{
    /**
     * Enable/Disable Template Path Hints (frontend-only) 
     */
    public function hintsAction()
    {
        $enabled = $this->getRequest()->getParam('enabled');
        $scope_id = Mage::app()->getStore()->getStoreId();
        Mage::getConfig()->saveConfig('dev/debug/template_hints', $enabled, 'stores', $scope_id);
        Mage::getConfig()->saveConfig('dev/debug/template_hints_blocks', $enabled, 'stores', $scope_id);
        Mage::app()->cleanCache();

        $this->_redirectReferer();
    }
    
    /**
     * Enable/Disable the Profiler 
     */
    public function profilerAction()
    {
        $enabled = $this->getRequest()->getParam('enabled');
        Mage::getConfig()->saveConfig('dev/debug/profiler', $enabled);
        Mage::app()->cleanCache();

        $this->_redirectReferer();
    }
    
    /**
     * Enable/Disable All Cache Types 
     */
    public function cacheAction()
    {
        $enabled = $this->getRequest()->getParam('enabled');
        Mage::app()->cleanCache();
        $cacheTypes = array_keys(Mage::helper('core')->getCacheTypes());
        $enable = array();
        foreach ($cacheTypes as $type) {
            $enable[$type] = $enabled;
        }

        Mage::app()->saveUseCache($enable);
            
        $this->_redirectReferer();
    }
    
    /**
     * Flush Cache 
     */
    public function flushcacheAction()
    {
        Mage::app()->cleanCache();
        
        $this->_redirectReferer();
    }
    
    /**
     * Enable/Disable Logging 
     */
    public function loggingAction()
    {
        $enabled = $this->getRequest()->getParam('enabled');
        Mage::getConfig()->saveConfig('dev/log/active', $enabled);
        
        $this->_redirectReferer();
    }
    
    /**
     * Mark All Unread Admin Notifications As Read 
     */
    public function readnotificationsAction()
    {
        $collection = Mage::getModel('adminnotification/inbox')
            ->getCollection()
            ->addFieldToFilter('is_read', 0)
            ->addFieldToFilter('is_remove', 0);
        
        foreach ($collection as $notification) {
            $model = Mage::getModel('adminnotification/inbox')
                ->load($notification['notification_id']);
            if ($model->getId()) {
                $model->setIsRead(1)
                    ->save();
            }
        }
        
        $this->_redirectReferer();
    }
}