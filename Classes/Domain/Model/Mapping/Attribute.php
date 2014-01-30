<?php
namespace Aijko\SharepointConnector\Domain\Model\Mapping;

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

/**
 * Attribute model
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class Attribute extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	const STATUS_SYNC_DEPRECATED 	= 2;
	const STATUS_SYNC_RENAMED 		= 3;

	/**
	 * Internal Sharepoint field name
	 *
	 * @var \string
	 */
	protected $sharepointFieldName;

	/**
	 * Internal Sharepoint display name
	 *
	 * @var \string
	 */
	protected $sharepointDisplayName;

	/**
	 * TYPO3 field name
	 *
	 * @var \string
	 */
	protected $typo3FieldName;

	/**
	 * Attribute type
	 *
	 * @var \string
	 */
	protected $attributeType;

	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	protected $list;

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
	 * Returns the sharepointDisplayName
	 *
	 * @return \string $sharepointDisplayName
	 */
	public function getSharepointDisplayName() {
		return $this->sharepointDisplayName;
	}

	/**
	 * Sets the sharepointDisplayName
	 *
	 * @param \string $sharepointDisplayName
	 * @return void
	 */
	public function setSharepointDisplayName($sharepointDisplayName) {
		$this->sharepointDisplayName = $sharepointDisplayName;
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

	/**
	 * @param string $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 */
	public function setList($list) {
		$this->$list = $list;
	}

	/**
	 * @return \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	public function getList() {
		return $this->list;
	}

}
?>