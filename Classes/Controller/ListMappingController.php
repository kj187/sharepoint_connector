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
 * Sharepoint Mapping Controller
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
	 * @var \Aijko\SharepointConnector\Domain\Repository\ListMappingAttributeRepository
	 * @inject
	 */
	protected $listMappingAttributeRepository;

	/**
	 * @var \Aijko\SharepointConnector\Sharepoint\SharepointInterface
	 */
	protected $sharepointApi;

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
	 * Initialize action method
	 */
	public function initializeAction() {
		$sharepointRESTApi = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Aijko\\SharepointConnector\\Sharepoint\\Rest\\Sharepoint');
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
		$sharepointAttributes = $this->sharepointApi->getListAttributes($listMapping->getSharepointListIdentifier());
		if (count($sharepointAttributes) > 0) {
			foreach ($sharepointAttributes[$listMapping->getSharepointListIdentifier()] as $sharepointListAttributes) {
				$listMappingAttribute = $this->propertyMapper->convert($sharepointListAttributes, 'Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');
				$listMapping->addAttribute($listMappingAttribute);
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
		if (count($attributeData) > 0) {
			foreach ($attributeData as $attributes) {
				if ($attributes['activated']) {
					unset($attributes['activated']);
					$listMappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');
					$listMapping->addAttribute($listMappingAttribute);
				}
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
	 * @param array $attributeData
	 * @dontvalidate $listMapping
	 * @dontvalidate $attributeData
	 * @return void
	 */
	public function updateAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping, array $attributeData) {
		if (count($attributeData['available']) > 0) {
			foreach ($attributeData['available'] as $key => $attributes) {
				$listMappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');
				$this->listMappingAttributeRepository->update($listMappingAttribute);
			}
		}
		if (count($attributeData['new']) > 0) {
			foreach ($attributeData['new'] as $key => $attributes) {
				if ($attributes['activated']) {
					unset($attributes['activated']);
					$listMappingAttribute = $this->propertyMapper->convert($attributes, 'Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');
					$listMapping->addAttribute($listMappingAttribute);
				}
			}
		}

		$this->listMappingRepository->update($listMapping);
		$this->flashMessageContainer->add('Your ListMapping "' . $listMapping->getSharepointListIdentifier() . '" was updated.');
		$this->redirect('edit', NULL, NULL, array('listMapping' => $listMapping));
	}

	/**
	 * Delete listmapping
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @return void
	 */
	public function deleteListAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping) {
		$this->listMappingRepository->remove($listMapping);
		$this->flashMessageContainer->add('Your ListMapping "' . $listMapping->getSharepointListIdentifier() . '" was deleted.');
		$this->redirect('list');
	}

	/**
	 * Delete single attribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute $listMappingAttribute
	 * @return void
	 */
	public function deleteAttributeAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping, \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute $listMappingAttribute) {
		$this->listMappingAttributeRepository->remove($listMappingAttribute);
		$this->flashMessageContainer->add('Your attribute "' . $listMappingAttribute->getTypo3FieldName() . '" was deleted.');
		$this->redirect('edit', NULL, NULL, array('listMapping' => $listMapping));
	}

	/**
	 * action sync
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @return void
	 */
	public function syncAction(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping) {
		$sharepointAttributes = $this->sharepointApi->getListAttributes($listMapping->getSharepointListIdentifier());
		$typo3ListAttributes = $listMapping->getAttributes();

		if (count($sharepointAttributes) > 0) {
			// Sync sharepoint attributes with TYPO3 attributes
			$newAttributes = $this->getNewAttributes($sharepointAttributes[$listMapping->getSharepointListIdentifier()], $typo3ListAttributes);
			$this->view->assign('newAttributes', $newAttributes);

			// Sync TYPO3 attributes with sharepoint attributes to find out all deprecated attributes
			$this->syncAttributesToFindDeprecatedAttributes($sharepointAttributes[$listMapping->getSharepointListIdentifier()], $typo3ListAttributes);
		}

		$this->view->assign('listMapping', $listMapping);
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
			$sharepointListAttribute = $this->propertyMapper->convert($sharepointListAttribute, 'Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');

			// check if sharepoint attribute exist in typo3 list mapping
			foreach ($typo3ListAttributes as $typo3Attribute) {
				if ($typo3Attribute->getSharepointFieldName() == $sharepointListAttribute->getSharepointFieldName()) {
					continue 2; // if attribute exist, continue with next sharepoint attribute
				}
			}

			$newAttributes[] = $sharepointListAttribute;
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
				$sharepointListAttribute = $this->propertyMapper->convert($sharepointListAttribute, 'Aijko\\SharepointConnector\\Domain\\Model\\ListMappingAttribute');
				if ($typo3Attribute->getSharepointFieldName() == $sharepointListAttribute->getSharepointFieldName()) {
					continue 2; // if attribute exist, continue with next typo3 attribute
				}
			}

			$typo3Attribute->setStatus(\Aijko\SharepointConnector\Domain\Model\ListMappingAttribute::STATUS_DEPRECATED);
			$this->listMappingAttributeRepository->update($typo3Attribute);
		}
	}

}
?>