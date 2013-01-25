<?php
namespace Aijko\SharepointConnector\Sharepoint\Rest;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
 *  Erik Frister <ef@aijko.de>, aijko GmbH
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
 * Sharepoint API Service
 *
 * TODO - error handling
 * TODO - XML caching
 *
 * @package sharepoint_connector
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Sharepoint implements \Aijko\SharepointConnector\Sharepoint\SharepointInterface {

	/**
	 * @var resource a cURL handle on success, false on errors.
	 */
	protected $curlObject = FALSE;

	/**
	 * @var array
	 */
	protected $httpHeader = array();

	/**
	 * @var array
	 */
	protected $settings = array();

	/**
	 * @var string
	 */
	protected $prependUrl = '';

	/**
	 * @param array $settings
	 */
	public function initialize(array $settings) {
		$this->settings = $settings;
		#\t3lib_utility_Debug::debug($settings);

		$this->curlObject = curl_init();

		curl_setopt($this->curlObject, CURLOPT_HEADER, false);
		curl_setopt($this->curlObject, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->curlObject, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($this->curlObject, CURLOPT_RETURNTRANSFER, true);

		if ($this->settings['security']['ntlm']) {
			//Use NTLM for HTTP authentication
			curl_setopt($this->curlObject, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		}

		curl_setopt($this->curlObject, CURLOPT_USERPWD, $this->settings['username'] . ':' . $this->settings['password']);

		//Stop cURL from verifying the peer’s certification
		#curl_setopt($this->curlObject, CURLOPT_SSL_VERIFYPEER, false);
	}

	/**
	 * @return mixed
	 */
	protected function execute() {
		$url = $this->settings['url'] . $this->settings['rest']['serviceUrl'] . $this->prependUrl;
		curl_setopt($this->curlObject, CURLOPT_HTTPHEADER, $this->settings['rest']['httpHeader']);
		curl_setopt($this->curlObject, CURLOPT_URL, $url);
		return curl_exec($this->curlObject);
	}

	/**
	 * TODO list caching
	 *
	 * @return array
	 */
	public function getAllLists() {
		curl_setopt($this->curlObject, CURLOPT_HTTPGET, true);
		$returnValue = $this->execute();

		$domDocument = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DOMDocument');
		$domDocument->loadXML($returnValue);

		$collections = $domDocument->getElementsByTagName('collection');
		$lists = array();
		foreach ($collections as $collection) {
			$lists[$collection->getAttribute('href')] = $collection->nodeValue;
		}

		return $lists;
	}

	/**
	 * TODO attributes caching
	 *
	 * @param $listTitle
	 * @return array
	 */
	public function getListAttributes($listTitle) {
		$this->prependUrl = $this->settings['rest']['oData']['metadata'];
		curl_setopt($this->curlObject, CURLOPT_HTTPGET, true);
		$returnValue = $this->execute();

		$domDocument = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DOMDocument');
		$domDocument->loadXML($returnValue);

		$propertyData = array();
		foreach ($domDocument->getElementsByTagName('EntityType') as $node) {

			// TODO create dynamic listname
			// <EntitySet Name="TestList" EntityType="Microsoft.SharePoint.DataService.TestListItem"/>
			// <EntityType Name="TestListItem">

			if ($listTitle . 'Item' == $node->getAttribute('Name')) {
				$propertyIterator = 0;
				foreach ($node->getElementsByTagName('Property') as $propertyNode) {
					$propertyData[$listTitle][$propertyIterator]['sharepointFieldName'] = $propertyNode->getAttribute('Name');
					$propertyData[$listTitle][$propertyIterator]['attributeType'] = $propertyNode->getAttribute('Type');
					$propertyData[$listTitle][$propertyIterator]['typo3FieldName'] = '';
					$propertyIterator++;
				}
			}
		}

		return $propertyData;
	}


}

?>