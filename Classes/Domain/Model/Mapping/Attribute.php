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
 * @package Aijko\SharepointConnector
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
	 * Type
	 *
	 * @var \string
	 */
	protected $type;

	/**
	 * Required
	 *
	 * @var \boolean
	 */
	protected $required;

	/**
	 * lookuplist
	 *
	 * @var \string
	 */
	protected $lookuplist;

	/**
	 * sourceid
	 *
	 * @var \string
	 */
	protected $sourceid;

	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var string
	 */
	protected $childContent;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	protected $list;

	/**
	 * Returns the sharepointFieldName
	 *
	 * @return string $sharepointFieldName
	 */
	public function getSharepointFieldName() {
		return $this->sharepointFieldName;
	}

	/**
	 * Sets the sharepointFieldName
	 *
	 * @param string $sharepointFieldName
	 * @return void
	 */
	public function setSharepointFieldName($sharepointFieldName) {
		$this->sharepointFieldName = $sharepointFieldName;
	}

	/**
	 * Returns the sharepointDisplayName
	 *
	 * @return string $sharepointDisplayName
	 */
	public function getSharepointDisplayName() {
		return $this->sharepointDisplayName;
	}

	/**
	 * Sets the sharepointDisplayName
	 *
	 * @param string $sharepointDisplayName
	 * @return void
	 */
	public function setSharepointDisplayName($sharepointDisplayName) {
		$this->sharepointDisplayName = $sharepointDisplayName;
	}

	/**
	 * Returns the typo3FieldName
	 *
	 * @return string $typo3FieldName
	 */
	public function getTypo3FieldName() {
		return $this->typo3FieldName;
	}

	/**
	 * Sets the typo3FieldName
	 *
	 * @param string $typo3FieldName
	 * @return void
	 */
	public function setTypo3FieldName($typo3FieldName) {
		$this->typo3FieldName = $typo3FieldName;
	}

	/**
	 * Returns the type
	 *
	 * @return string $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
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
	public function setList(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list) {
		$this->list = $list;
	}

	/**
	 * @return \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	public function getList() {
		return $this->list;
	}

	/**
	 * @param string $lookuplist
	 */
	public function setLookuplist($lookuplist) {
		$this->lookuplist = $lookuplist;
	}

	/**
	 * @return string
	 */
	public function getLookuplist() {
		return $this->lookuplist;
	}

	/**
	 * @param boolean $required
	 */
	public function setRequired($required) {
		$this->required = $required;
	}

	/**
	 * @return boolean
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * @param string $sourceid
	 */
	public function setSourceid($sourceid) {
		$this->sourceid = $sourceid;
	}

	/**
	 * @return string
	 */
	public function getSourceid() {
		return $this->sourceid;
	}

	/**
	 * @param string $childContent
	 */
	public function setChildContent($childContent) {
		$this->childContent = $childContent;
	}

	/**
	 * @return string
	 */
	public function getChildContent() {
		return $this->childContent;
	}


}

?>