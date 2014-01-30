<?php
namespace Aijko\SharepointConnector\Domain\Repository\Sharepoint;

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
 * Lists sharepoint repository
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class ListsRepository {

	const GLOBAL_CACHE_TAG = 'sharepoint_connector';

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\AbstractFrontend
	 */
	protected $cacheInstance;

	/**
	 * @var \Aijko\SharepointConnector\Service\SharepointDriverInterface
	 */
	protected $sharepointHandle;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\ListsRepository
	 * @inject
	 */
	protected $mappingListsRepository;

	/**
	 *
	 */
	public function __construct() {
		$this->initializeCache();
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->sharepointHandle = $this->objectManager->get('Aijko\\SharepointConnector\\Service\\SharepointDriverInterface');
	}

	/**
	 * Initialize cache instance to be ready to use
	 *
	 * @return void
	 */
	protected function initializeCache() {
		\TYPO3\CMS\Core\Cache\Cache::initializeCachingFramework();
		try {
			$this->cacheInstance = $GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists');
		} catch (\TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException $e) {
			$this->cacheInstance = $GLOBALS['typo3CacheFactory']->create(
				'sharepointconnector_lists',
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sharepointconnector_lists']['frontend'],
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sharepointconnector_lists']['backend'],
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sharepointconnector_lists']['options']
			);
		}
	}

	/**
	 *
	 */
	public function calculateCacheIdentifier($value) {
		return sha1($value);
	}

	/**
	 * @see \Aijko\SharepointConnector\Service\SharepointDriverInterface::findAllLists
	 * @return object
	 */
	public function findAllLists() {
		$cacheIdentifier = $this->calculateCacheIdentifier('findAllLists');
		if (($entry = $GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists')->get($cacheIdentifier)) === FALSE) {
			$entry = $this->sharepointHandle->findAllLists();
			$GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists')->set($cacheIdentifier, $entry, array('allLists', self::GLOBAL_CACHE_TAG));
		}
		return $entry;
	}

	/**
	 * @see \Aijko\SharepointConnector\Service\SharepointDriverInterface::findListByIdentifier
	 * @param string $identifier
	 * @return array
	 */
	public function findListByIdentifier($identifier) {
		$cacheIdentifier = $this->calculateCacheIdentifier('findListByIdentifier' . $identifier);
		if (($entry = $GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists')->get($cacheIdentifier)) === FALSE) {
			$entry = $this->sharepointHandle->findListByIdentifier($identifier);
			$GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists')->set($cacheIdentifier, $entry, array('list', str_replace(array('{', '}'), array('', ''), $identifier), self::GLOBAL_CACHE_TAG));
		}
		return $entry;
	}

	/**
	 * @see \Aijko\SharepointConnector\Service\SharepointDriverInterface::findAttributesByIdentifier
	 * @param string $identifier
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAttributesByIdentifier($identifier) {
		$cacheIdentifier = $this->calculateCacheIdentifier('findAttributesByIdentifier' . $identifier);
		if (($entry = $GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists')->get($cacheIdentifier)) === FALSE) {
			$entry = $this->sharepointHandle->findAttributesByIdentifier($identifier);
			$GLOBALS['typo3CacheManager']->getCache('sharepointconnector_lists')->set($cacheIdentifier, $entry, array('attribute', str_replace(array('{', '}'), array('', ''), $identifier), self::GLOBAL_CACHE_TAG));
		}
		return $entry;
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
		$result = array();
		if (is_array($data) && count($data)>0) {
			foreach ($data as $listUid => $postData) {
				$record = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Model\\Sharepoint\\Record');
				$record->setList($this->mappingListsRepository->findByUid($listUid));
				$record->setData($postData);
				$result[$listUid] = $this->addRecordToList($record);
			}
		}

		return $result;
	}

	/**
	 * Add a new entry to a specific list
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Sharepoint\Record $record
	 * @return array | object
	 */
	public function addRecordToList(\Aijko\SharepointConnector\Domain\Model\Sharepoint\Record $record) {
		$mapping = $this->objectManager->get('Aijko\\SharepointConnector\\Utility\\Mapping');
		$list = $record->getList();
		$data = $mapping->convertToSharepointData($list, $record->getData());
		if (!count($data)) {
			return FALSE;
		}

		return $this->sharepointHandle->addRecordToList($list->getSharepointListIdentifier(), $data);
	}

}

?>