<?php
namespace C1\Nodedb\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Manuel Munz <t3dev@comuno.net>, comuno.net
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

//use C1\Nodedb\Utility\IpCalc;

/**
 * Ip
 */
class Ip4 extends AbstractModel
{
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        parent::initStorageObjects();
        $this->node = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * ipaddr
     *
     * @var string
     * @validate NotEmpty
     * @validate \C1\Nodedb\Domain\Validator\Ipv4Validator()
     * @validate \C1\Nodedb\Domain\Validator\Ipv4RangeFreeValidator()
     */
    protected $ipaddr = '';

    /**
     * networkFirst
     *
     * @var string
     */
    protected $networkFirst = NULL;

    /**
     * networkLast
     *
     * @var string
     */
    protected $networkLast = NULL;

    /**
     * netmask
     *
     * @var int
     * @validate NumberRange (minimum = 0, maximum = 32)
     */
    protected $netmask = 32;
    
    /**
     * node
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Node>
     */
    protected $node = null;

    /**
     * Returns the ipaddr
     *
     * @return string $ipaddr
     */
    public function getIpaddr()
    {
        return $this->ipaddr;
    }
    
    /**
     * Sets the ipaddr
     *
     * @param string $ipaddr
     * @return void
     */
    public function setIpaddr($ipaddr)
    {
        $this->ipaddr = $ipaddr;
    }

    /**
     * Returns the ipaddrFirst
     *
     * @return integer $ipaddrFirst
     */
    public function getNetworkFirst()
    {
        return $this->networkFirst;
    }

    /**
     * Sets the networkFirst
     *
     * @param integer $networkFirst
     * @return void
     */
    public function setNetworkFirst($networkFirst)
    {
        $this->networkFirst = $networkFirst;
    }

    /**
     * Returns the networkLast
     *
     * @return integer $networkLast
     */
    public function getNetworkLast()
    {
        return $this->networkLast;
    }

    /**
     * Sets the networkLast
     *
     * @param integer $networkLast
     * @return void
     */
    public function setNetworkLast($networkLast)
    {
        $this->networkLast = $networkLast;
    }

    /**
     * Returns the netmask
     *
     * @return int $netmask
     */
    public function getNetmask()
    {
        return $this->netmask;
    }
    
    /**
     * Sets the netmask
     *
     * @param int $netmask
     * @return void
     */
    public function setNetmask($netmask)
    {
        $this->netmask = $netmask;
    }
    
    /**
     * Adds a Node
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @return void
     */
    public function addNode(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->node->attach($node);
    }
    
    /**
     * Removes a Node
     *
     * @param \C1\Nodedb\Domain\Model\Node $nodeToRemove The Node to be removed
     * @return void
     */
    public function removeNode(\C1\Nodedb\Domain\Model\Node $nodeToRemove)
    {
        $this->node->detach($nodeToRemove);
    }
    
    /**
     * Returns the node
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Node> $node
     */
    public function getNode()
    {
        return $this->node;
    }
    
    /**
     * Sets the node
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Node> $node
     * @return void
     */
    public function setNode(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $node)
    {
        $this->node = $node;
    }

}