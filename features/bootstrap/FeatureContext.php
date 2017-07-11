<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Sil\JsonLog\JsonLogHelper;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $logMessageData = [];
    private $prefix = null;
    private $result = null;
    
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
        foreach ($table as $row) {
            // See `\yii\log\Logger::messages` for order.
            $this->logMessageData[0] = $row['message'];
            $this->logMessageData[1] = $row['level'];
            $this->logMessageData[2] = $row['category'];
            break;
        }
    }

    /**
     * @Given I provide a prefix of :prefix
     */
    public function iProvideAPrefixOf($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @When I call the static helper function to format that as JSON
     */
    public function iCallTheStaticHelperFunctionToFormatThatAsJson()
    {
        $this->result = JsonLogHelper::formatAsJson(
            $this->logMessageData,
            $this->prefix
        );
    }

    /**
     * @Then the result should be a JSON string
     */
    public function theResultShouldBeAJsonString()
    {
        Assert::assertJson($this->result);
    }

    /**
     * @Then the result should have a(n) :attribute of :expectedValue
     */
    public function theResultShouldHaveAOf($attribute, $expectedValue)
    {
        $resultData = \json_decode($this->result, true);
        Assert::assertArrayHasKey($attribute, $resultData);
        Assert::assertSame($expectedValue, $resultData[$attribute], sprintf(
            'Expected %s to have a value of %s, not %s.',
            $attribute,
            var_export($expectedValue, true),
            var_export($resultData[$attribute], true)
        ));
    }

    /**
     * @When I format that message and prefix as JSON
     */
    public function iFormatThatMessageAndPrefixAsJson()
    {
        $jsonLogHelper = new JsonLogHelper();
        $this->result = $jsonLogHelper->formatMessageAndPrefix(
            $this->logMessageData,
            $this->prefix
        );
    }

    /**
     * @Given I provide the following prefix:
     */
    public function iProvideTheFollowingPrefix(PyStringNode $pyStringNode)
    {
        $this->prefix = (string)$pyStringNode;
    }

    /**
     * @Given I do not provide a prefix
     */
    public function iDoNotProvideAPrefix()
    {
        $this->prefix = null;
    }

    /**
     * @Then the result should not have a(n) :attribute
     */
    public function theResultShouldNotHaveA($attribute)
    {
        $resultData = \json_decode($this->result, true);
        Assert::assertArrayNotHasKey($attribute, $resultData);
    }
}
