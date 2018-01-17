<?php
/**
 * TaskTest.php
 * 
 * PHP version 7.0.22
 * 
 * @category Category
 * @package  Package
 * @author   CabasaTechnologies <info@cabasatech.com>
 * @license  License http://license.local
 * @link     Link
 */

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Task;

/**
 * Class for testing Task
 * 
 * @testdox Task
 * 
 * @category Category
 * @package  Package
 * @author   CabasaTechnologies <info@cabasatech.com>
 * @license  License http://license.local
 * @link     Link
 */
class TaskTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $_subject, $_description;

    /**
     * Setting up test
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->_subject = 'Test subject';
        $this->_description = 'Test description';
    }

    /**
     * Creating task
     * 
     * @testdox Creating task
     *
     * @return Task
     */
    public function testCreateTask()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit('/task/create')
                    ->waitForLocation('/task/create')
                    ->type('subject', $this->_subject)
                    ->type('description', $this->_description)
                    ->press('Create')
                    ->waitForLocation('/task/1')
                    ->assertSeeIn('.alert-success', 'Task created successfully.');
            }
        );

        $this->assertDatabaseHas(
            'tasks', [
                'subject' => $this->_subject,
                'description' => $this->_description
            ]
        );

        return Task::where(
            [
                'subject' => $this->_subject,
                'description' => $this->_description
            ]
        )->first();
    }

    /**
     * Editing task
     * 
     * @param string $newSubject 
     * @param string $newDescription 
     * @param Task   $createdTask    Task created in testCreateTask().
     * 
     * @testdox      Editing task
     * @dataProvider updateTaskDataProvider
     * @depends      testCreateTask
     * 
     * @return void
     */
    public function testEditTask(
        string $newSubject, 
        string $newDescription, 
        Task $createdTask
    ) {
        $task = Task::create($createdTask->toArray());

        $this->browse(
            function (Browser $browser) use ($task, $newSubject, $newDescription) {
                $browser->visit('/task/'.$task->id.'/edit')
                    ->waitForLocation('/task/'.$task->id.'/edit')
                    ->assertInputValue('subject', $task->subject)
                    ->assertInputValue('description', $task->description)
                    ->type('subject', $newSubject)
                    ->type('description', $newDescription)
                    ->press('Update')
                    ->waitForLocation('/task/'.$task->id)
                    ->assertSeeIn('.alert-success', 'Task updated successfully.');
            }
        );

        $this->assertDatabaseHas(
            'tasks', [
                'id' => $task->id,
                'subject' => $newSubject,
                'description' => $newDescription
            ]
        );
    }

    /**
     * Provides data to update Task
     * 
     * @return array
     */
    public function updateTaskDataProvider()
    {
        return [
            ['Subject 1', 'Description 1']
        ];
    }
}