<?php
namespace Aijko\SharepointConnector\Service\Driver;

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
 * Sharepoint SOAP Driver
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class Soap extends \Aijko\SharepointConnector\Service\AbstractDriver implements \Aijko\SharepointConnector\Service\SharepointDriverInterface {

	/**
	 * @var \Thybag\SharePointAPI
	 */
	protected $sharepointHandler;

	/**
	 * @param NULL $sharepointHandler
	 */
	public function __construct($sharepointHandler = NULL) {
		parent::__construct();
		$this->sharepointHandler = $sharepointHandler;

		if (NULL == $this->sharepointHandler) {
			$this->sharepointHandler = new \Thybag\SharePointAPI($this->configuration['username'], $this->configuration['password'], $this->configuration['url'] . $this->configuration['soap']['wsdlpath'], (bool)$this->configuration['security']['ntlm']);
		}
	}

	/**
	 * Get all available sharepoint lists
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAllLists() {
		$lists = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$this->sharepointHandler->setReturnType('object');
		$originalLists = $this->sharepointHandler->getLists();
		foreach ($originalLists as $item) {
			$lists->attach($item);
		}

		return $lists;
	}

	/**
	 * Get a list by a specific sharepoint identifier
	 *
	 * @param string $identifier
	 * @return object | FALSE
	 */
	public function findListByIdentifier($identifier) {
		$allLists = $this->findAllLists();
		foreach ($allLists as $list) {
			if ($list->id == $identifier) {
				return $list;
			}
		}
		return FALSE;
	}

	/**
	 * Use's raw CAML to query sharepoint data
	 *
	 * @param string $listIdentifier
	 * @param int $limit
	 * @param array $query
	 * @param string (GUID) $view "View to display results with."
	 * @param array $sort
	 * @param string $options "XML string of query options."
	 * @return array
	 */
	public function findRecords($listIdentifier, $limit = NULL, $query = NULL, $view = NULL, $sort = NULL, $options = NULL) {
		return $this->sharepointHandler->read($listIdentifier, $limit, $query, $view, $sort, $options);
	}

	/**
	 * Get all available attributes from a specific sharepoint list
	 *
	 * @param string $identifier
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAttributesByListIdentifier($identifier) {
		$properties = $this->sharepointHandler->readListMeta($identifier);
		$attributes = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');

		foreach ($properties as $propertyNode) {
			$attribute = array();
			$attribute['sharepointFieldName'] = $propertyNode['name'];
			$attribute['sharepointDisplayName'] = $propertyNode['displayname'];
			$attribute['type'] = $propertyNode['type'];
			$attribute['childContent'] = $propertyNode['value'];

			$attribute['required'] = (bool)$propertyNode['required'];
			if ('Lookup' == $propertyNode['type']) {
				$attribute['lookuplist'] = $propertyNode['list'];
				$attribute['sourceid'] = $propertyNode['sourceid'];
			}

			$attribute['typo3FieldName'] = '';
			$attributes->attach($this->propertyMapper->convert($attribute, 'Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute'));
		}

		return $attributes;
	}

	/**
	 * Add a new record to a specific sharepoint list
	 *
	 * @param string $identifier List identifier
	 * @param array $data
	 * @return array | object
	 */
	public function addRecordToList($identifier, array $data) {
		return $this->sharepointHandler->write($identifier, $data);
	}

	/**
	 * Update a specific record
	 *
	 * @param string $listIdentifier List identifier
	 * @param string $recordIdentifier Record identifier
	 * @param array $data
	 * @return mixed
	 */
	public function updateRecord($listIdentifier, $recordIdentifier, array $data) {
		return $this->sharepointHandler->update($listIdentifier, $recordIdentifier, $data);
	}

}