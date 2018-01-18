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

use DB;
use Session;

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
     * Creating task (Browser)
     * 
     * @testdox Creating task (Browser)
     *
     * @return Task
     */
    public function testCreateTaskPage()
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

        $task = Task::where(
            [
                'subject' => $this->_subject,
                'description' => $this->_description
            ]
        );

        $this->assertTrue($task->exists());

        return $task->first();
    }

    /**
     * Store task to database
     * 
     * @param string $subject 
     * @param string $description 
     * 
     * @testdox      Store task to database
     * @dataProvider createTaskDataProvider
     * 
     * @return void
     */
    public function testStoreTask($subject, $description)
    {
        Session::start();

        $requestData = [
            '_token' => csrf_token(),
            'subject' => $subject,
            'description' => $description
        ];

        $response = $this->call('POST', '/task', $requestData);
        unset($requestData['_token']);

        // if (!empty($subject) && !empty($description)) {
        //     $response->assertRedirect('/task/1');
        //     $response->assertSessionHas('status', 'Task created successfully.');
        //     $response->assertSessionMissing('errors');

        //     $this->assertDatabaseHas('tasks', $requestData);
        // } elseif (!empty($subject) && empty($description)) {
        //     $response->assertRedirect('/task/1');
        //     $response->assertSessionHas('status', 'Task created successfully.');
        //     $response->assertSessionMissing('errors');

        //     $this->assertDatabaseHas('tasks', $requestData);
        // } elseif (empty($subject) && !empty($description)) {
        //     $response->assertSessionHasErrors(['subject']);
            
        //     $this->assertDatabaseMissing('tasks', $requestData);
        // } else {
        //     $response->assertSessionHasErrors(['subject']);

        //     $this->assertDatabaseMissing('tasks', $requestData);
        // }

        if (!empty($subject)) {
            $response->assertRedirect('/task/1');
            $response->assertSessionHas('status', 'Task created successfully.');
            $response->assertSessionMissing('errors');

            $this->assertDatabaseHas('tasks', $requestData);
        } else {
            $response->assertSessionHasErrors(['subject']);

            $this->assertDatabaseMissing('tasks', $requestData);
        }
    }

    /**
     * Editing task (Browser)
     * 
     * @param string $newSubject 
     * @param string $newDescription 
     * @param Task   $createdTask    Task created in testCreateTaskPage()
     * 
     * @testdox      Editing task (Browser)
     * @dataProvider updateTaskDataProvider
     * @depends      testCreateTaskPage
     * 
     * @return void
     */
    public function testEditTaskPage(
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
     * Deleting task
     * 
     * @param Task $createdTask Task created in testCreateTask().
     * 
     * @testdox Deleting task
     * @depends testCreateTask
     * 
     * @return void
     */
    // public function testDeleteTask(Task $createdTask)
    // {
    //     $task = Task::create($createdTask->toArray());
        
    //     $task->delete();

    //     $this->assertSoftDeleted(
    //         'tasks', ['subject' => $task->toArray()]
    //     );
    // }

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

    /**
     * Provides data to create Task
     * 
     * @return array
     */
    public function createTaskDataProvider()
    {
        return [
            ['New subject 1', 'New description 1'],
            ['New subject 2', null],
            [null, 'New description 3'],
            [null, null]
        ];
    }
}