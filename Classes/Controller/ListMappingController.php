<?php
namespace Aijko\SharepointConnector\Controller;

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
 *
 * @package sharepoint_connector
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ListMappingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\ListMappingRepository
	 * @inject
	 */
	protected $listMappingRepository;

	/**
	 * @var \Aijko\SharepointConnector\Sharepoint\SharepointInterface
	 */
	protected $sharepointApi;

	/**
	 * Initialize action method
	 */
	public function initializeAction() {
		$sharepointRESTApi = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Sharepoint\\Rest\\Sharepoint', $this->settings['sharepointServer']);
		$this->sharepointApi = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Sharepoint\\SharepointFacade', $sharepointRESTApi);
	}

	/**
	 * List all available list mappings
	 *
	 * @return void
	 */
	public function listAction() {
		$listMappings = $this->listMappingRepository->findAll();
		$this->view->assign('listMappings', $listMappings);
	}

	/**
	 * Add new list mapping - Step 1, choose a list
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @dontvalidate $listMapping
	 * @return void
	 */
	public function newStep1Action(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping = NULL) {
		$this->view->assign('allLists', $this->sharepointApi->getAllLists());
		$this->view->assign('listMapping', $listMapping);
	}

	/**
	 * Add new list mapping - Step 2, mapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @dontvalidate $listMapping
	 * @return void
	 */
	public function newStep2Action(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping) {

		// Add sharepoint attributes
		$sharepointAttributes = $this->sharepointApi->getListAttributes($listMapping->getSharepointListIdentifier());
		if (count($sharepointAttributes) > 0) {
			foreach ($sharepointAttributes[$listMapping->getSharepointListIdentifier()] as $attributes) {
				$this->prepareAttributeObject($listMapping, $attributes);
			}
		}

		$this->view->assign('listMapping', $listMapping);
	}

	/**
	 * Create new list mapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @param array $attributeData
	 * @dontvalidate $listMapping
	 * @dontvalidate $attributeData
	 * @return void
	 */
	public function createAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping, array $attributeData) {

		// Add sharepoint attributes
		if (count($attributeData) > 0) {
			foreach ($attributeData as $attributes) {
				$this->prepareAttributeObject($listMapping, $attributes);
			}
		}

		$this->listMappingRepository->add($listMapping);
		$this->flashMessageContainer->add('Your ListMapping "' . $listMapping->getSharepointListIdentifier() . '" was added.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @return void
	 */
	public function editAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping) {
		$this->view->assign('listMapping', $listMapping);
	}

	/**
	 * action update
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @return void
	 */
	public function updateAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping) {
		$this->listMappingRepository->update($listMapping);
		$this->flashMessageContainer->add('Your ListMapping was updated.');
		$this->redirect('list');
	}

	/**
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @param array $attributes
	 * @return void
	 */
	public function prepareAttributeObject(\Aijko\SharepointConnector\Domain\Model\ListMapping &$listMapping, array $attributes) {
		$listMappingAttribute = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');
		$listMappingAttribute->setSharepointFieldName($attributes['sharepointFieldName']);
		$listMappingAttribute->setAttributeType($attributes['attributeType']);
		$listMappingAttribute->setTypo3FieldName($attributes['typo3FieldName']);
		$listMapping->addAttribute($listMappingAttribute);
	}

}
?>