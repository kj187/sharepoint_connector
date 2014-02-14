<?php
namespace Aijko\SharepointConnector\Domain\Model\Mapping;

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
 * Lists model
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class Lists extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Internal Sharepoint list identifier
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $sharepointListIdentifier;

	/**
	 * Sharepoint list title
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
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute>
	 */
	protected $attributes;

	/**
	 *
	 */
	public function __construct() {
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->attributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the sharepointListIdentifier
	 *
	 * @return string $sharepointListIdentifier
	 */
	public function getSharepointListIdentifier() {
		return $this->sharepointListIdentifier;
	}

	/**
	 * Sets the sharepointListIdentifier
	 *
	 * @param string $sharepointListIdentifier
	 * @return void
	 */
	public function setSharepointListIdentifier($sharepointListIdentifier) {
		$this->sharepointListIdentifier = $sharepointListIdentifier;
	}

	/**
	 * @param string $sharepointListTitle
	 */
	public function setSharepointListTitle($sharepointListTitle) {
		$this->sharepointListTitle = $sharepointListTitle;
	}

	/**
	 * @return string
	 */
	public function getSharepointListTitle() {
		return $this->sharepointListTitle;
	}

	/**
	 * Returns the typo3ListTitle
	 *
	 * @return string $typo3ListTitle
	 */
	public function getTypo3ListTitle() {
		return $this->typo3ListTitle;
	}

	/**
	 * Sets the typo3ListTitle
	 *
	 * @param string $typo3ListTitle
	 * @return void
	 */
	public function setTypo3ListTitle($typo3ListTitle) {
		$this->typo3ListTitle = $typo3ListTitle;
	}

	/**
	 * Adds a ListMappingAttribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $attribute
	 * @return void
	 */
	public function addAttribute(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $attribute) {
		$this->attributes->attach($attribute);
	}

	/**
	 * Removes a ListMappingAttribute
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $attributeToRemove The ListMappingAttribute to be removed
	 * @return void
	 */
	public function removeAttribute(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute $attributeToRemove) {
		$this->attributes->detach($attributeToRemove);
	}

	/**
	 * Returns the attributes
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute> $attributes
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * Sets the attributes
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute> $attributes
	 * @return void
	 */
	public function setAttributes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $attributes) {
		$this->attributes = $attributes;
	}

}

?>