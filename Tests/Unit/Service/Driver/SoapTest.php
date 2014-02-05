<?php
namespace Aijko\SharepointConnector\Tests\Unit\Service\Driver;

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
class SoapTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \Aijko\SharepointConnector\Domain\Model\Mapping\Attribute
	 */
	protected $fixture;

	/**
	 * @var array
	 */
	protected $fixtureList = array();

	/**
	 * @var \Thybag\SharepointApi
	 */
	protected $sharepointHandler = NULL;

	/**
	 * @var \TYPO3\CMS\Extbase\Property\PropertyMapper
	 */
	protected $propertyManager;

	/**
	 * Setup
	 */
	public function setUp() {
		parent::setUp();

		$this->propertyManager = new \TYPO3\CMS\Extbase\Property\PropertyMapper();
		$configurationBuilder = new \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder();
		$this->inject($this->propertyManager , 'configurationBuilder', $configurationBuilder);
		$this->inject($this->propertyManager , 'objectManager', $this->objectManager);
		$this->propertyManager->initializeObject();

		$dummyList = new \stdClass();
		$dummyList->id = '{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}';
		$dummyList->title = 'Kontakte';
		$this->fixtureList[] = $dummyList;

		$dummyList = new \stdClass();
		$dummyList->id = '{BF306B2A-CBB7-4284-A17C-BEC46F3FE6C1}';
		$dummyList->title = 'Artikel';
		$this->fixtureList[] = $dummyList;

		$this->sharepointHandler = $this->getMockBuilder('Thybag\SharepointApi')->disableOriginalConstructor()->getMock();
		$this->sharepointHandler
			->expects($this->any())
			->method('setReturnType')
			->will($this->returnValue(''));
		$this->sharepointHandler
			->expects($this->any())
			->method('getLists')
			->will($this->returnValue($this->fixtureList));
	}

	/**
	 * Teardown
	 */
	public function tearDown() {
		unset($this->fixture);
		unset($this->fixtureList);
	}

	/**
	 * @return \Aijko\SharepointConnector\Service\Driver\Soap
	 */
	protected function getFixture() {
		return new \Aijko\SharepointConnector\Service\Driver\Soap($this->sharepointHandler);
	}

	/**
	 * @test
	 */
	public function isObjectExtendingAbstractDriver() {
		$fixture = $this->getFixture();
		$this->assertInstanceOf('\Aijko\SharepointConnector\Service\AbstractDriver', $fixture);
	}

	/**
	 * @test
	 */
	public function isObjectImplementsSharepointDriverInterface() {
		$fixture = $this->getFixture();
		$this->assertInstanceOf('\Aijko\SharepointConnector\Service\SharepointDriverInterface', $fixture);
	}

	/**
	 * @test
	 */
	public function getCountFromFindAllLists() {
		$this->assertSame(2, $this->getFixture()->findAllLists()->count());
	}

	/**
	 * @test
	 */
	public function getTitleFromFindAllLists() {
		$fixture = $this->getFixture()->findAllLists();
		$this->assertSame('Kontakte', $fixture->current()->title);

		$fixture->next();
		$this->assertSame('Artikel', $fixture->current()->title);
	}

	/**
	 * @test
	 */
	public function getIdFromFindAllLists() {
		$fixture = $this->getFixture()->findAllLists();
		$this->assertSame('{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}', $fixture->current()->id);

		$fixture->next();
		$this->assertSame('{BF306B2A-CBB7-4284-A17C-BEC46F3FE6C1}', $fixture->current()->id);
	}

	/**
	 * @test
	 */
	public function getASpecificListFromFindListByIdentifier() {
		$fixture = $this->getFixture()->findListByIdentifier('{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}');
		$this->assertSame('{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}', $fixture->id);
	}

	/**
	 * @test
	 */
	public function getAttributesFromFindAttributesByListIdentifier() {
		$this->sharepointHandler
			->expects($this->any())
			->method('readListMeta')
			->will($this->returnValue(array(
				array(
					'type' => 'Text',
					'name' => 'Title',
					'displayname' => 'Artikel Nr.',
					'required' => TRUE,
				),
				array(
					'type' => 'Number',
					'name' => 'Preis',
			 		'displayname' => 'Preis EUR',
					'required' => FALSE,
				)
			)));

		$fixture = $this->getFixture();
		$this->inject($fixture , 'propertyMapper', $this->propertyManager);

		$result = $fixture->findAttributesByListIdentifier('{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}');
		$this->assertInstanceOf('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute', $result->current());
		$this->assertSame('Title', $result->current()->getSharepointFieldName());
		$this->assertSame('Text', $result->current()->getType());
		$this->assertSame('Artikel Nr.', $result->current()->getSharepointDisplayname());
		$this->assertTrue($result->current()->getRequired());

		$result->next();
		$this->assertInstanceOf('Aijko\\SharepointConnector\\Domain\\Model\\Mapping\\Attribute', $result->current());
		$this->assertSame('Preis', $result->current()->getSharepointFieldName());
		$this->assertSame('Number', $result->current()->getType());
		$this->assertSame('Preis EUR', $result->current()->getSharepointDisplayname());
		$this->assertFalse($result->current()->getRequired());
	}

	/**
	 * @test
	 */
	public function addRecordToList() {
		$this->sharepointHandler
			->expects($this->once())
			->method('write')
			->will($this->returnValue(array(
				array(
					'title' => 'Kleinhans',
					'firstname' => 'Julian',
					'linktitle' => 'Kleinhans',
					'id' => 9,
					'contenttype' => 'Kunden',
				)
			)));

		$fixture = $this->getFixture();
		$result = $fixture->addRecordToList('{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}', array(
			'title' => 'Kleinhans',
			'firstname' => 'Julian',
		));

		$this->assertSame('Kleinhans', $result[0]['title']);
		$this->assertSame('Julian', $result[0]['firstname']);
		$this->assertSame('Kleinhans', $result[0]['linktitle']);
		$this->assertSame(9, $result[0]['id']);
		$this->assertSame('Kunden', $result[0]['contenttype']);
	}

	/**
	 * @test
	 */
	public function updateRecord() {
		$this->sharepointHandler
			->expects($this->once())
			->method('update')
			->will($this->returnValue(array(
				array(
					'title' => 'Kleinhans',
					'firstname' => 'Julian',
					'linktitle' => 'Kleinhans',
					'id' => 9,
					'contenttype' => 'Kunden',
				)
			)));

		$fixture = $this->getFixture();
		$result = $fixture->updateRecord('{0344CAA0-94D5-40DE-A6EC-0D551BAC869D}', 9, array(
			'title' => 'Kleinhans',
		));

		$this->assertSame('Kleinhans', $result[0]['title']);
		$this->assertSame('Julian', $result[0]['firstname']);
		$this->assertSame('Kleinhans', $result[0]['linktitle']);
		$this->assertSame(9, $result[0]['id']);
		$this->assertSame('Kunden', $result[0]['contenttype']);
	}

}

?>