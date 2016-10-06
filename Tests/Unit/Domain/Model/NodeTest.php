<?php

namespace C1\Nodedb\Tests\Unit\Domain\Model;

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
 * Test case for class \C1\Nodedb\Domain\Model\Node.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Manuel Munz <t3dev@comuno.net>
 */
class NodeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \C1\Nodedb\Domain\Model\Node
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \C1\Nodedb\Domain\Model\Node();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getHostnameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getHostname()
		);
	}

	/**
	 * @test
	 */
	public function setHostnameForStringSetsHostname()
	{
		$this->subject->setHostname('.example.com');
		$this->assertAttributeEquals(
			'.example.com',
			'hostname',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLastSeenReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getLastSeen()
		);
	}

	/**
	 * @test
	 */
	public function setLastSeenForStringSetsLastSeen()
	{
		$this->subject->setLastSeen('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'lastSeen',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCommentReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getComment()
		);
	}

	/**
	 * @test
	 */
	public function setCommentForStringSetsComment()
	{
		$this->subject->setComment('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'comment',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIpsReturnsInitialValueFor()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getIps()
		);
	}

	/**
	 * @test
	 */
	public function setIpsForObjectStorageContainingSetsIps()
	{
		$ip = new \C1\Nodedb\Domain\Model\Node();
		$objectStorageHoldingExactlyOneIps = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneIps->attach($ip);
		$this->subject->setIps($objectStorageHoldingExactlyOneIps);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneIps,
			'ips',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addIpToObjectStorageHoldingIps()
	{
		$ip = new \C1\Nodedb\Domain\Model\Node();
		$ipsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$ipsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($ip));
		$this->inject($this->subject, 'ips', $ipsObjectStorageMock);

		$this->subject->addIp($ip);
	}

	/**
	 * @test
	 */
	public function removeIpFromObjectStorageHoldingIps()
	{
		$ip = new \C1\Nodedb\Domain\Model\Node();
		$ipsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$ipsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($ip));
		$this->inject($this->subject, 'ips', $ipsObjectStorageMock);

		$this->subject->removeIp($ip);

	}

	/**
	 * @test
	 */
	public function getOwnersReturnsInitialValueForFrontendUser()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getOwners()
		);
	}

	/**
	 * @test
	 */
	public function setOwnersForObjectStorageContainingFrontendUserSetsOwners()
	{
		$owner = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();
		$objectStorageHoldingExactlyOneOwners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneOwners->attach($owner);
		$this->subject->setOwners($objectStorageHoldingExactlyOneOwners);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneOwners,
			'owners',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addOwnerToObjectStorageHoldingOwners()
	{
		$owner = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();
		$ownersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$ownersObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($owner));
		$this->inject($this->subject, 'owners', $ownersObjectStorageMock);

		$this->subject->addOwner($owner);
	}

	/**
	 * @test
	 */
	public function removeOwnerFromObjectStorageHoldingOwners()
	{
		$owner = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();
		$ownersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$ownersObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($owner));
		$this->inject($this->subject, 'owners', $ownersObjectStorageMock);

		$this->subject->removeOwner($owner);

	}
}
