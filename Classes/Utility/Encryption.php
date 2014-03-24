<?php
namespace Aijko\SharepointConnector\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 AIJKO GmbH <info@aijko.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Secuity
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class Encryption {

	const METHOD = 'aes128';

	/**
	 * @param string $value
	 * @return string
	 */
	public static function encrypt($value) {
		return openssl_encrypt($value, self::METHOD, $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public static function decrypt($value) {
		return openssl_decrypt($value, self::METHOD, $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
	}

}