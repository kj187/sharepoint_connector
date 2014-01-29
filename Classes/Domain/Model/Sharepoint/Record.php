<?php
namespace Aijko\SharepointConnector\Domain\Model\Sharepoint;

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
 * Record model
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class Record {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	protected $list;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @param array $data
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 */
	public function setList($list) {
		$this->list = $list;
	}

	/**
	 * @return \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	public function getList() {
		return $this->list;
	}

}

?>