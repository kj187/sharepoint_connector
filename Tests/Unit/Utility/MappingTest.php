<?php
namespace Aijko\SharepointConnector\Tests\Unit\Utility;

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
class MappingTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Lists | PHPUnit_Framework_MockObject_MockObject
	 */
	protected $lists;

	/**
	 * Setup
	 */
	public function setUp() {
		parent::setUp();
		$this->lists = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Lists');
	}

	/**
	 * Tear down
	 */
	public function tearDown() {

	}

	/**
	 * @test
	 */
	public function isDataConvertedToSharepointData() {
		$attribute = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$attribute
			->expects($this->any())
			->method('getTypo3FieldName')
			->will($this->returnValue('Vorname'));
		$attribute
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('FirstName'));
		$attributes[] = $attribute;

		$attribute = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$attribute
			->expects($this->any())
			->method('getTypo3FieldName')
			->will($this->returnValue('Nachname'));
		$attribute
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('LastName'));
		$attributes[] = $attribute;

		$this->lists
			->expects($this->any())
			->method('getAttributes')
			->will($this->returnValue($attributes));

		$result = \Aijko\SharepointConnector\Utility\Mapping::convertToSharepointData($this->lists, array('Vorname' => 'Julian', 'Nachname' => 'Kleinhans'));
		$this->assertEquals(array('FirstName' => 'Julian', 'LastName' => 'Kleinhans'), $result);
	}

	/**
	 * @test
	 * @expectedException \Aijko\SharepointConnector\Utility\Exception
	 */
	public function invalidConvertedSharepointDataThrowsException() {
		$this->lists
			->expects($this->any())
			->method('getAttributes')
			->will($this->returnValue(array()));

		\Aijko\SharepointConnector\Utility\Mapping::convertToSharepointData($this->lists, array());
	}

}
