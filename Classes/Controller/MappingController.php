<?php
namespace Aijko\SharepointConnector\Controller;

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

use \Aijko\SharepointConnector\Utility\Logger;

/**
 * Mapping Controller, Backend Sharepoint Module
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class MappingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\ListsRepository
	 * @inject
	 */
	protected $mappingListsRepository;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\AttributeRepository
	 * @inject
	 */
	protected $mappingAttributeRepository;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Sharepoint\ListsRepository
	 * @inject
	 */
	protected $sharepointListsRepository;

	/**
	 * The new, completely rewritten property mapper since Extbase 1.4.
	 *
	 * @var \TYPO3\CMS\Extbase\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @param \TYPO3\CMS\Extbase\Property\PropertyMapper $propertyMapper
	 * @return void
	 */
	public function injectPropertyMapper(\TYPO3\CMS\Extbase\Property\PropertyMapper $propertyMapper) {
		$this->propertyMapper = $propertyMapper;
	}

	/**
	 * List all available list mappings
	 *
	 * @return void
	 */
	public function listAction() {
		$mappingLists = $this->mappingListsRepository->findAll();
		$this->view->assign('mappingLists', $mappingLists);
	}

	/**
	 * Add new list mapping - Step 1, choose a list
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @dontvalidate $list
	 * @return void
	 */
	public function newStep1Action(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list = NULL) {
		$availableSharepointLists = $this->sharepointListsRepository->findAllLists();

		// remove lists that are still available
		$availableMappingLists = $this->mappingListsRepository->findAll();
		if (count($availableMappingLists) > 0) {
			foreach ($availableMappingLists as $key => $item) {
				foreach ($availableSharepointLists as $sharepointList) {
					if ($sharepointList->id != $item->getSharepointListIdentifier()) {
						continue;
					}

					$availableSharepointLists->detach($sharepointList);
				}
			}
		}

		$this->view->assign('availableSharepointLists', $availableSharepointLists);
		$this->view->assign('list', $list);
	}

	/**
	 * Add new list mapping - Step 2, mapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @dontvalidate $list
	 * @return void
	 */
	public function newStep2Action(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list) {
		if ('' === $list->getTypo3ListTitle()) {
			$this->flashMessageContainer->add('Please add a TYPO3 list title', 'ERROR', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			$this->redirect('newStep1');
		}

		$sharepointAttributes = $this->sharepointListsRepository->findAttributesByListIdentifier($list->getSharepointListIdentifier());
		if ($sharepointAttributes) {
			foreach ($sharepointAttributes as $sharepointAttribute) {
				$list->addAttribute($sharepointAttribute);
			}
		}

		$sharepointList = $this->sharepointListsRepository->findListByIdentifier($list->getSharepointListIdentifier());
		$list->setSharepointListTitle($sharepointList->title);

		$this->view->assign('list', $list);
	}

	/**
	 * Create new list mapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @param array $attributeData
	 * @dontvalidate $list
	 * @dontvalidate $attributeData
	 * @return void
	 */
	public function createAction(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list, array $attributeData) {
		$attributesArray = array();
		if (count($attributeData) > 0) {
			foreach ($attributeData as $attributes) {
				if (!$attributes['activated']) {
					continue;
				}

				unset($attributes['activated']);
				$attributesArray[] = $attributes;
				$mappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
				$list->addAttribute($mappingAttribute);
			}
		}

		$this->mappingListsRepository->add($list);
		$this->flashMessageContainer->add('ListMapping "' . $list->getSharepointListTitle() . '" was added.');

		Logger::info('MappingController:createAction', array(
			'listMappingUid' => $list->getUid(),
			'sharepointListIdentifier' => $list->getSharepointListIdentifier(),
			'sharepointListTitle' => $list->getSharepointListTitle(),
			'typo3ListTitle' => $list->getTypo3ListTitle(),
			'attributes' => json_encode($attributesArray),
		));

		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @return void
	 */
	public function editAction(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list) {
		$this->view->assign('list', $list);
	}

	/**
	 * action update
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @param array $attributeData
	 * @dontvalidate $mappingLists
	 * @dontvalidate $attributeData
	 * @return void
	 */
	public function updateAction(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list, array $attributeData) {
		$attributesArray = array();
		if (count($attributeData['available']) > 0) {
			foreach ($attributeData['available'] as $key => $attributes) {
				$attributesArray[] = $attributes;
				$mappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
				$this->mappingAttributeRepository->update($mappingAttribute);
			}
		}
		if (count($attributeData['new']) > 0) {
			foreach ($attributeData['new'] as $key => $attributes) {
				if (!$attributes['activated']) {
					continue;
				}
				unset($attributes['activated']);
				$attributesArray[] = $attributes;
				$mappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
				$list->addAttribute($mappingAttribute);
			}
		}

		$this->mappingListsRepository->update($list);
		$this->flashMessageContainer->add('ListMapping "' . $list->getSharepointListTitle() . '" was updated.');

		Logger::info('MappingController:updateAction', array(
			'listMappingUid' => $list->getUid(),
			'sharepointListIdentifier' => $list->getSharepointListIdentifier(),
			'typo3ListTitle' => $list->getTypo3ListTitle(),
			'attributes' => json_encode($attributesArray),
		));

		$this->redirect('edit', NULL, NULL, array('list' => $list));
	}

	/**
	 * Delete listmapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @return void
	 */
	public function deleteListAction(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list) {
		$this->mappingListsRepository->remove($list);
		$this->flashMessageContainer->add('ListMapping "' . $list->getSharepointListTitle() . '" was deleted.');

		Logger::info('MappingController:deleteAction', array(
			'listMappingUid' => $list->getUid(),
			'sharepointListIdentifier' => $list->getSharepointListIdentifier(),
			'typo3ListTitle' => $list->getTypo3ListTitle(),
		));

		$this->redirect('list');
	}

	/**
	 * Delete single attribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $mappingAttribute
	 * @return void
	 */
	public function deleteAttributeAction(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list, \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $mappingAttribute) {
		$this->mappingAttributeRepository->remove($mappingAttribute);
		$this->flashMessageContainer->add('Your attribute "' . $mappingAttribute->getTypo3FieldName() . '" was deleted.');

		Logger::info('MappingController:deleteAttributeAction', array(
			'listMappingUid' => $list->getUid(),
			'sharepointListIdentifier' => $list->getSharepointListIdentifier(),
			'typo3ListTitle' => $list->getTypo3ListTitle(),
			'attributeUid' => $list->getUid(),
			'attribute' => $mappingAttribute->getTypo3FieldName()
		));

		$this->redirect('edit', NULL, NULL, array('list' => $list));
	}

	/**
	 * action sync
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @return void
	 */
	public function syncAction(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list) {
		$GLOBALS['typo3CacheManager']->flushCachesByTag('spc_list_attributes');
		$sharepointAttributes = $this->sharepointListsRepository->findAttributesByListIdentifier($list->getSharepointListIdentifier());
		$typo3ListAttributes = $list->getAttributes();

		if ($sharepointAttributes) {

			// Sync sharepoint attributes with TYPO3 attributes
			$newAttributes = \Aijko\SharepointConnector\Utility\Attribute::syncAttributesAndFindAllNewOnes($sharepointAttributes, $typo3ListAttributes);
			$this->view->assign('newAttributes', $newAttributes);

			// Sync TYPO3 attributes with sharepoint attributes to find out all deprecated attributes
			$deprecatedAttributes = \Aijko\SharepointConnector\Utility\Attribute::syncAttributesToFindDeprecatedAttributes($sharepointAttributes, $typo3ListAttributes);
			if (count($deprecatedAttributes) > 0) {
				foreach ($deprecatedAttributes as $deprecatedAttribute) {
					$this->mappingAttributeRepository->update($deprecatedAttribute);
				}
			}

			// Sync TYPO3 attributes with sharepoint attributes to find out all renamed attributes
			$renamedAttributes = \Aijko\SharepointConnector\Utility\Attribute::syncAttributesToFindRenamedAttributes($sharepointAttributes, $typo3ListAttributes, $this->mappingAttributeRepository);
			if (count($renamedAttributes) > 0) {
				foreach ($renamedAttributes as $renamedAttribute) {
					$this->mappingAttributeRepository->update($renamedAttribute);
				}
			}
		}

		$this->view->assign('list', $list);
	}

}