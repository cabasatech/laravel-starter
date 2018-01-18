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

    /**
     * Creating task (Browser)
     * 
     * @param string $subject 
     * @param string $description 
     * 
     * @testdox      Creating task (Browser)
     * @dataProvider createTaskDataProvider
     *
     * @return void
     */
    public function testCreateTaskPage($subject, $description)
    {
        $this->browse(
            function (Browser $browser) use ($subject, $description) {
                $browser->visit('/task/create')
                    ->waitForLocation('/task/create')
                    ->type('subject', $subject)
                    ->type('description', $description)
                    ->press('Create');

                if (!empty($subject)) {
                    $browser->waitForLocation('/task/1')
                        ->assertSeeIn(
                            '.alert-success', 
                            'Task created successfully.'
                        );

                    $this->assertDatabaseHas(
                        'tasks', [
                            'subject' => $subject, 'description' => $description
                        ]
                    );
                } else {
                    $browser->assertSeeIn(
                        '.invalid-feedback',
                        'The subject field is required.'
                    );

                    $this->assertDatabaseMissing(
                        'tasks', [
                            'subject' => $subject, 'description' => $description
                        ]
                    );
                }
            }
        );
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

        if (!empty($subject)) {
            $this->assertDatabaseHas('tasks', $requestData);

            $response->assertRedirect('/task/1');
            $response->assertSessionHas('status', 'Task created successfully.');
            $response->assertSessionMissing('errors');
        } else {
            $this->assertDatabaseMissing('tasks', $requestData);

            $response->assertSessionHas('errors');
            $response->assertSessionHasErrors(['subject']);
        }
    }

    /**
     * Editing task (Browser)
     * 
     * @param string $oldSubject 
     * @param string $oldDescription 
     * @param string $subject 
     * @param string $description 
     *
     * @testdox      Editing task (Browser)
     * @dataProvider updateTaskDataProvider
     * 
     * @return void
     */
    public function testEditTaskPage(
        $oldSubject, $oldDescription, 
        $subject, $description
    ) {
        $oldData = ['subject' => $oldSubject, 'description' => $oldDescription];
        $task = factory(Task::class)->create($oldData);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $this->browse(
            function (Browser $browser) use ($task, $subject, $description) {
                $browser->visit('/task/'.$task->id.'/edit')
                    ->waitForLocation('/task/'.$task->id.'/edit')
                    ->assertInputValue('subject', $task->subject)
                    ->assertInputValue('description', $task->description)
                    ->type('subject', $subject)
                    ->type('description', $description)
                    ->press('Update');

                if (!empty($subject)) {
                    $browser->waitForLocation('/task/'.$task->id)
                        ->assertSeeIn(
                            '.alert-success', 
                            'Task updated successfully.'
                        );

                    $this->assertDatabaseHas(
                        'tasks', [
                            'id' => $task->id, 
                            'subject' => $subject, 
                            'description' => $description
                        ]
                    );
                } else {
                    $this->assertDatabaseMissing(
                        'tasks', [
                            'id' => $task->id, 
                            'subject' => $subject, 
                            'description' => $description
                        ]
                    );
                }
            }
        );
    }

    /**
     * Update an existing task to database
     * 
     * @param string $oldSubject 
     * @param string $oldDescription 
     * @param string $subject 
     * @param string $description 
     * 
     * @testdox      Update an existing task to database
     * @dataProvider updateTaskDataProvider
     * 
     * @return void
     */
    public function testUpdateTask(
        $oldSubject, $oldDescription, 
        $subject, $description
    ) {
        Session::start();

        $oldData = ['subject' => $oldSubject, 'description' => $oldDescription];
        $task = factory(Task::class)->create($oldData);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
        
        $requestData = [
            '_token' => csrf_token(),
            'subject' => $subject,
            'description' => $description
        ];

        $response = $this->call('PUT', '/task/'.$task->id, $requestData);
        unset($requestData['_token']);

        if (!empty($subject)) {
            $this->assertDatabaseHas('tasks', $requestData);

            $response->assertRedirect('/task/'.$task->id);
            $response->assertSessionHas('status', 'Task updated successfully.');
            $response->assertSessionMissing('errors');
        } else {
            $this->assertDatabaseMissing('tasks', $requestData);

            $response->assertSessionHasErrors(['subject']);
        }
    }

    /**
     * Destroying an existing Task from database
     * 
     * @param string $subject 
     * @param string $description 
     * 
     * @testdox  Destroying an existing Task from database
     * @testWith ["Subject 1", "Description 1"]
     * 
     * @return void
     */
    public function testDestroyTask($subject, $description)
    {
        $task = Task::create(
            ['subject' => $subject, 'description' => $description]
        );
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
        
        $response = $this->call(
            "GET", '/task/1/delete', [
                '_token' => csrf_token()
            ]
        );

        $this->assertSoftDeleted(
            'tasks', ['id' => $task->id]
        );

        $response->assertRedirect('/tasks');
        $response->assertSessionHas('status', 'Task deleted successfully.');
        $response->assertSessionMissing('errors');
    }

    /**
     * Provides data to update an existing Task
     * 
     * @return array
     */
    public function updateTaskDataProvider()
    {
        return [
            [
                'New subject 1', 'New description 1', 
                'Updated subject 1', 'Updated description 1'
            ],
            ['New subject 2', 'New description 2', 'Updated subject 2', null],
            ['New subject 3', 'New description 3', null, 'Updated description 3'],
            ['New subject 4', 'New description 4', null, null]
        ];
    }

    /**
     * Provides data to create a new Task
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