<?php
namespace Aijko\SharepointConnector\Configuration;

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
 * Configuration Manager
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class ConfigurationManager implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var array
	 */
	protected $configuration = array();

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @return void
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$typoscriptConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$configuration = $typoscriptConfiguration['module.']['tx_sharepointconnector.'];
		$this->configuration = \TYPO3\CMS\Core\Utility\GeneralUtility::removeDotsFromTS($configuration);

		// get extension configuration
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sharepoint_connector']);
		$extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::removeDotsFromTS($extensionConfiguration);

		// merge typoscript configuration and extension configuration
		$this->configuration['settings']['sharepointServer'] = array_merge($this->configuration['settings']['sharepointServer'], $extensionConfiguration['sharepointServer']);
	}

	/**
	 * @param array $configuration
	 */
	public function setConfiguration($configuration) {
		$this->configuration = $configuration;
	}

	/**
	 * @return array
	 */
	public function getConfiguration() {
		return $this->configuration;
	}

}

?>
