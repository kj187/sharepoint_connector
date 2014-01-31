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
 * @package sharepoint_connector
 */
class AttributeTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Lists | PHPUnit_Framework_MockObject_MockObject
	 */
	protected $lists;

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute
	 */
	protected $fixture;

	/**
	 * @var string
	 */
	protected $dummyString = 'Sharepoint Connector';

	/**
	 * Setup
	 */
	public function setUp() {
		parent::setUp();
		$this->fixture = new \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute();
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
	public function isSetterGetterWorkingForSharepointFieldName() {
		$this->fixture->setSharepointFieldName($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getSharepointFieldName());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForSharepointDisplayName() {
		$this->fixture->setSharepointDisplayName($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getSharepointDisplayName());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForTypo3FieldName() {
		$this->fixture->setTypo3FieldName($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getTypo3FieldName());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForType() {
		$this->fixture->setType($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getType());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForStatus() {
		$this->fixture->setStatus($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getStatus());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForLookuplist() {
		$this->fixture->setLookuplist($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getLookuplist());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForRequired() {
		$this->fixture->setRequired(TRUE);
		$this->assertSame(TRUE, $this->fixture->getRequired());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForSourceid() {
		$this->fixture->setSourceid($this->dummyString);
		$this->assertSame($this->dummyString, $this->fixture->getSourceid());
	}

	/**
	 * @test
	 */
	public function isSetterGetterWorkingForList() {
		$list = new \Aijko\SharepointConnector\Domain\Model\Mapping\Lists();
		$this->fixture->setList($list);
		$this->assertSame($list, $this->fixture->getList());
	}

}

?>