<?php
namespace Aijko\SharepointConnector\Service;

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
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class LookupUpdater {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\ListsRepository
	 */
	protected $mappingListsRepository;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Sharepoint\ListsRepository
	 */
	protected $sharepointListsRepository;

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\Sharepoint\RecordResult> $resultObject
	 * @return array
	 */
	public function process(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $resultObject) {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->mappingListsRepository = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Repository\\Mapping\\ListsRepository');
		$this->sharepointListsRepository = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Repository\\Sharepoint\\ListsRepository');
		$updateResults = array();

		foreach ($resultObject as $recordResult) {
			$list = $recordResult->getList();
			$listMapping = $this->mappingListsRepository->findByUid($list->getUid());
			foreach ($listMapping->getAttributes() as $attribute) {
				if ('Lookup' == $attribute->getType()) {
					if ($targetUidFromLookup = $this->getTargetUidFromLookup($attribute->getLookuplist(), clone $resultObject)) {
						$updateResults[] = $this->sharepointListsRepository->updateRecord($list->getSharepointListIdentifier(), $recordResult->getId(), array($attribute->getSharepointFieldName() => $targetUidFromLookup));
					}
				}
			}
		}

		return $updateResults;
	}

	/**
	 * @param string $lookupList
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\Sharepoint\RecordResult> $resultObject
	 * @return integer | FALSE
	 */
	protected function getTargetUidFromLookup($lookupList, \TYPO3\CMS\Extbase\Persistence\ObjectStorage $resultObject) {
		$lookupList = strtoupper($lookupList);
		foreach($resultObject as $recordResult) {
			if ($lookupList == $recordResult->getList()->getSharepointListIdentifier()) {
				return $recordResult->getId();
			}
		}

		return FALSE;
	}

}

?>