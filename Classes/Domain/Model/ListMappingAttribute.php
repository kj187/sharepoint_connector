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
class ListMappingAttribute extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Internal Sharepoint field name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $sharepointFieldName;

	/**
	 * TYPO3 field name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $typo3FieldName;

	/**
	 * Attribute type
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $attributeType;

	/**
	 * Returns the sharepointFieldName
	 *
	 * @return \string $sharepointFieldName
	 */
	public function getSharepointFieldName() {
		return $this->sharepointFieldName;
	}

	/**
	 * Sets the sharepointFieldName
	 *
	 * @param \string $sharepointFieldName
	 * @return void
	 */
	public function setSharepointFieldName($sharepointFieldName) {
		$this->sharepointFieldName = $sharepointFieldName;
	}

	/**
	 * Returns the typo3FieldName
	 *
	 * @return \string $typo3FieldName
	 */
	public function getTypo3FieldName() {
		return $this->typo3FieldName;
	}

	/**
	 * Sets the typo3FieldName
	 *
	 * @param \string $typo3FieldName
	 * @return void
	 */
	public function setTypo3FieldName($typo3FieldName) {
		$this->typo3FieldName = $typo3FieldName;
	}

	/**
	 * Returns the attributeType
	 *
	 * @return \string $attributeType
	 */
	public function getAttributeType() {
		return $this->attributeType;
	}

	/**
	 * Sets the attributeType
	 *
	 * @param \string $attributeType
	 * @return void
	 */
	public function setAttributeType($attributeType) {
		$this->attributeType = $attributeType;
	}

}
?>