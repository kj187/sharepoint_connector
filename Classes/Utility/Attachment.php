<?php
namespace Aijko\SharepointConnector\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 AIJKO GmbH <info@aijko.de>
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
 * Attachment Utility
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package Aijko\SharepointConnector
 */
class Attachment {

	/**
	 * @param string $fileref
	 */
	public function download($fileref) {
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sharepoint_connector']);
		$extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::removeDotsFromTS($extensionConfiguration);

		$filePath = explode(';#', $fileref);
		$urlInfo = parse_url($extensionConfiguration['sharepointServer']['url']);
		$downloadLink = $urlInfo['scheme'] . '://' . $urlInfo['host'] . '/' . $filePath[1];
		$destinationFile = \TYPO3\CMS\Core\Utility\GeneralUtility::tempnam('spdownload_');

		$fp = fopen ($destinationFile, 'w+');
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $downloadLink );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
		curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt( $ch, CURLOPT_USERPWD, $extensionConfiguration['sharepointServer']['username'] . ':' . $extensionConfiguration['sharepointServer']['password']);
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 ); # increase timeout to download big file
		curl_setopt( $ch, CURLOPT_FILE, $fp );
		curl_exec( $ch );
		curl_close( $ch );
		fclose( $fp );

		if (file_exists($destinationFile)) {
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=" . basename($downloadLink));
			header("Content-Transfer-Encoding: binary");
			header('Content-Length: ' . filesize($destinationFile));
			ob_clean();
			flush();
			readfile($destinationFile);
		}

		\TYPO3\CMS\Core\Utility\GeneralUtility::unlink_tempfile($destinationFile);
	}

}