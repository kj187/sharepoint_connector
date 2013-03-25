<?php
namespace Aijko\SharepointConnector\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
 *  Erik Frister <ef@aijko.de>, aijko GmbH
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
 *
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
				\TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
					'\\TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
						'logFile' => 'typo3temp/logs/sharepoint_connector/debug.log',
					),
				),
				\TYPO3\CMS\Core\Log\LogLevel::EMERGENCY => array(
					'\\Aijko\\SharepointConnector\\Log\\Writer\\Email' => array(
						'recipient' => 'julian.kleinhans@aijko.de',
						'sender' => 'julian.kleinhans@aijko.de',
					)
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
	 * Error
	 *
	 * @param string $message
	 * @param array $data
	 * @return string A speaking message
	 */
	static public function error($message, $data = array()) {
		self::initializeConfiguration();
		return self::getLogger()->error($message, $data);
	}

	/**
	 * Debug
	 *
	 * @param string $message
	 * @param array $data
	 * @return string A speaking message
	 */
	static public function debug($message, $data = array()) {
		self::initializeConfiguration();
		return self::getLogger()->debug($message, $data);
	}

}

?>