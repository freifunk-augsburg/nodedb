<?php
namespace C1\Nodedb\Domain\Validator;
/***************************************************************
 *  Copyright notice
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

class Ipv4Validator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    /**
     * Validates if an ipv4 address is valid.
     *
     * @param mixed $ip The IP that should be validated
     * @return void
     */
    public function isValid($ip)
    {

        $filterResult = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

        if ($filterResult === false) {
            $errMsg = $this->translateErrorMessage('Invalid IPv4 Address', 'Nodedb');
            $this->addError($errMsg, 1415393454, array($ip));
        }
    }
}