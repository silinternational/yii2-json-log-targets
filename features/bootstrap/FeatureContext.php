<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have the following log message data:
     */
    public function iHaveTheFollowingLogMessageData(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given I provide a prefix of :arg1
     */
    public function iProvideAPrefixOf($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I call the static helper function to format that as JSON
     */
    public function iCallTheStaticHelperFunctionToFormatThatAsJson()
    {
        throw new PendingException();
    }

    /**
     * @Then the result should be a JSON string
     */
    public function theResultShouldBeAJsonString()
    {
        throw new PendingException();
    }

    /**
     * @Then the result should have a :arg1 of :arg2
     */
    public function theResultShouldHaveAOf($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When I format that message and prefix as JSON
     */
    public function iFormatThatMessageAndPrefixAsJson()
    {
        throw new PendingException();
    }

    /**
     * @Given I provide the following prefix:
     */
    public function iProvideTheFollowingPrefix(PyStringNode $string)
    {
        throw new PendingException();
    }

    /**
     * @Then the result should have a :arg1 with an :arg2 of :arg3
     */
    public function theResultShouldHaveAWithAnOf($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Given I do not provide a prefix
     */
    public function iDoNotProvideAPrefix()
    {
        throw new PendingException();
    }

    /**
     * @Then the result should not have a :arg1
     */
    public function theResultShouldNotHaveA($arg1)
    {
        throw new PendingException();
    }
}
