<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_can_not_view_user_profiles()
    {
        $user = create('App\User');

        $this->get(route('profiles.show', $user))->assertRedirect(route('login'));
    }

    /** @test */
    public function unautorized_user_can_not_update_user_profiles()
    {
        $this->signIn();
        $user = create('App\User');

        $this->patch(route('user.update.role', $user), [])->assertStatus(403);
        $this->patch(route('user.update.data', $user), [])->assertStatus(403);
        $this->patch(route('user.update.password', $user), [])->assertStatus(403);
    }

    /** @test */
    public function only_admin_can_update_user_role()
    {
        $this->signIn($user = create('App\User'));

        $this->patch(route('user.update.role', $user), [])->assertStatus(403);
    }

    /** @test */
    public function authenticated_user_can_see_user_profiles()
    {
        $this->signIn();

        $user = create('App\User');

        $this->get(route('profiles.show', $user))
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    /** @test */
    public function authorized_user_can_update_user_role()
    {
        // only admin can change user role
        $this->signIn(create('App\User', ['role' => 'admin']));

        $user = create('App\User', ['role' => 'reader']);
        $updatedRole = 'writer';

        $this->patch(route('user.update.role', $user), ['role' => $updatedRole]);

        $this->assertEquals($updatedRole, $user->fresh()->role);
    }

    /** @test */
    public function authorized_user_can_update_name_and_email_country()
    {
        // user can change his name and email
        $this->signIn($user = create('App\User'));
        $updatedName = 'Updated Name';
        $updatedEmail = 'updated@email.com';
        $updatedCountry = 'Russia';

        $this->patch(route('user.update.data', $user), [
            'name' => $updatedName,
            'email' => $updatedEmail,
            'country' => $updatedCountry,
        ]);

        tap($user->fresh(), function($user) use ($updatedName, $updatedEmail) {
            $this->assertEquals($updatedName, $user->name);
            $this->assertEquals($updatedEmail, $user->email);
        });
    }

    /** @test */
    public function authorized_user_can_update_password()
    {
        // user can change his password
        $originalPassword = 'Original Password';
        $updatedPassword = 'Updated Password';
        $user = create('App\User', ['password' => bcrypt($originalPassword)]);
        $this->signIn($user);

        $this->patch(route('user.update.password', $user), [
            'password' => $updatedPassword,
            'password_confirmation' => $updatedPassword,
        ]);

        $this->assertTrue(Hash::check($updatedPassword, $user->fresh()->password));
    }

    /** @test */
    public function valid_role_should_be_provided()
    {
        $this->signIn(create('App\User', ['role' => 'admin']));

        $role = 'reader';
        $user = create('App\User', ['role' => $role]);

        // Role may not be empty
        $updatedRole = null;

        $this->patch(route('user.update.role', $user), ['role' => $updatedRole])
            ->assertSessionHasErrors('role');

        // Role must be one of ['admin', 'reader', 'writer']
        $updatedRole = 'spammer';

        $this->patch(route('user.update.role', $user), ['role' => $updatedRole])
            ->assertSessionHasErrors('role');

        $this->assertEquals($role, $user->fresh()->role);
    }

    /** @test */
    public function valid_name_should_be_provided()
    {
        // Name may not be empty
        $name = 'Original Name';
        $user = create('App\User', ['name' => $name]);
        $this->signIn($user);

        $this->patch(route('user.update.data', $user), ['name' => null])
            ->assertSessionHasErrors('name');

        // Name must be unique
        $newUser = create('App\User', ['name' => $newName = 'New Name']);

        $this->patch(route('user.update.data', $user), ['name' => $newName])
            ->assertSessionHasErrors('name');

        $this->assertEquals($name, $user->fresh()->name);

        // Unique constrain should not be applied to update user request
        $this->patch(route('user.update.data', $newUser), ['name' => $newName, 'email' => 'new@email.com'])
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function valid_email_should_be_provided()
    {
        $email = 'original@email.com';
        $user = create('App\User', ['email' => $email]);
        $this->signIn($user);

        // Email may not be empty
        $this->patch(route('user.update.data', $user), ['email' => null])
            ->assertSessionHasErrors('email');

        // Email must be valid e-mail address
        $this->patch(route('user.update.data', $user), ['email' => 'not-an-email'])
            ->assertSessionHasErrors('email');

        // Email must be unique
        $newUser = create('App\User', ['email' => $newEmail = 'new@email.com']);

        $this->patch(route('user.update.data', $user), ['email' => $newEmail])
            ->assertSessionHasErrors('email');

        $this->assertEquals($email, $user->fresh()->email);

        // Unique constrain should not be applied to update user request
        $this->patch(route('user.update.data', $newUser), ['name' => 'New Name', 'email' => $newEmail])
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function valid_country_should_be_provided()
    {
        $country = 'SomeNonexistingCountry';
        $user = create('App\User', ['country' => $country]);
        $this->signIn($user);

        // Country may not be empty
        $this->patch(route('user.update.data', $user), ['country' => null])
            ->assertSessionHasErrors('country');

        // Contry must be in the list of available countries
        $this->patch(route('user.update.data', $user), ['country' => $country])
            ->assertSessionHasErrors('country');

        $this->assertEquals($country, $user->fresh()->country);
    }

    /** @test */
    public function valid_password_should_be_provided()
    {
        $originalPassword = 'Original Password';
        $user = create('App\User', ['password' => $originalPassword]);
        $this->signIn($user);

        // Password may not be empty
        $this->patch(route('user.update.password', $user), ['password' => null, 'password_confirmation' => null])
            ->assertSessionHasErrors('password');

        // Password must be confirmed
        $this->patch(route('user.update.password', $user), ['password' => 'New Password'])
            ->assertSessionHasErrors('password');

        // Password must be longer then 6 symbols
        $this->patch(route('user.update.password', $user), ['password' => 'New'])
            ->assertSessionHasErrors('password');

        $this->assertEquals($originalPassword, $user->fresh()->password);
    }
}
