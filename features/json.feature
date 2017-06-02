
Feature: Converting log data to JSON

  Scenario: Calling the static helper function
    Given I have the following log message data:
      | message | level | category |
      | Static  | 1     | app      |
      And I provide a prefix of 'abc123'
    When I call the static helper function to format that as JSON
    Then the result should be a JSON string
      And the result should have a "message" of "Test"
      And the result should have a "level" of "error"
      And the result should have a "category" of "app"
      And the result should have a "prefix" of "abc123"

  Scenario: Log message with a (non-JSON) string prefix
    Given I have the following log message data:
      | message | level | category |
      | Test    | 1     | app      |
      And I provide a prefix of 'abc123'
    When I format that message and prefix as JSON
    Then the result should be a JSON string
      And the result should have a "message" of "Test"
      And the result should have a "level" of "error"
      And the result should have a "category" of "app"
      And the result should have a "prefix" of "abc123"

  Scenario: Log message with a JSON prefix
    Given I have the following log message data:
      | message | level | category |
      | Test    | 1     | app      |
      And I provide the following prefix:
        """
        {"a": "First", "b": "Second"}
        """
    When I format that message and prefix as JSON
    Then the result should be a JSON string
      And the result should have a "message" of "Test"
      And the result should have a "level" of "error"
      And the result should have a "category" of "app"
      And the result should have a "prefix" with an "a" of "First"
      And the result should have a "prefix" with an "b" of "Second"

  Scenario: Log message with no prefix
    Given I have the following log message data:
      | message | level | category |
      | Test    | 1     | app      |
      And I do not provide a prefix
    When I format that message and prefix as JSON
    Then the result should be a JSON string
      And the result should have a "message" of "Test"
      And the result should have a "level" of "error"
      And the result should have a "category" of "app"
      And the result should not have a "prefix"

  Scenario: Multiline log message
    Given I have the following log message data:
      | message | level | category |
      | Test    | 1     | app      |
      And I do not provide a prefix
    When I format that message and prefix as JSON
    Then the result should be a JSON string
      And the result should have a "message" of "Test"
      And the result should have a "level" of "error"
      And the result should have a "category" of "app"
      And the result should not have a "prefix"
