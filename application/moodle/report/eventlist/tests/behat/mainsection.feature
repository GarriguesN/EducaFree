@report @report_eventlist
Feature: Page contains a list of events
  In order to find information about events
  As a user
  I need to check the page contents

  @javascript
  Scenario: Event list page is viewable and filtering works
    Given I log in as "admin"
    And I navigate to "Reports > Events list" in site administration
    And I should see "Event name"
    And I set the field "eventname" to "phase"
    And I press "filterbutton"
    And I should see "Phase switched"
    And I should not see "Comment created"
    And I press "clearbutton"
    And I set the field "eventcomponent" to "URL"
    And I press "filterbutton"
    And I should see "Course module instance list viewed"
    And I should not see "User added to cohort"
    And I press "clearbutton"
    And I set the field "eventedulevel" to "Teaching"
    And I press "filterbutton"
    And I should see "Attempt deleted"
    And I should not see "Quiz attempt abandoned"
    And I press "clearbutton"
    And I set the field "eventcrud" to "delete"
    And I press "filterbutton"
    And I should see "Cohort deleted"
    And I should not see "Cohort updated"
    And I press "clearbutton"
    And I set the field "eventcomponent" to "Assignment"
    And I set the field "eventedulevel" to "Participating"
    And I press "filterbutton"
    And I should see "A submission has been submitted"
    And I should not see "An extension has been granted"
    And I press "clearbutton"
    And I set the field "eventedulevel" to "Other"
    And I set the field "eventcrud" to "read"
    And I press "filterbutton"
    And I should see "Notes viewed"
    And I should not see "Highscores viewed"
    And I press "clearbutton"
    And I set the field "eventname" to "viewed"
    And I set the field "eventcomponent" to "Forum"
    And I set the field "eventedulevel" to "Participating"
    And I set the field "eventcrud" to "read"
    And I press "filterbutton"
    Then I should see "User report viewed"
    And I should not see "Subscribers viewed"

  @javascript
  Scenario: Details of an event are viewable
    Given I log in as "admin"
    And I navigate to "Reports > Events list" in site administration
    And I should see "Event name"
    And I follow "Blog association created"
    And I should see "Blog association created"
    And I should see "blog_association"
    And I should see "create"
    And I should see "Log store manager (tool_log)"
    And I follow "\core\event\base"
    Then I should see "core: base"
