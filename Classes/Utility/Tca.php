<?php
namespace Aijko\SharepointConnector\Utility;

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
 * TCA userFunc
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class Tca {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @var array
	 */
	protected $configuration;

	/**
	 * @var \Aijko\SharepointConnector\Utility\View
	 */
	protected $viewUtility;

	/**
	 *
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$this->configuration = $this->objectManager->get('Aijko\\SharepointConnector\\Configuration\\ConfigurationManager')->getConfiguration();
		$this->configurationManager->setConfiguration($this->configuration);
		$this->viewUtility = $this->objectManager->get('Aijko\\SharepointConnector\\Utility\\View');
	}

	/**
	 * Get all available listMappings
	 *
	 * @param array $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $formObject
	 * @return string
	 */
	public function getMappingLists(array $PA, \TYPO3\CMS\Backend\Form\FormEngine $formObject) {
		$mappingListsRepository = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Repository\\Mapping\\ListsRepository');
		$variables = array(
			'items' => $mappingListsRepository->findAll(),
			'data' => $PA,
			'fieldChangeFunc' => implode('', $PA['fieldChangeFunc'])
		);

		return $this->viewUtility->getStandaloneView($variables, 'Tca/MappingListsSelect.html')->render();
	}

	/**
	 * Get all available listMappings
	 *
	 * @param array $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $formObject
	 * @return string
	 */
	public function getMappingAttributesFromLists(array $PA, \TYPO3\CMS\Backend\Form\FormEngine $formObject) {
		$mappingAttributeRepository = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Repository\\Mapping\\AttributeRepository');
		$variables = array(
			'items' => $mappingAttributeRepository->findByList($PA['row']['sharepoint_list']),
			'data' => $PA,
			'fieldChangeFunc' => implode('', $PA['fieldChangeFunc'])
		);

		return $this->viewUtility->getStandaloneView($variables, 'Tca/MappingAttributesFromListsSelect.html')->render();
	}

}

?>