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
 * Configuration Controller
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Adminhtml_ConflogsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Check ACL permissions
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/maverick_logs');
    }

    /**
     * Redirect user via 302 http redirect to Module Configuration page/section
     */
    public function configAction()
    {
        $this->_redirect('adminhtml/system_config/edit', array('section' => 'maverick_logs'));
    }
}