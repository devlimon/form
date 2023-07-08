<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FormTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    // public function testExample(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/')
    //                 ->assertSee('Laravel');
    //     });
    // }

    public function testFormSubmission()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('company_symbol', 'AAL')
                    // ->type('start_date', '2022-01-01')
                    // ->type('end_date', date('Y-m-d'))
                    ->click('#start_date')
                    ->whenAvailable('.ui-datepicker', function ($datepicker) {
                        $datepicker->click('a.ui-state-default', date('d'));
                    })
                    
                    ->click('#end_date')
                    ->whenAvailable('.ui-datepicker', function ($datepicker) {
                        $datepicker->click('a.ui-state-default', date('d'));
                    })

                    ->type('email', 'altafhossainlimon@gmail.com')
                    ->press('submit')
                    // ->dump();
                    ->assertPathIs('/form') // Update with the expected redirection path
                    ->assertSee('Data');
        });

        

    }
}
