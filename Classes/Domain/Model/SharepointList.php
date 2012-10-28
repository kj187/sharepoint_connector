<?php
namespace aijko\SharepointConnector\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Erik Frister <erik.frister@aijko.de>, aijko GmbH
 *  Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
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
class SharepointList extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * defaultViewUrl
	 *
	 * @var \string
	 */
	protected $defaultViewUrl;

	/**
	 * id
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $id;

	/**
	 * title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * description
	 *
	 * @var \string
	 */
	protected $description;

	/**
	 * name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * featureId
	 *
	 * @var \string
	 */
	protected $featureId;

	/**
	 * baseType
	 *
	 * @var \integer
	 */
	protected $baseType;

	/**
	 * webId
	 *
	 * @var \string
	 */
	protected $webId;

	/**
	 * scopeId
	 *
	 * @var \string
	 */
	protected $scopeId;

	/**
	 * allowDeletion
	 *
	 * @var boolean
	 */
	protected $allowDeletion = FALSE;

	/**
	 * Returns the defaultViewUrl
	 *
	 * @return \string $defaultViewUrl
	 */
	public function getDefaultViewUrl() {
		return $this->defaultViewUrl;
	}

	/**
	 * Sets the defaultViewUrl
	 *
	 * @param \string $defaultViewUrl
	 * @return void
	 */
	public function setDefaultViewUrl($defaultViewUrl) {
		$this->defaultViewUrl = $defaultViewUrl;
	}

	/**
	 * Returns the id
	 *
	 * @return \string $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Sets the id
	 *
	 * @param \string $id
	 * @return void
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the description
	 *
	 * @return \string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the featureId
	 *
	 * @return \string $featureId
	 */
	public function getFeatureId() {
		return $this->featureId;
	}

	/**
	 * Sets the featureId
	 *
	 * @param \string $featureId
	 * @return void
	 */
	public function setFeatureId($featureId) {
		$this->featureId = $featureId;
	}

	/**
	 * Returns the baseType
	 *
	 * @return \integer $baseType
	 */
	public function getBaseType() {
		return $this->baseType;
	}

	/**
	 * Sets the baseType
	 *
	 * @param \integer $baseType
	 * @return void
	 */
	public function setBaseType($baseType) {
		$this->baseType = $baseType;
	}

	/**
	 * Returns the webId
	 *
	 * @return \string $webId
	 */
	public function getWebId() {
		return $this->webId;
	}

	/**
	 * Sets the webId
	 *
	 * @param \string $webId
	 * @return void
	 */
	public function setWebId($webId) {
		$this->webId = $webId;
	}

	/**
	 * Returns the scopeId
	 *
	 * @return \string $scopeId
	 */
	public function getScopeId() {
		return $this->scopeId;
	}

	/**
	 * Sets the scopeId
	 *
	 * @param \string $scopeId
	 * @return void
	 */
	public function setScopeId($scopeId) {
		$this->scopeId = $scopeId;
	}

	/**
	 * Returns the allowDeletion
	 *
	 * @return boolean $allowDeletion
	 */
	public function getAllowDeletion() {
		return $this->allowDeletion;
	}

	/**
	 * Sets the allowDeletion
	 *
	 * @param boolean $allowDeletion
	 * @return void
	 */
	public function setAllowDeletion($allowDeletion) {
		$this->allowDeletion = $allowDeletion;
	}

	/**
	 * Returns the boolean state of allowDeletion
	 *
	 * @return boolean
	 */
	public function isAllowDeletion() {
		return $this->getAllowDeletion();
	}

}
?>