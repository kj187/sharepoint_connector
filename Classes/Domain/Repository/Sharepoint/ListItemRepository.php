<?php
namespace Aijko\SharepointConnector\Domain\Repository\Sharepoint;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 aijko GmbH <info@aijko.de
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
 * ListItem sharepoint repository
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class ListItemRepository {

	/**
	 * @var \Aijko\SharepointConnector\Service\SharepointInterface
	 */
	protected $sharepointHandle;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\ListItemRepository
	 * @inject
	 */
	protected $mappingListItemRepository;

	/**
	 *
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->sharepointHandle = $this->objectManager->get('Aijko\\SharepointConnector\\Service\\SharepointInterface');
	}

	/**
	 * @see \Aijko\SharepointConnector\Service\SharepointInterface::findAllListItems
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAllListItems() {
		return $this->sharepointHandle->findAllListItems();
	}

	/**
	 * @see \Aijko\SharepointConnector\Service\SharepointInterface::findAttributesByIdentifier
	 * @param string $identifier
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAttributesByIdentifier($identifier) {
		return $this->sharepointHandle->findAttributesByIdentifier($identifier);
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
			foreach ($data as $listItemUid => $postData) {
				$record = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Model\\Sharepoint\\Record');
				$record->setListItem($this->mappingListItemRepository->findByUid($listItemUid));
				$record->setData($postData);
				$void[$listItemUid] = $this->addRecordToList($record);
			}
		}

		return $void;
	}

	/**
	 * Add a new entry to a specific list
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Sharepoint\Record $record
	 * @return void
	 */
	public function addRecordToList(\Aijko\SharepointConnector\Domain\Model\Sharepoint\Record $record) {
		$mapping = $this->objectManager->get('Aijko\\SharepointConnector\\Utility\\Mapping');
		$listItem = $record->getListItem();
		$data = $mapping->convertToSharepointData($listItem, $record->getData());
		if (!count($data)) {
			return FALSE;
		}

		return $this->sharepointHandle->addRecordToList($listItem->getSharepointListIdentifier(), $data);
	}

}

?>