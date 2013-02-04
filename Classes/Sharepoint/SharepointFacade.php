<?php
namespace Aijko\SharepointConnector\Sharepoint;

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
 * Sharepoint facade
 *
 * Usage:
 *
 *  	with REST:
 *  	$sharepointRESTApi = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Sharepoint\\Rest\\Sharepoint');
 *  	$this->sharepointApi = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Sharepoint\\SharepointFacade', $sharepointRESTApi);
 *
 *
 * @package sharepoint_connector
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SharepointFacade implements \Aijko\SharepointConnector\Sharepoint\SharepointInterface {

	/**
	 * @var \Aijko\SharepointConnector\Sharepoint\SharepointInterface
	 */
	protected $sharepointApi = NULL;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\ListMappingRepository
	 * @inject
	 */
	protected $listMappingRepository;

	/**
	 * @var \Aijko\SharepointConnector\Sharepoint\SharepointInterface $sharepointApi
	 * @var array $typoscriptConfiguration
	 */
	public function __construct(\Aijko\SharepointConnector\Sharepoint\SharepointInterface $sharepointApi, array $typoscriptConfiguration = array()) {
		$this->sharepointApi = $sharepointApi;

		$settings = $this->initializeSettings($typoscriptConfiguration);
		$this->sharepointApi->initialize($settings);
	}

	/**
	 * Initialize all necessary settings
	 *
	 * @return array
	 */
	protected function initializeSettings(array $typoscriptConfiguration) {

		// get typoscript settings if you dont inject this
		if (!count($typoscriptConfiguration)) {
			$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
			$typoscriptConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
			$typoscriptConfiguration = $typoscriptConfiguration['module.']['tx_sharepointconnector.']['settings.']['sharepointServer.'];
		}
		$typoscriptConfiguration = \t3lib_div::removeDotsFromTS($typoscriptConfiguration);

		// get extension configuration
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sharepoint_connector']);
		$extensionConfiguration = \t3lib_div::removeDotsFromTS($extensionConfiguration);

		// merge typoscript configuration and extension configuration
		return array_merge($typoscriptConfiguration, $extensionConfiguration['sharepointServer']);
	}

	/**
	 * @return array
	 */
	public function getAllLists() {
		return $this->sharepointApi->getAllLists();
	}

	/**
	 * @param $listTitle
	 * @return array
	 */
	public function getListAttributes($listTitle) {
		return $this->sharepointApi->getListAttributes($listTitle);
	}

	/**
	 * Add a new entry to a specific list
	 *
	 * @param string $listMappingUid
	 * @param array $data
	 */
	public function addToList($listMappingUid, array $data) {
		$listMapping = $this->listMappingRepository->findByIdentifier($listMappingUid);
		$mapping = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Utility\\Mapping');
		$data = $mapping->convertToSharepointData($listMapping, $data);
		return $this->sharepointApi->addToList($listMapping->getSharepointListIdentifier(), $data);
	}

}

?>