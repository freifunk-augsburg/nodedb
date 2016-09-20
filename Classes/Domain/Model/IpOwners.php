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
 * IpOwners
 */
class IpOwners extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * idNode
     *
     * @var \C1\Nodedb\Domain\Model\Node
     */
    protected $idNode = null;
    
    /**
     * idFeUser
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $idFeUser = null;
    
    /**
     * Returns the idNode
     *
     * @return \C1\Nodedb\Domain\Model\Node $idNode
     */
    public function getIdNode()
    {
        return $this->idNode;
    }
    
    /**
     * Sets the idNode
     *
     * @param \C1\Nodedb\Domain\Model\Node $idNode
     * @return void
     */
    public function setIdNode(\C1\Nodedb\Domain\Model\Node $idNode)
    {
        $this->idNode = $idNode;
    }
    
    /**
     * Returns the idFeUser
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $idFeUser
     */
    public function getIdFeUser()
    {
        return $this->idFeUser;
    }
    
    /**
     * Sets the idFeUser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $idFeUser
     * @return void
     */
    public function setIdFeUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $idFeUser)
    {
        $this->idFeUser = $idFeUser;
    }

}