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
 * Multiselect Directories Field Source Model
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Model_System_Config_Source_Directories
{
    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $varDir = Mage::helper('maverick_logs')->getVarDir();
            $subFolder = array_filter(glob($varDir . DS .'*'), 'is_dir');
            foreach ($subFolder as $folder) {
                $tmp = explode(DS, $folder);
                $this->_options[] = array('label' => end($tmp), 'value' => end($tmp));
            }
        }

        $options = $this->_options;

        return $options;
    }
}