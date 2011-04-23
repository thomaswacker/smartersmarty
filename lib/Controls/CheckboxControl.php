<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        CheckboxControl.php
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

class CheckboxControl implements iTemplateControl
{
    private $_name;
    private $_value;
    private $_options;

    public function __construct($name, $value, $options = array())
    {
        $this->_name = $name;
        $this->_value = $value;
        $this->_options = $options;
    }

    public function paint()
    {
        $result = ViewOptions::getDefaultInputStart($this->_name, $this->_options);

        // start tag with css class
        $result .=  '<input type="checkbox" class="' . ViewOptions::$checkboxClass;
        if (isset($this->_options['class'])) {
            $result .= ' ' . $this->_options['class'];
        }

        // Use project wide equal checkbox value (e.g. "1"), the parameter "value" means
        // if it's checked or not
        $result .= '" value="' . ViewOptions::$checkboxValue . '"';
        if ($this->_value == ViewOptions::$checkboxValue) {
            if (ViewOptions::$xhtml) {
                $result .= ' checked="checked"';
            } else {
                $result .= ' checked';
            }
        }

        // add additional attributes to input field
        foreach ($this->_options as $key => $val) {
            if ($key != 'class' && $key != 'label' && $key != 'value') {
                $result .= ' ' . $key . '="' . htmlentities($val, ENT_QUOTES, 'UTF-8') . '"';
            }
        }

        // end tag with default decorations
        if (ViewOptions::$xhtml) $result .= '/';
        $result .= '>';

        $result .= ViewOptions::getDefaultInputEnd($this->_options);

        return $result;
    }
}
