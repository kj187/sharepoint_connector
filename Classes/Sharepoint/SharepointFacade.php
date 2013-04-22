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

use \Aijko\SharepointConnector\Utility\Logger;

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
	 * @var \Aijko\SharepointConnector\Domain\Repository\ListMappingAttributeRepository
	 * @inject
	 */
	protected $listMappingAttributeRepository;

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
	 * @param array $typoscriptConfiguration
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
	 * Add to multiple lists
	 *
	 * 		$data[LIST_UID][ATTRIBUTE_NAME]
	 *
	 * @param array $data
	 * @return array
	 */
	public function addToMultipleLists(array $data) {
		if (is_array($data) && count($data)>0) {
			foreach ($data as $listMappingUid => $postData) {
				$void[$listMappingUid] = $this->addToList($listMappingUid, $postData);
			}
		}

		return $void;
	}

	/**
	 * Add a new entry to a specific list
	 *
	 * @param integer $listMappingUid
	 * @param array $postData
	 * @return FALSE|xml
	 */
	public function addToList($listMappingUid, array $postData) {
		$listMapping = $this->listMappingRepository->findByUid($listMappingUid);
		$mapping = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Utility\\Mapping');
		$data = $mapping->convertToSharepointData($listMapping, $postData);
		if (!count($data)) {
			return FALSE;
		}

		return $this->sharepointApi->addToList($listMapping->getSharepointListIdentifier(), $data);
	}

	/**
	 * @param integer $uid
	 * @return object
	 */
	public function getListMappingByUid($uid) {
		return $this->listMappingRepository->findByUid($uid);
	}

	/**
	 * @param integer $uid
	 * @return object
	 */
	public function getListMappingAttributeByUid($uid) {
		return $this->listMappingAttributeRepository->findByUid($uid);
	}

}

?>