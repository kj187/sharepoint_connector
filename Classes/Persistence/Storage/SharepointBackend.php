<?php
namespace aijko\SharepointConnector\Persistence\Storage;

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
class SharepointBackend implements \TYPO3\CMS\Extbase\Persistence\Generic\Storage\BackendInterface, \TYPO3\CMS\Core\SingletonInterface  {

	/**
	 * @var \aijko\SharepointConnector\Service\SharepointApi
	 */
	protected $sharepointApi;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}

	/**
	 * Returns the object data matching the $query.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @return array
	 */
	public function getObjectDataByQuery(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query) {

		$objects = array();

		switch ($query->getType()) {

			case 'aijko\SharepointConnector\Domain\Model\SharepointList':
				$objects = $this->querySharepointList($query);
				break;

			default:
				throw new \Exception('Invalid query type "' . $query->getType() . '"', 1326130251);
				break;
		}

		return $objects;
	}

	/**
	 * Returns the number of items matching the query.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @return integer
	 * @api
	 */
	public function getObjectCountByQuery(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query) {
		return count($this->getObjectDataByQuery($query));
	}

	/**
	 * Returns the sharepoint lists
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @return array
	 */
	protected function querySharepointList($query) { // TODO: do we need the dataMapper? Look at Typo3Backend.

		$lists = array();

			/** @var $constraint \TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint */
		$constraint = $query->getConstraint();

		if (!$constraint) {
				// get all lists
			$lists = $this->getSharepointApi()->getLists();

		} else {
			throw new \Exception('Constraint is passed.');
		}

			/** @var $operand1 \TYPO3\CMS\Extbase\Persistence\Generic\Qom\PropertyValueInterface */
		//$operand1 = $constraint->getOperand1();

//		var_dump($operand1->getPropertyName());
//		var_dump($constraint->getOperator());

		return $lists;
	}

	/**
	 * Adds a row to the storage
	 *
	 * @param string $tableName The database table name
	 * @param array $row The row to insert
	 * @param boolean $isRelation TRUE if we are currently inserting into a relation table, FALSE by default
	 * @return void
	 */
	public function addRow($tableName, array $row, $isRelation = FALSE) {
		throw new \Exception('TODO: Implement addRow() method.');
	}
	/**
	 * Updates a row in the storage
	 *
	 * @param string $tableName The database table name
	 * @param array $row The row to update
	 * @param boolean $isRelation TRUE if we are currently inserting into a relation table, FALSE by default
	 * @return void
	 */
	public function updateRow($tableName, array $row, $isRelation = FALSE) {
		throw new \Exception('TODO: Implement updateRow() method.');
	}

	/**
	 * Deletes a row in the storage
	 *
	 * @param string $tableName The database table name
	 * @param array $identifier An array of identifier array('fieldname' => value).
	 * @param boolean $isRelation TRUE if we are currently inserting into a relation table, FALSE by default
	 * @return void
	 */
	public function removeRow($tableName, array $identifier, $isRelation = FALSE) {
		throw new \Exception('TODO: Implement removeRow() method.');
	}


	/**
	 * Returns an initialized sharepoint api service
	 *
	 * @return \aijko\SharepointConnector\Service\SharepointApi
	 */
	protected function getSharepointApi() {

		if (!$this->sharepointApi) {

			$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
			$sharepointSettings = $frameworkConfiguration['settings']['sharepointServer'];

			$username = $sharepointSettings['username']; // TODO: make sure we handle the situation when the credentials are not set via TypoScript
			$password = $sharepointSettings['password'];
			$wsdl = $sharepointSettings['wsdl'];

			$api = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('aijko\\SharepointConnector\\Service\\SharepointApi', $username, $password, $wsdl);

			$this->sharepointApi = $api;
		}

		return $this->sharepointApi;
	}
}

?>