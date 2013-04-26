<?php

namespace Aijko\SharepointConnector\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 aijko GmbH <info@aijko.de
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
 * Test case for class \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute.
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class ListMappingAttributeTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Aijko\SharepointConnector\Domain\Model\ListMappingAttribute();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getSharepointFieldNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSharepointFieldNameForStringSetsSharepointFieldName() { 
		$this->fixture->setSharepointFieldName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSharepointFieldName()
		);
	}
	
	/**
	 * @test
	 */
	public function getTypo3FieldNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTypo3FieldNameForStringSetsTypo3FieldName() { 
		$this->fixture->setTypo3FieldName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTypo3FieldName()
		);
	}
	
	/**
	 * @test
	 */
	public function getAttributeTypeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAttributeTypeForStringSetsAttributeType() { 
		$this->fixture->setAttributeType('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAttributeType()
		);
	}
	
}
?>