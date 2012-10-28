<?php
namespace aijko\SharepointConnector\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Erik Frister <erik.frister@aijko.de>, aijko GmbH
 *  Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
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
 *
 *
 * @package sharepoint_connector
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ListMapController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * listMapRepository
	 *
	 * @var aijko\SharepointConnector\Domain\Repository\ListMapRepository
	 * @inject
	 */
	protected $listMapRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$listMaps = $this->listMapRepository->findAll();
		$this->view->assign('listMaps', $listMaps);
	}

	/**
	 * action new
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\ListMap $newListMap
	 * @dontvalidate $newListMap
	 * @return void
	 */
	public function newAction(\aijko\SharepointConnector\Domain\Model\ListMap $newListMap = NULL) {
		$this->view->assign('newListMap', $newListMap);
	}

	/**
	 * action create
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\ListMap $newListMap
	 * @return void
	 */
	public function createAction(\aijko\SharepointConnector\Domain\Model\ListMap $newListMap) {
		$this->listMapRepository->add($newListMap);
		$this->flashMessageContainer->add('Your new ListMap was created.');
		$this->redirect('list');
	}

	/**
	 * action
	 *
	 * @return void
	 */
	public function Action() {

	}

}
?>