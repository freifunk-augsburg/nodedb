<?php
namespace C1\Nodedb\Domain\Validator;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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

/*
 * borrowed from Neos: https://neos.github.io/neos/2.0/source-class-TYPO3.Neos.Validation.Validator.HostnameValidator.html
 * with some adjustments to relax the hostname check a bit
*/

class HostnameValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * @var array
     */
    protected $supportedOptions = array(
        'ignoredHostnames' => array('', 'Hostnames that are not to be validated', 'string'),
    );

    /**
     * Validates if the hostname is valid.
     *
     * @param mixed $hostname The hostname that should be validated
     * @return void
     */
    public function isValid($hostname)
    {
        $pattern = '/^[a-zA-Z0-9][a-zA-Z0-9\.\-]+[a-zA-Z0-9]$/';

        if ($this->options['ignoredHostnames']) {
            $ignoredHostnames = explode(',', $this->options['ignoredHostnames']);
            if (in_array($hostname, $ignoredHostnames)) {
                return;
            }
        }

        if (!preg_match($pattern, $hostname)) {
            //$errmsg = LocalizationUtility::translate('tx_nodedb_domain_model_node.hostname_invalid', 'Nodedb');
            $errmsg = "test";
            $this->addError($errmsg, 1415392993, array($hostname));
        }
    }
}