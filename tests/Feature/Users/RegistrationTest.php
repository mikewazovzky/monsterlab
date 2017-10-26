<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\TestCase;
use App\Mail\ConfirmEmailRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function confirmation_email_is_sent_upon_user_registration()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        // Mail::assertSent(ConfirmEmailRequest::class);
        Mail::assertQueued(ConfirmEmailRequest::class);
    }

    /** @test */
    public function confirmation_email_can_be_sent_upon_user_request()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        Mail::assertQueued(ConfirmEmailRequest::class);

        $this->get(route('register.send'))->assertStatus(302);

        Mail::assertQueued(ConfirmEmailRequest::class);
    }

    /** @test */
    public function user_can_confirm_email_address()
    {
        Mail::fake();

        $this->withoutExceptionHandling();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $user = User::whereName('John')->first();

        $this->assertEquals('reader', $user->role);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', [ 'token' => $user->confirmation_token]))
            ->assertRedirect(route('login'))
            ->assertSessionHas('flash');

        tap($user->fresh(), function ($user) {
            $this->assertEquals('writer', $user->role);
            $this->assertNull($user->confirmation_token);
        });
    }

    /** @test */
    public function confirmation_fails_if_invalid_token_provided()
    {
        $this->get(route('register.confirm', [ 'token' => 'invalid_token']))
            ->assertRedirect(route('main'))
            ->assertSessionHas('flash', [
                'level' => 'danger',
                'body' => 'Unknown token.'
            ]);
    }
}
