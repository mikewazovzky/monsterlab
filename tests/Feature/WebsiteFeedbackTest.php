<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\WebsiteFeedback;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WebsiteFeedbackTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_send_a_feedback_form()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $admin = create('App\User', ['role' => 'admin']);

        $this->post(route('feedback'), [
            'name' => 'User Name',
            'email' => 'user@email.address',
            'subj' => 'Message Subject',
            'body' => 'Message Body',
        ])->assertRedirect(route('contacts'));

        Mail::assertSent(WebsiteFeedback::class, function ($mail) use ($admin) {
            return $mail->hasTo($admin->email) ;
        });
    }
}
