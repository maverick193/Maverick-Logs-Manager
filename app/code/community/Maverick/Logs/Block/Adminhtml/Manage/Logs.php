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
 * Manage Logs Block
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Block_Adminhtml_Manage_Logs extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize Form Container
     * @see Mage_Adminhtml_Block_Widget_Form_Container::__construct()
     */
    public function __construct() {
        $this->_objectId   = 'manage_log_files';
        $this->_blockGroup = 'maverick_logs';
        $this->_controller = 'adminhtml_manage';
        $this->_mode       = 'logs';
        
        parent::__construct ();
        
        $this->_removeButton('back');
        $this->_removeButton('save');
        $this->_removeButton('reset');

        $this->_addButton('refrech', array(
                                'label'   => Mage::helper('maverick_logs')->__('Refresh'),
                                'onclick' => "setLocation('{$this->getUrl('*/*/refresh')}')",
                                'class'   => 'save'
                                        ));
        /*$this->_addButton('check', array(
                'label'   => Mage::helper('maverick_logs')->__('Check New Logs'),*/
               // 'onclick' => "setLocation('{$this->getUrl('*/*/check')}')",
               /* 'class'   => 'save'
                        ));*/
          
    }
    
    /**
     * Retrieve text for header element
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('maverick_logs')->__('Manage Logs');
    }
}