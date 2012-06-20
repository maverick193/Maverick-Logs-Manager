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
 * Tree Block
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Block_Adminhtml_Manage_Logs_Tree extends Mage_Adminhtml_Block_Widget_Form
{
	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('maverick/logs/form/tree.phtml');
    }

    /**
     * Get the list of files located in $path
     * @param string $path
     * @return array
     */
    public function getTree($path)
    {
        $tree 		= array();       
        if(file_exists($path)) {
            $files = scandir($path);
            natcasesort($files);
            //To avoid the count of . and ..
            if(count($files) > 2) {
                if($path === (Mage::helper('maverick_logs')->getVarDir() . DS)) {
                    $allowedDirs = explode(',', Mage::getStoreConfig('maverick_logs/logs/display_files'));
                    foreach ($files as $file) {
                        if(in_array($file, $allowedDirs)) {
                            $tree[] = $file;
                        }
                    }
                }else{
                    $tree = $files;
                }
            }
        }
        return $tree;
    }
}