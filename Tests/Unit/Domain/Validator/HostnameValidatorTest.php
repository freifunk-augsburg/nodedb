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
    protected $subject;

    public function setUp() {
        parent::setUp();
        $this->subject = $this->getMock(\C1\Nodedb\Domain\Validator\HostnameValidator::class, array('translateErrorMessage'));
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldValidateString() {
        $this->isValid('dev.foo.bar');
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfNumberIsGiven() {
        $this->isInvalid(42);
        $this->isInvalid(-42);
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfHostnameStartsWithDot() {
        $this->isInvalid('.foo.com');
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfHostnameEndsWithDot() {
        $this->isInvalid('foo.com.');
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorIfHostnameHasUnderscore() {
        $this->isInvalid('hallo_Welt.com');
        $this->assertTrue($this->validator->validate('hallo_welt.com')->hasErrors());
    }
}
