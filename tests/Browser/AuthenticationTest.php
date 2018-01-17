<?php
/**
 * AuthenticationTest.php
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

use App\User;

/**
 * Class for testing Authentication
 * 
 * @testdox Authentication
 * 
 * @category Category
 * @package  Package
 * @author   CabasaTechnologies <info@cabasatech.com>
 * @license  License http://license.local
 * @link     Link
 */
class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Sign up user
     *
     * @testdox Sign up user
     * 
     * @return void
     */
    public function testRegister()
    {
        $this->browse(
            function ($browser) {
                $browser->visit('/register');
            }
        );

        $this->assertTrue(true);
    }

    /**
     * Log in user
     * 
     * @testdox Log in user
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(
            function ($browser) {
                $browser->visit('/login');
            }
        );

        $this->assertTrue(true);
    }
}