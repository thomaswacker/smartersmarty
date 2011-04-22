<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        SmarterSmarty.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @link http://www.smartersmarty.net/
 * @copyright 2011 Thomas Wacker
 * @author Thomas Wacker <zuhause@thomaswacker.de>
 * @package SmarterSmarty
 * @version 0.1
 */

require_once 'Smarty/libs/Smarty.class.php';
require_once 'Validate/ValidationResult.php';
require_once 'Validate/ValidateSet.php';
require_once 'Validate/ValidateField.php';

/**
 * SmarterSmarty is a derived Smarty class containing some special methods and plugins
 * @author Thomas Wacker <zuhause@thomaswacker.de>
 */
class SmarterSmarty extends Smarty
{
    protected static $_controlsDir;

    public function __construct()
    {
        parent::__construct();
        $this->_registerPlugins();
        $this->_registerViewOptions();
        $this->_registerControls();
    }

    public function setValidationResults(ValidateSet $vset)
    {
        $this->assign('vresults', $vset->getValidationResults());
    }

    protected function _registerPlugins()
    {
        $this->addPluginsDir(dirname(__FILE__) . '/plugins');
    }

    protected function _registerViewOptions()
    {
        require_once dirname(__FILE__) . '/ViewOptions.php';
        ViewOptions::init();
    }

    public static function controlsAutoloader($className)
    {
        $n = strpos($className, 'Control');
        if ($n !== false) {
            if (file_exists(self::$_controlsDir . '/' . $className . '.php')) {
                include self::$_controlsDir . '/' . $className . '.php';
            }
        }
    }

    protected function _registerControls()
    {
        self::$_controlsDir = dirname(__FILE__) . '/Controls';
        spl_autoload_register(array(__CLASS__, 'controlsAutoloader'));
    }
}
