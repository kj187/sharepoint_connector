<?php
namespace Aijko\SharepointConnector\Tests\Unit\Domain\Model\Mapping;

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
 * @package Aijko\SharepointConnector
 */
class ListMappingTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Lists
	 */
	protected $fixture;

	/**
	 * Setup
	 */
	public function setUp() {
		$this->fixture = new \Aijko\SharepointConnector\Domain\Model\Mapping\Lists();
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
	public function isSetterGetterWorkingForSharepointListIdentifer() {
		$this->fixture->setSharepointListIdentifier($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getSharepointListIdentifier());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForSharepointListTitle() {
		$this->fixture->setSharepointListTitle($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getSharepointListTitle());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForTypo3ListTitle() {
		$this->fixture->setTypo3ListTitle($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getTypo3ListTitle());
	}

	/**
	 * @test
	 */
	public function getAttributesReturnsInitialValueForListMappingAttribute() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getAttributes()
		);
	}

	/**
	 * @test
	 */
	public function setAttributesForObjectStorageContainingListMappingAttributeSetsAttributes() { 
		$attribute = new \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute();
		$objectStorageHoldingExactlyOneAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$attribute = new \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute();
		$objectStorageHoldingExactlyOneAttribute = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$attribute = new \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
