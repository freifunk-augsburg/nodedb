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

/**
 * Node
 */
class Node extends \C1\Nodedb\Domain\Model\AbstractModel
{

    /**
     * hostname
     *
     * @var string
     * @validate NotEmpty
     * @validate StringLength(minimum=2, maximum=200)
     * @validate \C1\Nodedb\Domain\Validator\UniqueValidator(repository='C1\Nodedb\Domain\Repository\NodeRepository', property='hostname')
     * @validate \C1\Nodedb\Domain\Validator\HostnameValidator()
     */
    protected $hostname = '';


    /**
     * lastSeen
     *
     * @var int
     */
    protected $lastSeen = '';
    

    /**
     * ips
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Ip4>
     */
    protected $ips = null;


    /**
     * Adds ips object storage
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        parent::initStorageObjects();
        $this->ips = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the hostname
     *
     * @return string $hostname
     */
    public function getHostname()
    {
        return $this->hostname;
    }
    
    /**
     * Sets the hostname
     *
     * @param string $hostname
     * @return void
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }
    
    /**
     * Returns the lastSeen
     *
     * @return string $lastSeen
     */
    public function getLastSeen()
    {
        return $this->lastSeen;
    }
    
    /**
     * Sets the lastSeen
     *
     * @param string $lastSeen
     * @return void
     */
    public function setLastSeen($lastSeen)
    {
        $this->lastSeen = $lastSeen;
    }

    /**
     * Adds a IpNode
     *
     * @param  $ip
     * @return void
     */
    public function addIp($ip)
    {
        $this->ips->attach($ip);
    }
    
    /**
     * Removes a IpNode
     *
     * @param  $ipToRemove The  to be removed
     * @return void
     */
    public function removeIp($ipToRemove)
    {
        $this->ips->detach($ipToRemove);
    }
    
    /**
     * Returns the ips
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Ip4> ips
     */
    public function getIps()
    {
        return $this->ips;
    }
    
    /**
     * Sets the ips
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Ip4> $ips
     * @return void
     */
    public function setIps(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ips)
    {
        $this->ips = $ips;
    }

}