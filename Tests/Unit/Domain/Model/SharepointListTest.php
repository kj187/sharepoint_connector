<?php

namespace aijko\SharepointConnector\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Erik Frister <erik.frister@aijko.de>, aijko GmbH
 *  			Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
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
 * Test case for class \aijko\SharepointConnector\Domain\Model\SharepointList.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Sharepoint Connector
 *
 * @author Erik Frister <erik.frister@aijko.de>
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 */
class SharepointListTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \aijko\SharepointConnector\Domain\Model\SharepointList
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \aijko\SharepointConnector\Domain\Model\SharepointList();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getDefaultViewUrlReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDefaultViewUrlForStringSetsDefaultViewUrl() { 
		$this->fixture->setDefaultViewUrl('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDefaultViewUrl()
		);
	}
	
	/**
	 * @test
	 */
	public function getIdReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setIdForStringSetsId() { 
		$this->fixture->setId('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getId()
		);
	}
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getFeatureIdReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFeatureIdForStringSetsFeatureId() { 
		$this->fixture->setFeatureId('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFeatureId()
		);
	}
	
	/**
	 * @test
	 */
	public function getBaseTypeReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getBaseType()
		);
	}

	/**
	 * @test
	 */
	public function setBaseTypeForIntegerSetsBaseType() { 
		$this->fixture->setBaseType(12);

		$this->assertSame(
			12,
			$this->fixture->getBaseType()
		);
	}
	
	/**
	 * @test
	 */
	public function getWebIdReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setWebIdForStringSetsWebId() { 
		$this->fixture->setWebId('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getWebId()
		);
	}
	
	/**
	 * @test
	 */
	public function getScopeIdReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setScopeIdForStringSetsScopeId() { 
		$this->fixture->setScopeId('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getScopeId()
		);
	}
	
	/**
	 * @test
	 */
	public function getAllowDeletionReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setAllowDeletionForOoleanSetsAllowDeletion() { }
	
}
?>