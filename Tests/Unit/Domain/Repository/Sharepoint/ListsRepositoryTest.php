<?php
namespace Aijko\SharepointConnector\Tests\Unit\Domain\Repository\Sharepoint;

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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class ListsRepositoryTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute
	 */
	protected $fixture;

	/**
	 * Setup
	 */
	public function setUp() {
		parent::setUp();
		$this->fixture = new \Aijko\SharepointConnector\Domain\Repository\Sharepoint\ListsRepository();
	}

	/**
	 * Teardown
	 */
	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getCalculatedCacheIdentifier() {
		$this->assertSame('9e6bb46f281e9a1001428ff7ba91bf9e3b559b9a', $this->fixture->calculateCacheIdentifier('SharepointConnector'));
	}

	/**
	 * test
	 * @TODO
	 */
	public function addToMultipleLists() {

	}

	/**
	 * test
	 * @TODO
	 */
	public function addRecordToList() {

	}

}

?>