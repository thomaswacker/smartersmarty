<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        ValidateSet.php
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
 * @subpackage Validation
 * @version 0.1
 */

/**
 * ValidateSet is the user class for validation rules.
 * Usage: construct, setField, validate and getValidationResults.
 *
 * Example:
 * <pre>
 *  $vset = new ValidateSet;
 *
 *  $vset->setField('email')
 *       ->mandatory(array('error' => 'eMail address not set'))
 *       ->validateEmail(array('error' => 'Wrong eMail syntax'));
 *
 *  $vset->setField('emailrep')
 *       ->mandatory(array('error' => 'eMail repeation not set'))
 *       ->equals(array('field' => 'email', 'error' => 'eMail repeation not equal with eMail address'));
 *
 *  $vset->setField('geburtsdatum')
 *       ->concat(array('fields' => array('jj', 'mm', 'tt'), 'glue' => '-', 'error' => 'eMail repeation not set'))
 *       ->validateDate(array('error' => 'Not correct date'));
 *
 *  $view->assign('vresults', $vset->getValidationResults());
 * </pre>
 *
 * @author Thomas Wacker <zuhause@thomaswacker.de>
 */
class ValidateSet
{
    /**
     * @var array of ValidateField - key = name
     */
    protected $_objects;
    protected $_method = 'POST';
    /**
     * @var ValidationResult
     */
    protected $_result;

    public function __construct()
    {
        $this->_result = new ValidationResult;
    }

    /**
     * Set method
     * @param string $method POST or GET
     * @return void
     */
    public function setMethod($method)
    {
        $this->_method = $method;
    }

    /**
     * @param string $name
     * @return ValidateField
     */
    public function setField($name)
    {
        if (!isset($this->_objects[$name])) {
            $this->_objects[$name] = $this->newValidateField($this->_getOriginValue($name));
        }

        return $this->_objects[$name];
    }

    public function newValidateField($value)
    {
        return new ValidateField($value);
    }

    /**
     * @return ValidationResult
     */
    public function getValidationResults()
    {
        foreach ($this->_objects as $fieldname => $obj) {
            /**
             * @var ValidateField $obj
             */
            $this->_result->values[$fieldname] = $obj->value;

            if (count($obj->errorMessages)) {
                foreach ($obj->errorMessages as $msg) {
                    $this->_result->messages[] = $msg;
                }
                $this->_result->status = false;
            }
        }

        return $this->_result;
    }

    /**
     * Get value from existing field
     * @param string $name
     * @return string
     */
    public function getValue($name)
    {
        if (isset($this->_objects[$name])) {
            /** @noinspection PhpUndefinedFieldInspection */
            return $this->_objects[$name]->value;
        } else {
            $obj = $this->setField($name);
            return $obj->value;
        }
    }

    /**
     * Get value from origin source ($_POST/$_GET)
     * @param string $name
     * @return string
     */
    protected function _getOriginValue($name)
    {
        if ($this->_method == 'POST') {
            $result = isset($_POST[$name]) ? $_POST[$name] : '';
        } else {
            $result = isset($_GET[$name]) ? $_GET[$name] : '';
        }

        return $result;
    }
}
