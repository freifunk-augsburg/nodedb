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
 * Test case for class \C1\Nodedb\Domain\Model\Ip.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Manuel Munz <t3dev@comuno.net>
 */
class IpTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \C1\Nodedb\Domain\Model\Ip
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \C1\Nodedb\Domain\Model\Ip();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

    /**
     * @test
     */
    public function getFamilyReturnsInitialValueForInteger()
    {
        $this->assertSame(
            4,
            $this->subject->getFamily()
        );
    }

    /**
     * @test
     */
    public function setFamilyForStringSetsFamily()
    {
        $this->subject->setFamily(4);

        $this->assertAttributeEquals(
            4,
            'family',
            $this->subject
        );
    }

	/**
	 * @test
	 */
	public function getIpaddrReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getIpaddr()
		);
	}

	/**
	 * @test
	 */
	public function setIpaddrForStringSetsIpaddr()
	{
		$this->subject->setIpaddr('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'ipaddr',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNetmaskReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNetmaskForIntSetsNetmask()
	{	}

	/**
	 * @test
	 */
	public function getNodeReturnsInitialValueForNode()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getNode()
		);
	}

	/**
	 * @test
	 */
	public function setNodeForObjectStorageContainingNodeSetsNode()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();
		$objectStorageHoldingExactlyOneNode = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneNode->attach($node);
		$this->subject->setNode($objectStorageHoldingExactlyOneNode);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneNode,
			'node',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addNodeToObjectStorageHoldingNode()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();
		$nodeObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$nodeObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($node));
		$this->inject($this->subject, 'node', $nodeObjectStorageMock);

		$this->subject->addNode($node);
	}

	/**
	 * @test
	 */
	public function removeNodeFromObjectStorageHoldingNode()
	{
		$node = new \C1\Nodedb\Domain\Model\Node();
		$nodeObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$nodeObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($node));
		$this->inject($this->subject, 'node', $nodeObjectStorageMock);

		$this->subject->removeNode($node);

	}
}
