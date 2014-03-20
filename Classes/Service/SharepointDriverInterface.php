<?php
namespace Aijko\SharepointConnector\Service;

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
 * Sharepoint API Service Interface
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
interface SharepointDriverInterface {

	/**
	 * Get all available sharepoint lists
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAllLists();

	/**
	 * Get a list by a specific sharepoint identifier
	 *
	 * @param string $identifier List identifier
	 * @return array
	 */
	public function findListByIdentifier($identifier);

	/**
	 * Get all available attributes from a specific sharepoint list
	 *
	 * @param string $identifier List identifier
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function findAttributesByListIdentifier($identifier);

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
	public function findRecords($listIdentifier, $limit = NULL, $query = NULL, $view = NULL, $sort = NULL, $options = NULL);

	/**
	 * @param string $listIdentifier
	 * @return \Thybag\Service\QueryObjectService
	 */
	public function advancedQuery($listIdentifier);

	/**
	 * @param string $identifier List identifier
	 * @param array $data
	 * @return mixed
	 */
	public function addRecordToList($identifier, array $data);

	/**
	 * Update a specific record
	 *
	 * @param string $listIdentifier List identifier
	 * @param string $recordIdentifier Record identifier
	 * @param array $data
	 * @return mixed
	 */
	public function updateRecord($listIdentifier, $recordIdentifier, array $data);

}
