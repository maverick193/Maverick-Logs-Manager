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
 * Maverick Logs base Helper
 *
 * @category   Maverick
 * @package    Maverick_Logs
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Maverick_Logs_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Base dir Type
     * Change its value to 'log' to get the content of "log/" folder
     * Mage::getBaseDir($this->base_dir_type);
     * @var string
     */
    public $base_dir_type = 'var';

    /**
     * Retrive log file list
     *
     * @return array
     */
    public function getLogFiles($merge=false)
    {
        $logDir = Mage::getBaseDir('log');
        $logFiles = glob($logDir . DS . '*.log');

        if (!$logFiles) {
            return false;
        }

        $collectLogFiles = array(
                'system'   => array(),
                'custom' => array()
        );

        foreach ($logFiles as $f) {
            $name = explode(DIRECTORY_SEPARATOR, $f);
            $name = substr($name[count($name) - 1], 0, -4);

            if (($name == 'exception') || ($name == 'system')) {
                $collectLogFiles['system'][] = $f;
            } else {
                $collectLogFiles['custom'][] = $f;
            }
        }

        if($merge === true) {
            return array_merge(
            $collectLogFiles['system'],
            $collectLogFiles['custom']
            );
        }
        return $collectLogFiles;
    }

    /**
     * Update logs data in configuration
     * @param array $res
     */
    public function updateLogsData($data)
    {
        $serializeData = serialize($data);
        $coreConfigDataObj = new Mage_Core_Model_Config();
        $coreConfigDataObj->saveConfig('maverick_logs/notification/lastcheck', $serializeData, 'default', 0);
        Mage::getConfig()->reinit();
        Mage::app()->reinitStores();
    }
    
    /**
     * Return the folder path to display
     * @return string
     */
    public function getVarDir()
    {
        return Mage::getBaseDir(Mage::helper('maverick_logs')->base_dir_type);
    }
}