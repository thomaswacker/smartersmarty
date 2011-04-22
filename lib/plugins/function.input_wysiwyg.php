<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        function.input_selectone.php
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
 * @subpackage PluginsFunction
 * @version 0.1
 */

/**
 * Smarty plugin WYSIWYG input field
 * @param array $params
 * @param SmarterSmarty $template
 * @return string
 */
function smarty_function_input_wysiwyg($params, $template)
{
    $obj = new WysiwygControl($params['name'], $params['value'], $params);
    return $obj->paint();
}