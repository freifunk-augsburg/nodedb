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
class AbstractModel extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
        $this->owners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * comment
     *
     * @var string
     * @validate StringLength(minimum=0, maximum=4096)
     */
    protected $comment = '';
    

    /**
     * owners
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
     */
    protected $owners = null;
    

    
    /**
     * Returns the comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * Sets the comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    
    /**
     * Adds a FrontendUser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $owner
     * @return void
     */
    public function addOwner(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $owner)
    {
        $this->owners->attach($owner);
    }
    
    /**
     * Removes a FrontendUser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $ownerToRemove The FrontendUser to be removed
     * @return void
     */
    public function removeOwner(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $ownerToRemove)
    {
        $this->owners->detach($ownerToRemove);
    }
    
    /**
     * Returns the owners
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $owners
     */
    public function getOwners()
    {
        return $this->owners;
    }
    
    /**
     * Sets the owners
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $owners
     * @return void
     */
    public function setOwners(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $owners)
    {
        $this->owners = $owners;
    }


}