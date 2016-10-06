<?php

namespace C1\Nodedb\Domain\Validator;

require_once __DIR__ . '/AbstractValidatorTestcase.php';

/**
 * Testcase for the hostname validator
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */

class HostnameValidatorTest extends AbstractValidatorTestCase {

    protected $validatorClassName = 'C1\\Nodedb\\Domain\\Validator\\HostnameValidator';

    /**
     * @test
     */
    public function hostnameValidatorShouldValidateString() {
        $this->assertFalse($this->validator->validate('dev.foo.bar')->hasErrors());
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfNumberIsGiven() {
        $this->assertTrue($this->validator->validate(42)->hasErrors());
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfHostnameStartsWithDot() {
        $this->assertTrue($this->validator->validate('.foo.com')->hasErrors());
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfHostnameEndsWithDot() {
        $this->assertTrue($this->validator->validate('foo.com.')->hasErrors());
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfHostnameHasUnderscore() {
        $this->assertTrue($this->validator->validate('hallo_welt.com')->hasErrors());
    }
}
