<?php
namespace Aijko\SharepointConnector\Domain\Model;

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
class ListMapping extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Internal Sharepoint list identifier
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $sharepointListIdentifier;

	/**
	 * Internal Sharepoint list title
	 *
	 * @var \string
	 */
	protected $sharepointListTitle;

	/**
	 * TYPO3 list title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $typo3ListTitle;

	/**
	 * Attributes
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\ListMappingAttribute>
	 */
	protected $attributes;

	/**
	 * __construct
	 *
	 * @return ListMapping
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->attributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the sharepointListIdentifier
	 *
	 * @return \string $sharepointListIdentifier
	 */
	public function getSharepointListIdentifier() {
		return $this->sharepointListIdentifier;
	}

	/**
	 * Sets the sharepointListIdentifier
	 *
	 * @param \string $sharepointListIdentifier
	 * @return void
	 */
	public function setSharepointListIdentifier($sharepointListIdentifier) {
		$this->sharepointListIdentifier = $sharepointListIdentifier;
	}

	/**
	 * Returns the sharepointListTitle
	 *
	 * @return \string $sharepointListTitle
	 */
	public function getSharepointListTitle() {
		return $this->sharepointListTitle;
	}

	/**
	 * Sets the sharepointListTitle
	 *
	 * @param \string $sharepointListTitle
	 * @return void
	 */
	public function setSharepointListTitle($sharepointListTitle) {
		$this->sharepointListTitle = $sharepointListTitle;
	}

	/**
	 * Returns the typo3ListTitle
	 *
	 * @return \string $typo3ListTitle
	 */
	public function getTypo3ListTitle() {
		return $this->typo3ListTitle;
	}

	/**
	 * Sets the typo3ListTitle
	 *
	 * @param \string $typo3ListTitle
	 * @return void
	 */
	public function setTypo3ListTitle($typo3ListTitle) {
		$this->typo3ListTitle = $typo3ListTitle;
	}

	/**
	 * Adds a ListMappingAttribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute $attribute
	 * @return void
	 */
	public function addAttribute(\Aijko\SharepointConnector\Domain\Model\ListMappingAttribute $attribute) {
		$this->attributes->attach($attribute);
	}

	/**
	 * Removes a ListMappingAttribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute $attributeToRemove The ListMappingAttribute to be removed
	 * @return void
	 */
	public function removeAttribute(\Aijko\SharepointConnector\Domain\Model\ListMappingAttribute $attributeToRemove) {
		$this->attributes->detach($attributeToRemove);
	}

	/**
	 * Returns the attributes
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\ListMappingAttribute> $attributes
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * Sets the attributes
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\ListMappingAttribute> $attributes
	 * @return void
	 */
	public function setAttributes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $attributes) {
		$this->attributes = $attributes;
	}

}
?>