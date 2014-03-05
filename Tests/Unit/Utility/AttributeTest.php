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
class AttributeTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * Setup
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Tear down
	 */
	public function tearDown() {

	}

	/**
	 * @test
	 */
	public function isANewAttributeAvailableAfterSync() {
		$sharepointListAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$sharepointListAttributeFirstName = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$sharepointListAttributeFirstName
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('FirstName'));
		$sharepointListAttributes->attach($sharepointListAttributeFirstName);
		$sharepointListAttributeLastName = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$sharepointListAttributeLastName
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('LastName'));
		$sharepointListAttributes->attach($sharepointListAttributeLastName);

		$typo3ListAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$typo3ListAttributeFirstName = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$typo3ListAttributeFirstName
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('FirstName'));
		$typo3ListAttributes->attach($typo3ListAttributeFirstName);

		$this->assertSame(array($sharepointListAttributeLastName), \Aijko\SharepointConnector\Utility\Attribute::syncAttributesAndFindAllNewOnes($sharepointListAttributes, $typo3ListAttributes));
	}

	/**
	 * @test
	 */
	public function isADeprecatedAttributeAvailableAfterSync() {
		$sharepointListAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$sharepointListAttributeTitle = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$sharepointListAttributeTitle
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('Sharepoint'));
		$sharepointListAttributes->attach($sharepointListAttributeTitle);

		$typo3ListAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$typo3ListAttributeFirstName = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$typo3ListAttributeFirstName
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('FirstName'));
		$typo3ListAttributeFirstName
			->expects($this->once())
			->method('setStatus')
			->will($this->returnValue(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_SYNC_DEPRECATED));
		$typo3ListAttributeFirstName
			->expects($this->once())
			->method('getStatus')
			->will($this->returnValue(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_SYNC_DEPRECATED));
		$typo3ListAttributes->attach($typo3ListAttributeFirstName);

		$deprecatedAttributes = \Aijko\SharepointConnector\Utility\Attribute::syncAttributesToFindDeprecatedAttributes($sharepointListAttributes, $typo3ListAttributes);
		$this->assertSame(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_SYNC_DEPRECATED, $deprecatedAttributes[0]->getStatus());
	}

	/**
	 * @test
	 */
	public function isARenamedAttributeAvailableAfterSync() {
		$sharepointListAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$sharepointListAttributeFirstName = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$sharepointListAttributeFirstName
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('FirstName'));
		$sharepointListAttributeFirstName
			->expects($this->any())
			->method('getSharepointDisplayName')
			->will($this->returnValue('FirstNameWithNewDisplayname'));
		$sharepointListAttributes->attach($sharepointListAttributeFirstName);

		$typo3ListAttributes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$typo3ListAttributeFirstName = $this->getMock('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute');
		$typo3ListAttributeFirstName
			->expects($this->any())
			->method('getSharepointFieldName')
			->will($this->returnValue('FirstName'));
		$typo3ListAttributeFirstName
			->expects($this->once())
			->method('getSharepointDisplayName')
			->will($this->returnValue('FirstName'));
		$typo3ListAttributeFirstName
			->expects($this->once())
			->method('setStatus')
			->will($this->returnValue(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_SYNC_RENAMED));
		$typo3ListAttributeFirstName
			->expects($this->once())
			->method('getStatus')
			->will($this->returnValue(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_SYNC_RENAMED));
		$typo3ListAttributes->attach($typo3ListAttributeFirstName);

		$renamedAttributes = \Aijko\SharepointConnector\Utility\Attribute::syncAttributesToFindRenamedAttributes($sharepointListAttributes, $typo3ListAttributes);
		$this->assertSame(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_SYNC_RENAMED, $renamedAttributes[0]->getStatus());
	}

}