<?php
namespace C1\Nodedb\Domain\Repository;

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
 * The repository for Ips
 */
class Ip4Repository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function countByOverlapping($firstIpInBlock, $lastIpInBlock, $uid = 0) {
        $query = $this->createQuery();

        $constraints = array();
        $constraints2 = array();

        $constraints2[] = $query->logicalAnd(
            $query->greaterThanOrEqual('network_first', $firstIpInBlock),
            $query->lessThanOrEqual('network_first', $lastIpInBlock)
        );

        $constraints2[] = $query->logicalAnd(
            $query->greaterThanOrEqual('network_last', $firstIpInBlock),
            $query->lessThanOrEqual('network_last', $lastIpInBlock)
        );



        $constraintsFirstLast = $query->logicalOr($constraints2);

        $constraints[] = $constraintsFirstLast;

        if( $uid > 0) {
            $constraints[] = $query->logicalNot($query->equals('uid', $uid));
        }

        $query->matching($query->logicalAnd($constraints));
        return $query->execute()->count();
    }
}