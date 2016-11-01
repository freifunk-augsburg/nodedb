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
 * Test case for class C1\Nodedb\Controller\Ip4Controller.
 *
 * @author Manuel Munz <t3dev@comuno.net>
 */
class Ip4ControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \C1\Nodedb\Controller\Ip4Controller
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('C1\\Nodedb\\Controller\\Ip4Controller', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

    /**
     * Unset all additional properties of test classes to help PHP
     * garbage collection. This reduces memory footprint with lots
     * of tests.
     *
     * @throws \RuntimeException
     * @return void
     */
	public function tearDown()
	{
		unset($this->subject);
        parent::tearDown();
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllIpsFromRepositoryAndAssignsThemToView()
	{

		$allIps = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$ip4Repository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\IpRepository', array('findAll'), array(), '', FALSE);
		$ip4Repository->expects($this->once())->method('findAll')->will($this->returnValue($allIps));
		$this->inject($this->subject, 'ip4Repository', $ip4Repository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('ips', $allIps);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenIpToView()
	{
		$ip = new \C1\Nodedb\Domain\Model\Ip4();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('ip', $ip);

		$this->subject->showAction($ip);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenIpToIpRepository()
	{
		$ip = new \C1\Nodedb\Domain\Model\Ip4();

		$ip4Repository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\IpRepository', array('add'), array(), '', FALSE);
		$ip4Repository->expects($this->once())->method('add')->with($ip);
		$this->inject($this->subject, 'ip4Repository', $ip4Repository);

		$this->subject->createAction($ip);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenIpToView()
	{
		$ip = new \C1\Nodedb\Domain\Model\Ip4();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('ip', $ip);

		$this->subject->editAction($ip);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenIpInIpRepository()
	{
		$ip = new \C1\Nodedb\Domain\Model\Ip4();

		$ip4Repository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\IpRepository', array('update'), array(), '', FALSE);
		$ip4Repository->expects($this->once())->method('update')->with($ip);
		$this->inject($this->subject, 'ip4Repository', $ip4Repository);

		$this->subject->updateAction($ip);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenIpFromIpRepository()
	{
		$ip = new \C1\Nodedb\Domain\Model\Ip4();

		$ip4Repository = $this->getMock('C1\\Nodedb\\Domain\\Repository\\IpRepository', array('remove'), array(), '', FALSE);
		$ip4Repository->expects($this->once())->method('remove')->with($ip);
		$this->inject($this->subject, 'ip4Repository', $ip4Repository);

		$this->subject->deleteAction($ip);
	}
}
