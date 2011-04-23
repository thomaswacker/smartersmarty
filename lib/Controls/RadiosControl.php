<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        RadiosControl.php
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

class RadiosControl implements iTemplateControl
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

        $value = isset($this->_options['value']) ? $this->_options['value'] : 0;

        if (isset($this->_options['options']) && is_array($this->_options['options'])) {
            foreach ($this->_options['options'] as $val => $text) {
                $result .= '<input type="radio" name="' . $this->_name . '" value="'
                         . htmlentities($val, ENT_QUOTES, 'UTF-8') .'"'
                         . ' class="' . ViewOptions::$radiosClass;

                if (isset($this->_options['class'])) {
                    $result .= ' ' . $this->_options['class'];
                }
                $result .= '"';

                if ($value == $val) {
                    if (ViewOptions::$xhtml) {
                        $result .= ' checked="checked"';
                    } else {
                        $result .= ' checked';
                    }
                }
                $result .= '>' . htmlentities($text, ENT_QUOTES, 'UTF-8') . '</option>';
            }
        }

        $result .= ViewOptions::getDefaultInputEnd($this->_options);
        
        return $result;
    }
}
