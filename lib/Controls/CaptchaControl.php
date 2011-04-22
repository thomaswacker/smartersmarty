<?php
/**
 * Project:     SmarterSmarty: Smarty addon classes/functions
 * File:        CaptchaControl.php
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

class CaptchaControl implements iTemplateControl
{
    private $_publicKey;

    public function __construct($publicKey)
    {
        $this->_publicKey = $publicKey;
    }

    public function paint()
    {
        require_once dirname(__FILE__) . '/../recaptcha/recaptchalib.php';
        return recaptcha_get_html($this->_publicKey, $error);
    }
}
