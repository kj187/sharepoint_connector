<?php
namespace Aijko\SharepointConnector\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 AIJKO GmbH <info@aijko.de
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
 * Logger
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class Logger {

	/**
	 * Set Configuration
	 *
	 * @return void
	 * @static
	 */
	static protected function initializeConfiguration() {
		$GLOBALS['TYPO3_CONF_VARS']['LOG']['Aijko']['SharepointConnector']['Utility']['Logger'] = array(
			'writerConfiguration' => array(
				\TYPO3\CMS\Core\Log\LogLevel::ERROR => array(
					'\\TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
						'logFile' => 'typo3temp/logs/sharepoint_connector/error.log',
					),
				),
				\TYPO3\CMS\Core\Log\LogLevel::INFO => array(
					'\\TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
						'logFile' => 'typo3temp/logs/sharepoint_connector/info.log',
					),
				)
			)
		);
	}

	/**
	 * @return \TYPO3\CMS\Core\Log\Logger
	 */
	static protected function getLogger() {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
	}

	/**
	 * @param $methodName
	 * @param $arguments
	 *
	 * @return \TYPO3\CMS\Core\Log\Logger
	 */
	public static function __callStatic($methodName, $arguments) {
		self::initializeConfiguration();
		switch ($methodName) {
			case 'emergency':
				return self::getLogger()->emergency($arguments[0], $arguments[1]);
			case 'alert':
				return self::getLogger()->alert($arguments[0], $arguments[1]);
			case 'critical':
				return self::getLogger()->critical($arguments[0], $arguments[1]);
			case 'error':
				return self::getLogger()->error($arguments[0], $arguments[1]);
			case 'warning':
				return self::getLogger()->warning($arguments[0], $arguments[1]);
			case 'notice':
				return self::getLogger()->notice($arguments[0], $arguments[1]);
			case 'info':
				return self::getLogger()->info($arguments[0], $arguments[1]);
			case 'debug':
				return self::getLogger()->debug($arguments[0], $arguments[1]);
		}
	}

}

?>