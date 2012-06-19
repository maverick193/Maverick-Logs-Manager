<?php
/**
 * Maverick Logs Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to m.nahhas@live.fr so we can send you a copy immediately.
 *
 * You free to edit or add to this file your own code
 * github : https://github.com/maverick193/Maverick-Logs-Manager.git
 *
 * @version     0.1.0
 * @category    Maverick
 * @package     Maverick_Logs
 * @copyright   Copyright (c) 2012 Maverick-dev Inc. (http://maverick-dev.fr)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Notification Block
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Block_Adminhtml_Notification extends Mage_Adminhtml_Block_Notification_Toolbar
{
    /**
     * Is available flag
     *
     * @var bool
     */
    protected $_show_window = null;
    
    /**
     * Severity type
     * 
     * @var int
     */
    protected $_severity    = Mage_AdminNotification_Model_Inbox::SEVERITY_MAJOR;
    
    /**
     * XML path of Severity icons url
     */
    const XML_SEVERITY_ICONS_URL_PATH  = 'system/adminnotification/severity_icons_url';
    
    /**
     * Initialize block window
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('maverick/logs/notification/window.phtml');
        $this->setHeaderText($this->escapeHtml($this->__('New Logs Appeared')));
        $this->setCloseText($this->escapeHtml($this->__('close')));
        $this->setReadDetailsText($this->escapeHtml($this->__('See Logs')));
        $this->setNoticeText($this->escapeHtml($this->__('NOTICE')));
        $this->setMinorText($this->escapeHtml($this->__('MINOR')));
        $this->setMajorText($this->escapeHtml($this->__('MAJOR')));
        $this->setCriticalText($this->escapeHtml($this->__('CRITICAL')));
   
        $this->setNoticeMessageUrl($this->escapeUrl($this->getUrl('adminhtml/mavelogs/index')));
    
        switch ($this->_severity) {
            default:
            case Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE:
                $severity = 'SEVERITY_NOTICE';
                break;
            case Mage_AdminNotification_Model_Inbox::SEVERITY_MINOR:
                $severity = 'SEVERITY_MINOR';
                break;
            case Mage_AdminNotification_Model_Inbox::SEVERITY_MAJOR:
                $severity = 'SEVERITY_MAJOR';
                break;
            case Mage_AdminNotification_Model_Inbox::SEVERITY_CRITICAL:
                $severity = 'SEVERITY_CRITICAL';
                break;
        }
    
        $this->setNoticeSeverity($severity);
        
        $newLogs = $this->checkNewLogs();
        
        if($newLogs === false) {
            $this->setNewLogs(false);
        }else{
            $this->setNewLogs(true);
            $this->setLogList(array_keys($newLogs));
            $this->setNoticeMessageText($this->escapeHtml($this->__('New errors detected in those files:')));
        }    
    }
    
    /**
     * Check if we can show notification window
     *
     * @return bool
     */
    public function canBeShown()
    {
        if (!is_null($this->_show_window)) {
            return $this->_show_window;
        }

        if (!$this->isOutputEnabled('Mage_AdminNotification')) {
            $this->_show_window = false;
            return false;
        }

        if (!$this->_isAllowed()) {
            $this->_show_window = false;
            return false;
        }
        
        if(!$this->windowLogsEnabled()) {
            $this->_show_window = false;
            return false;
        }

        if (is_null($this->_show_window)) {
            $this->_show_window = $this->isShow();
        }
        return $this->_show_window;
    }
    
    /**
     * Check if current block allowed in ACL
     *
     * @param string $resourcePath
     * @return bool
     */
    protected function _isAllowed()
    {
        if (!is_null($this->_aclResourcePath)) {
            return Mage::getSingleton('admin/session')
            ->isAllowed('admin/system/maverick/maverick_logs');
        }
        else {
            return true;
        }
    }
    
    /**
     * Check if displaying window notification is enabled
     * in Maverick Logs system configuration
     */
    public function windowLogsEnabled()
    {
        return ((string)Mage::getStoreConfig('maverick_logs/notification/enable') === '0') ? false : true;
    }
    
    /**
     * Retrieve severity icons url
     *
     * @return string
     */
    public function getSeverityIconsUrl()
    {
        if (is_null($this->_severityIconsUrl)) {
            $this->_severityIconsUrl =
            (Mage::app()->getFrontController()->getRequest()->isSecure() ? 'https://' : 'http://')
            . sprintf(Mage::getStoreConfig(self::XML_SEVERITY_ICONS_URL_PATH), Mage::getVersion(),
                    $this->getNoticeSeverity())
                    ;
        }
        return $this->_severityIconsUrl;
    }
    
    /**
     * Check is show toolbar
     *
     * @return bool
     */
    public function isShow()
    {
        if (!$this->isOutputEnabled('Mage_AdminNotification')) {
            return false;
        }
        
        if (!$this->getNewLogs()) {
            return false;
        }
    
        return true;
    }
    
    /**
     * Retrieve severity text
     *
     * @return string
     */
    public function getSeverityText()
    {
        return strtolower(str_replace('SEVERITY_', '', $this->getNoticeSeverity()));
    }
    
    /**
     * Check if there is some new logs
     *
     * @return bool|array
     */
    public function checkNewLogs()
    {
        if((Mage::getSingleton('admin/session')->isFirstPageAfterLogin()) 
                || (($this->getRequest()->getControllerName() == 'mavelogs') 
                        && ($this->getRequest()->getActionName() == 'check'))) {
            
            $logFiles = Mage::helper('maverick_logs')->getLogFiles(true);
            if(!$logFiles) {
                return false;
            }
            
            $res = $newData = array();
            $lastCheck = unserialize(Mage::getStoreConfig('maverick_logs/notification/lastcheck'));
            
            foreach ($logFiles as $f) {
                $name = explode(DIRECTORY_SEPARATOR, $f);
                $name = substr($name[count($name) - 1], 0, -4);
                
                if(!in_array($name, array_keys($lastCheck))) {
                    $res[$name]     = filesize($f);
                    $newData[$name] = filesize($f);
                }elseif($lastCheck[$name] != filesize($f)){
                    $res[$name] = filesize($f);
                    $newData[$name] = filesize($f);
                }else{
                    $newData[$name] = $lastCheck[$name];
                }
            }
            
            if(empty($res)) {
                return false;
            }else{
                Mage::helper('maverick_logs')->updateLogsData($newData);
                return $res;                
            }
        }
        return false;
    }
}