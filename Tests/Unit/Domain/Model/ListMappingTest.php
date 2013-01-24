<?php

namespace Aijko\SharepointConnector\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
 *  			Erik Frister <ef@aijko.de>, aijko GmbH
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
 * Test case for class \Aijko\SharepointConnector\Domain\Model\ListMapping.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Sharepoint Connector
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @author Erik Frister <ef@aijko.de>
 */
class ListMappingTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\ListMapping
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Aijko\SharepointConnector\Domain\Model\ListMapping();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getSharepointListIdentifierReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSharepointListIdentifierForStringSetsSharepointListIdentifier() { 
		$this->fixture->setSharepointListIdentifier('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSharepointListIdentifier()
		);
	}
	
	/**
	 * @test
	 */
	public function getTypo3ListTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTypo3ListTitleForStringSetsTypo3ListTitle() { 
		$this->fixture->setTypo3ListTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTypo3ListTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getAttributesReturnsInitialValueForListMappingAttribute() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getAttributes()
		);
	}

	/**
	 * @test
	 */
	public function setAttributesForObjectStorageContainingListMappingAttributeSetsAttributes() { 
		$attribute = new \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute();
		$objectStorageHoldingExactlyOneAttributes = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneAttributes->attach($attribute);
		$this->fixture->setAttributes($objectStorageHoldingExactlyOneAttributes);

		$this->assertSame(
			$objectStorageHoldingExactlyOneAttributes,
			$this->fixture->getAttributes()
		);
	}
	
	/**
	 * @test
	 */
	public function addAttributeToObjectStorageHoldingAttributes() {
		$attribute = new \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute();
		$objectStorageHoldingExactlyOneAttribute = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneAttribute->attach($attribute);
		$this->fixture->addAttribute($attribute);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneAttribute,
			$this->fixture->getAttributes()
		);
	}

	/**
	 * @test
	 */
	public function removeAttributeFromObjectStorageHoldingAttributes() {
		$attribute = new \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($attribute);
		$localObjectStorage->detach($attribute);
		$this->fixture->addAttribute($attribute);
		$this->fixture->removeAttribute($attribute);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getAttributes()
		);
	}
	
}
?>