<?php
namespace Aijko\SharepointConnector\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 aijko GmbH <info@aijko.de>
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
 * @package sharepoint_connector
 */
class MappingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\ListItemRepository
	 * @inject
	 */
	protected $mappingListItemRepository;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Mapping\AttributeRepository
	 * @inject
	 */
	protected $mappingAttributeRepository;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Repository\Sharepoint\ListItemRepository
	 * @inject
	 */
	protected $sharepointListItemRepository;

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
		$mappingListItems = $this->mappingListItemRepository->findAll();
		$this->view->assign('mappingListItems', $mappingListItems);
	}

	/**
	 * Add new list mapping - Step 1, choose a list
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @dontvalidate $mappingListItem
	 * @return void
	 */
	public function newStep1Action(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem = NULL) {
		$allLists = $this->sharepointListItemRepository->getAllLists();

		// remove lists that are still available
		$availableMappingListItems = $this->mappingListItemRepository->findAll();
		if (count($availableMappingListItems) > 0) {
			foreach ($availableMappingListItems as $key => $item) {
				if (array_key_exists($item->getSharepointListIdentifier(), $allLists)) {
					unset($allLists[$item->getSharepointListIdentifier()]);
				}
			}
		}

		$this->view->assign('allLists', $allLists);
		$this->view->assign('mappingListItem', $mappingListItem);
	}

	/**
	 * Add new list mapping - Step 2, mapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @dontvalidate $mappingListItem
	 * @return void
	 */
	public function newStep2Action(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem) {
		if ('' === $mappingListItem->getTypo3ListTitle()) {
			$this->flashMessageContainer->add('Please add a TYPO3 list title', 'ERROR', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			$this->redirect('newStep1');
		}

		$sharepointAttributes = $this->sharepointListItemRepository->findAttributesByIdentifier($mappingListItem->getSharepointListIdentifier());
		if (count($sharepointAttributes) > 0) {
			foreach ($sharepointAttributes[$mappingListItem->getSharepointListIdentifier()] as $sharepointListAttributes) {
				$listMappingAttribute = $this->propertyMapper->convert($sharepointListAttributes, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
				$mappingListItem->addAttribute($listMappingAttribute);
			}
		}

		$this->view->assign('mappingListItem', $mappingListItem);
	}

	/**
	 * Create new list mapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @param array $attributeData
	 * @dontvalidate $mappingListItem
	 * @dontvalidate $attributeData
	 * @return void
	 */
	public function createAction(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem, array $attributeData) {
		$attributesArray = array();
		if (count($attributeData) > 0) {
			foreach ($attributeData as $attributes) {
				if ($attributes['activated']) {
					unset($attributes['activated']);
					$attributesArray[] = $attributes;
					$mappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
					$mappingListItem->addAttribute($mappingAttribute);
				}
			}
		}

		$this->mappingListItemRepository->add($mappingListItem);
		$this->flashMessageContainer->add('Your ListMapping "' . $mappingListItem->getSharepointListIdentifier() . '" was added.');

		Logger::info('ListMapping: createAction', array(
			'listMappingUid' => $mappingListItem->getUid(),
			'sharepointListIdentifier' => $mappingListItem->getSharepointListIdentifier(),
			'typo3ListTitle' => $mappingListItem->getTypo3ListTitle(),
			'attributes' => json_encode($attributesArray),
		));

		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @return void
	 */
	public function editAction(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem) {
		$this->view->assign('mappingListItem', $mappingListItem);
	}

	/**
	 * action update
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @param array $attributeData
	 * @dontvalidate $mappingListItem
	 * @dontvalidate $attributeData
	 * @return void
	 */
	public function updateAction(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem, array $attributeData) {
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
				if ($attributes['activated']) {
					unset($attributes['activated']);
					$attributesArray[] = $attributes;
					$mappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
					$mappingListItem->addAttribute($mappingAttribute);
				}
			}
		}

		$this->mappingListItemRepository->update($mappingListItem);
		$this->flashMessageContainer->add('Your ListMapping "' . $mappingListItem->getSharepointListIdentifier() . '" was updated.');

		Logger::info('ListMapping: updateAction', array(
			'listMappingUid' => $mappingListItem->getUid(),
			'sharepointListIdentifier' => $mappingListItem->getSharepointListIdentifier(),
			'typo3ListTitle' => $mappingListItem->getTypo3ListTitle(),
			'attributes' => json_encode($attributesArray),
		));

		$this->redirect('edit', NULL, NULL, array('mappingListItem' => $mappingListItem));
	}

	/**
	 * Delete listmapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @return void
	 */
	public function deleteListAction(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem) {
		$this->mappingListItemRepository->remove($mappingListItem);
		$this->flashMessageContainer->add('Your ListMapping "' . $mappingListItem->getSharepointListIdentifier() . '" was deleted.');

		Logger::info('ListMapping: deleteAction', array(
			'listMappingUid' => $mappingListItem->getUid(),
			'sharepointListIdentifier' => $mappingListItem->getSharepointListIdentifier(),
			'typo3ListTitle' => $mappingListItem->getTypo3ListTitle(),
		));

		$this->redirect('list');
	}

	/**
	 * Delete single attribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $mappingAttribute
	 * @return void
	 */
	public function deleteAttributeAction(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem, \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $mappingAttribute) {
		$this->mappingAttributeRepository->remove($mappingAttribute);
		$this->flashMessageContainer->add('Your attribute "' . $mappingAttribute->getTypo3FieldName() . '" was deleted.');

		Logger::info('ListMapping: deleteAttributeAction', array(
			'listMappingUid' => $mappingListItem->getUid(),
			'sharepointListIdentifier' => $mappingListItem->getSharepointListIdentifier(),
			'typo3ListTitle' => $mappingListItem->getTypo3ListTitle(),
			'attributeUid' => $mappingAttribute->getUid(),
			'attribute' => $mappingAttribute->getTypo3FieldName()
		));

		$this->redirect('edit', NULL, NULL, array('mappingListItem' => $mappingListItem));
	}

	/**
	 * action sync
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem
	 * @return void
	 */
	public function syncAction(\Aijko\SharepointConnector\Domain\Model\Mapping\ListItem $mappingListItem) {
		$sharepointAttributes = $this->sharepointListItemRepository->findAttributesByIdentifier($mappingListItem->getSharepointListIdentifier());
		$typo3ListAttributes = $mappingListItem->getAttributes();

		if (count($sharepointAttributes) > 0) {
			// Sync sharepoint attributes with TYPO3 attributes
			$newAttributes = $this->getNewAttributes($sharepointAttributes[$mappingListItem->getSharepointListIdentifier()], $typo3ListAttributes);
			$this->view->assign('newAttributes', $newAttributes);

			// Sync TYPO3 attributes with sharepoint attributes to find out all deprecated attributes
			$this->syncAttributesToFindDeprecatedAttributes($sharepointAttributes[$mappingListItem->getSharepointListIdentifier()], $typo3ListAttributes);
		}

		$this->view->assign('mappingListItem', $mappingListItem);
	}

	/**
	 * Sync attributes to find new attributes
	 *
	 * @param array $sharepointListAttributes
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes
	 * @return array
	 */
	protected function getNewAttributes(array $sharepointListAttributes, \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes) {
		$newAttributes = array();
		foreach ($sharepointListAttributes as $sharepointListAttribute) {
			$mappingAttribute = $this->propertyMapper->convert($sharepointListAttribute, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');

			// check if sharepoint attribute exist in typo3 list mapping
			foreach ($typo3ListAttributes as $typo3Attribute) {
				if ($typo3Attribute->getSharepointFieldName() == $mappingAttribute->getSharepointFieldName()) {
					continue 2; // if attribute exist, continue with next sharepoint attribute
				}
			}

			$newAttributes[] = $mappingAttribute;
		}

		return $newAttributes;
	}

	/**
	 * Sync attributes to find deprecated attributes
	 *
	 * @param array $sharepointListAttributes
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes
	 * @return void
	 */
	protected function syncAttributesToFindDeprecatedAttributes(array $sharepointListAttributes, \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes) {
		foreach ($typo3ListAttributes as $typo3Attribute) {
			foreach ($sharepointListAttributes as $sharepointListAttribute) {
				$mappingAttribute = $this->propertyMapper->convert($sharepointListAttribute, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
				if ($typo3Attribute->getSharepointFieldName() == $mappingAttribute->getSharepointFieldName()) {
					continue 2; // if attribute exist, continue with next typo3 attribute
				}
			}

			$typo3Attribute->setStatus(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_DEPRECATED);
			$this->mappingAttributeRepository->update($typo3Attribute);
		}
	}

}
?>