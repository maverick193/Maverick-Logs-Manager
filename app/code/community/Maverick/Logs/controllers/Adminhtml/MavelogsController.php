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
 * Mavelogs Controller
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Adminhtml_MavelogsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Check ACL permissions
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('maverick/maverick_logs/manage_logs');
    }

    /**
     * Index Page
     */
    public function indexAction()
    {
        $this->_title($this->__('Logs'))->_title($this->__('Maverick'));
        $this->loadLayout();
        $this->_setActiveMenu('maverick/maverick_logs');
        $this->renderLayout();
    }

    /**
     * Display the file tree
     */
    public function treeAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Get and Display the content of a file
     */
    public function readAction()
    {
        $path = $this->getRequest()->getPost('path');
        Mage::register('log_path', $path);
         
        $this->loadLayout();
        $this->renderLayout();
    }

    public function refreshAction()
    {
        $this->_getSession()->addSuccess($this->__('File tree was successfully refreshed'));
        $this->_redirect('*/*');
    }

    /**
     * @todo Check if there's new logs and output a popup
     */
    public function checkAction()
    {

    }
}