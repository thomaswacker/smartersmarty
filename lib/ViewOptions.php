<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        ViewOptions.php
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
 * @version 0.1x
 */

class ViewOptions
{
    public static $selectOneClass = 'iselectone';
    public static $textClass = 'itext';
    public static $passwordClass = 'itext';
    public static $textAreaClass = 'itextarea';
    public static $radioClass = 'iradio';
    public static $radiosClass = 'iradios';
    public static $checkboxClass = 'icheckbox';
    public static $checkboxValue = 1;
    public static $autoAppendInput = '<div class="inputfield">';
    public static $autoPrependInput = '</div>';
    public static $autoAppendField = '';
    public static $autoPrependField = '';
    public static $wysiwygEditorDir;
    public static $captchaPublicKey = '';
    public static $captchaPrivateKey = '';
    public static $xhtml = false;

    static public function init()
    {
        self::$wysiwygEditorDir = dirname(__FILE__) . '/ckeditor';
    }

    static public function getDefaultInputStart($name, $options)
    {
        $result = '';

        if (isset($options['label'])) {
            $result = self::$autoAppendField . '<label';
            if (isset($options['id'])) {
                $result .= ' for="' . $options['id'] . '"';
            } else {
                $result .= ' for="' . $name . '"';
            }

            $result .= '>' . htmlentities($options['label'], ENT_QUOTES, 'UTF-8') . '</label>';
        }

        $result .= ViewOptions::$autoAppendInput;

        return $result;
    }

    static public function getDefaultInputEnd($options)
    {
        $result = '';
        
        if (isset($options['label'])) {
            $result = self::$autoPrependField;
        }

        $result .= ViewOptions::$autoPrependInput;

        return $result;
    }
}
