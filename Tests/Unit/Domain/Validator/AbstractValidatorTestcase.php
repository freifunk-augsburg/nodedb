<?php
namespace C1\Nodedb\Domain\Validator;

    /*                                                                        *
     * This script belongs to the Extbase framework.                            *
     *                                                                        *
     * It is free software; you can redistribute it and/or modify it under    *
     * the terms of the GNU Lesser General Public License as published by the *
     * Free Software Foundation, either version 3 of the License, or (at your *
     * option) any later version.                                             *
     *                                                                        *
     * This script is distributed in the hope that it will be useful, but     *
     * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
     * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
     * General Public License for more details.                               *
     *                                                                        *
     * You should have received a copy of the GNU Lesser General Public       *
     * License along with the script.                                         *
     * If not, see http://www.gnu.org/licenses/lgpl.html                      *
     *                                                                        *
     * The TYPO3 project - inspiring people to share!                         *
     *                                                                        */
/**
 * Testcase for the Abstract Validator
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */


use TYPO3\CMS\Core\Tests\BaseTestCase;

abstract class AbstractValidatorTestcase extends BaseTestCase {

    protected $validatorClassName;

    /**
     * @var \TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface
     */
    protected $validator;

    protected $subject;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockObjectManager;

    public function setUp() {
        $this->validator = $this->getValidator();
    }

    /**
     * @param array $options
     * @return mixed
     */
    protected function getValidator($options = array()) {
        $validator = new $this->validatorClassName($options);
        return $validator;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    protected function isValid($value) {
        return $this->assertFalse($this->subject->validate($value)->hasErrors());
        //return $this->assertFalse($this->validator->validate($value)->hasErrors());
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    protected function isInvalid($value) {
        return $this->assertTrue($this->subject->validate($value)->hasErrors());
        //return $this->assertTrue($this->validator->validate($value)->hasErrors());
    }

    /**
     * @param array $options
     */
    protected function validatorOptions($options) {
        $this->validator = $this->getValidator($options);
    }

}

?>