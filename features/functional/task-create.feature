Feature: Create Task
    In order to create task
    As user
    I need to be able to create task

    Background:

    Scenario: Create task with subject and description
        Given I am on "task/create"
        Then I fill in "subject" with "Test subject"
        And I fill in "description" with "Test description"
        And I press "Create"

    Scenario: Create task without subject
        Given I am on "task/create"
        When I fill in "subject" with ""
        And I fill in "description" with "Test description"
        And I press "Create"
        Then I should be on "/task/create"
        And I should see "The subject field is required."

    Scenario: Check URL
        Given I am on "task/create"
        Then print current URL

    Scenario: Check Homepage
        Given I am on homepage
        Then I should see "Lar"