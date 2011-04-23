<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        WysiwygControl.php
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

class WysiwygControl implements iTemplateControl
{
    public function __construct($name, $value, $options = array())
    {
        $this->_name = $name;
        $this->_value = $value;
        $this->_options = $options;
    }

    public function paint()
    {
        if (isset($this->_options['label'])) {
            $result = ViewOptions::getDefaultInputStart($this->_name, $this->_options);
        } else {
            $result = '';
        }

        $result .= ViewOptions::$autoAppendInput;

        require_once ViewOptions::$wysiwygEditorDir . '/ckeditor.php';
        $editor = new CKEditor;
        $editor->returnOutput = true;

        $config = $events = array();
        $config['width'] = 650;

        $result .= $editor->editor($this->_name, $this->_value, $config, $events);

        $result .= ViewOptions::$autoPrependInput;

        if (isset($params['label'])) {
            $result .= ViewOptions::$autoPrependField;
        }

        return $result;
    }
}