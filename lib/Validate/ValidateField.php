<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        ValidateField.php
 * SVN:         $Id$
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
 * ValidateField is a low level object validating a single field.
 * The validation methods can be stacked.
 */
class ValidateField
{
    /**
     * @var string
     */
    public $value;
    /**
     * @var array of strings
     */
    public $errorMessages;
    /**
     * @var ValidateSet
     */
    public $parent;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param string $text
     * @return void
     */
    protected function _addErrorMessage($text)
    {
        $this->errorMessages[] = $text;
    }

    /**
     * Concatenate fields to value
     * @param array $args with array 'fields' of field names and optional 'glue' for separator
     * @return ValidateField
     */
    public function concat($args)
    {
        $values = array();
        foreach ($args['fields'] as $fld) {
            $values[] = $this->parent->getValue($fld);
        }

        $glue = isset($args['glue']) ? $args['glue'] : '';

        $this->value = implode($glue, $values);

        return $this;
    }

    public function trim($args)
    {
        $this->value = trim($this->value);

        return $this;
    }

    /**
     * Validate if value equals to specified value or another field (repeation)
     * @param array $args either 'field' as field name or 'value' for compared value
     *                    also 'error' for error message
     * @return ValidateField
     */
    public function equals($args)
    {
        if ((isset($args['field']) && $this->parent->getValue($args['field']) != $this->value)
            || (isset($args['value']) && $args['value'] != $this->value)
        ) {
            $this->_addErrorMessage($args['error']);
        }

        return $this;
    }

    /**
     * Checks if value is not empty
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function mandatory($args)
    {
        if (empty($this->value)) {
            $this->_addErrorMessage($args['error']);
        }

        return $this;
    }

    public function validateDateFormat($args)
    {
        // TODO: validateDateFormat
        return $this;
    }

    public function validateFloat($args)
    {
        if (filter_var($this->value, FILTER_VALIDATE_FLOAT) === false) {
            $this->_addErrorMessage($args['error']);
        }

        return $this;
    }

    public function sanitizeFloat($args)
    {
        $sanitized = filter_var($this->value, FILTER_SANITIZE_NUMBER_FLOAT);

        if ($sanitized === false) {
            $this->_addErrorMessage($args['error']);
        } else {
            $this->value = $sanitized;
        }

        return $this;
    }

    /**
     * Validate integer value
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function validateInt($args)
    {
        if (filter_var($this->value, FILTER_VALIDATE_INT) === false) {
            $this->_addErrorMessage($args['error']);
        }

        return $this;
    }

    /**
     * Sanitize integer
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function sanitizeInt($args)
    {
        $sanitized = filter_var($this->value, FILTER_SANITIZE_NUMBER_INT);

        if ($sanitized === false) {
            $this->_addErrorMessage($args['error']);
        } else {
            $this->value = $sanitized;
        }

        return $this;
    }

    /**
     * Validate string value
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function validateString($args)
    {
        if (filter_var($this->value, FILTER_VALIDATE_STRING) === false) {
            $this->_addErrorMessage($args['error']);
        }

        return $this;
    }

    /**
     * Sanitize string
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function sanitizeString($args)
    {
        $sanitized = filter_var($this->value, FILTER_SANITIZE_STRING);

        if ($sanitized === false) {
            $this->_addErrorMessage($args['error']);
        } else {
            $this->value = $sanitized;
        }

        return $this;
    }

    /**
     * Validate IP value
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function validateIP($args)
    {
        $flags = empty($args['no_private']) ? FILTER_FLAG_NO_PRIV_RANGE : 0;

        if (isset($args['v4'])) {
            $flags |= FILTER_FLAG_IPV4;
        } elseif (isset($args['v6'])) {
            $flags |= FILTER_FLAG_IPV6;
        }

        if (filter_var($this->value, FILTER_VALIDATE_IP, $flags) === false) {
            $this->_addErrorMessage($args['error']);
        }

        return $this;
    }

    /**
     * Validate eMail address
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function validateEmail($args)
    {
        if (filter_var($this->value, FILTER_VALIDATE_EMAIL) === false) {
            $this->_addErrorMessage($args['error']);
        }
        
        return $this;
    }

    /**
     * Sanitize eMail address
     * @param array $args set 'error' for error message
     * @return ValidateField
     */
    public function sanitizeEmail($args)
    {
        $sanitized = filter_var($this->value, FILTER_SANITIZE_EMAIL);
        
        if ($sanitized === false) {
            $this->_addErrorMessage($args['error']);
        } else {
            $this->value = $sanitized;
        }
        
        return $this;
    }

    /**
     * Validate recaptcha input
     * @param array $args set 'privatekey' of recaptcha
     * @return ValidateField
     */
    public function validateRecaptcha($args)
    {
        require_once dirname(__FILE__) . '/../recaptcha/recaptchalib.php';

        $resp = recaptcha_check_answer(
            $args['privatekey'],
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]
        );

        if (!$resp->is_valid) {
            $this->_addErrorMessage($resp->error);
        }
        
        return $this;
    }

    // ...
}
