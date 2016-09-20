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
 * Ip
 */
class Ip extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * ip4addr
     *
     * @var string
     */
    protected $ip4addr = '';
    
    /**
     * netmask
     *
     * @var int
     */
    protected $netmask = 0;
    
    /**
     * Returns the ip4addr
     *
     * @return string $ip4addr
     */
    public function getIp4addr()
    {
        return $this->ip4addr;
    }
    
    /**
     * Sets the ip4addr
     *
     * @param string $ip4addr
     * @return void
     */
    public function setIp4addr($ip4addr)
    {
        $this->ip4addr = $ip4addr;
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

}