<?php
namespace C1\Nodedb\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Manuel Munz <t3dev@comuno.net>, comuno.net
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
 * Test case for class C1\Nodedb\Controller\NodeController.
 *
 * @author Manuel Munz <t3dev@comuno.net>
 */
class NodeControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \C1\Nodedb\Controller\NodeController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('C1\\Nodedb\\Controller\\NodeController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllNodesFromRepositoryAndAssignsThemToView()
	{

		$allNodes = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$nodeRepository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\NodeRepository', array('findAll'), array(), '', FALSE);
		$nodeRepository->expects($this->once())->method('findAll')->will($this->returnValue($allNodes));
		$this->inject($this->subject, 'nodeRepository', $nodeRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('nodes', $allNodes);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenNodeToView()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('node', $node);

		$this->subject->showAction($node);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenNodeToNodeRepository()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();

        $nodeRepository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\NodeRepository', array('add'), array(), '', FALSE);
		$nodeRepository->expects($this->once())->method('add')->with($node);
		$this->inject($this->subject, 'nodeRepository', $nodeRepository);

		$this->subject->createAction($node);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenNodeToView()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('node', $node);

		$this->subject->editAction($node);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenNodeInNodeRepository()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();

		$nodeRepository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\NodeRepository', array('update'), array(), '', FALSE);
		$nodeRepository->expects($this->once())->method('update')->with($node);
		$this->inject($this->subject, 'nodeRepository', $nodeRepository);

		$this->subject->updateAction($node);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenNodeFromNodeRepository()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();

		$nodeRepository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\NodeRepository', array('remove'), array(), '', FALSE);
		$nodeRepository->expects($this->once())->method('remove')->with($node);
		$this->inject($this->subject, 'nodeRepository', $nodeRepository);

		$this->subject->deleteAction($node);
	}
}
