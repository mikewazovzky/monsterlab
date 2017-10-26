<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unautorized_user_can_not_update_profile_data()
    {
        $this->signIn();
        $user = create('App\User');

        $this->patchJson(route('user.update.role', $user), [])->assertStatus(403);
        $this->patchJson(route('user.update.data', $user), [])->assertStatus(403);
        $this->patchJson(route('user.update.password', $user), [])->assertStatus(403);
    }

    /** @test */
    public function non_admin_can_not_update_user_role()
    {
        $this->signIn($user = create('App\User'));

        $this->patchJson(route('user.update.role', $user), [])
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_may_update_user_role()
    {
        // only admin can change user role
        $this->signIn(create('App\User', ['role' => 'admin']));

        $user = create('App\User', ['role' => 'reader']);
        $updatedRole = 'writer';

        $this->patchJson(route('user.update.role', $user), ['role' => $updatedRole])
            ->assertStatus(200);

        $this->assertEquals($updatedRole, $user->fresh()->role);
    }

    /** @test */
    public function authorized_user_may_update_name_and_email_and_country()
    {
        // user can change his name, email, and country
        $this->signIn($user = create('App\User'));
        $updatedName = 'Updated Name';
        $updatedEmail = 'updated@email.com';
        $updatedCountry = 'Russia';

        $this->patchJson(route('user.update.data', $user), [
            'name' => $updatedName,
            'email' => $updatedEmail,
            'country' => $updatedCountry,
        ])->assertStatus(200);

        tap($user->fresh(), function($user) use ($updatedName, $updatedEmail, $updatedCountry) {
            $this->assertEquals($updatedName, $user->name);
            $this->assertEquals($updatedEmail, $user->email);
            $this->assertEquals($updatedCountry, $user->country);
        });
    }

    /** @test */
    public function authorized_user_may_update_password()
    {
        // user can change his password
        $originalPassword = 'Original Password';
        $updatedPassword = 'Updated Password';
        $user = create('App\User', ['password' => bcrypt($originalPassword)]);
        $this->signIn($user);

        $this->patchJson(route('user.update.password', $user), [
            'password' => $updatedPassword,
            'password_confirmation' => $updatedPassword,
        ])->assertStatus(200);

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

        $response = $this->patchJson(route('user.update.role', $user), ['role' => $updatedRole])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['role']));

        // Role must be one of ['admin', 'reader', 'writer']
        $updatedRole = 'spammer';

        $response = $this->patchJson(route('user.update.role', $user), ['role' => $updatedRole])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['role']));

        $this->assertEquals($role, $user->fresh()->role);
    }

    /** @test */
    public function valid_name_should_be_provided()
    {
        // Name may not be empty
        $name = 'Original Name';
        $user = create('App\User', ['name' => $name]);
        $this->signIn($user);

        $response = $this->patchJson(route('user.update.data', $user), [
            'name' => null,
        ])->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['name']));

        // Name must be unique
        $newName = 'New Name';
        $newUser = create('App\User', ['name' => $newName]);

        $response = $this->patchJson(route('user.update.data', $user), [
            'name' => $newName,
        ])->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['name']));

        $this->assertEquals($name, $user->fresh()->name);

        // Unique validation rule should not be applied to update user request
        $this->signIn($newUser);
        $newName = 'New Name';
        $newEmail = 'new@email.com';

        $response = $this->patchJson(route('user.update.data', $newUser), [
            'name' => $newName,
            'email' => $newEmail,
            'country' => 'USA',
        ])->assertStatus(200)->json();

        $this->assertFalse(isset($response['errors']));

        $this->assertEquals($newEmail, $newUser->fresh()->email);
    }

    /** @test */
    public function valid_email_should_be_provided()
    {
        $email = 'original@email.com';
        $user = create('App\User', ['email' => $email]);
        $this->signIn($user);

        // Email may not be empty
        $response = $this->patchJson(route('user.update.data', $user), ['email' => null])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['email']));

        // Email must be valid e-mail address
        $response = $this->patchJson(route('user.update.data', $user), ['email' => 'not-an-email'])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['email']));

        // Email must be unique
        $newUser = create('App\User', ['email' => $newEmail = 'new@email.com']);

        $response = $this->patchJson(route('user.update.data', $user), ['email' => $newEmail])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['email']));

        $this->assertEquals($email, $user->fresh()->email);

        // Unique validation rule should not be applied to update user request
        $this->signIn($newUser);
        $response = $this->patchJson(route('user.update.data', $newUser), [
            'name' => 'New Name',
            'email' => $newEmail,
            'country' => 'USA',
        ])->assertStatus(200)->json();

        $this->assertFalse(isset($response['errors']));

        $this->assertEquals($newEmail, $newUser->fresh()->email);
    }

    /** @test */
    public function valid_country_should_be_provided()
    {
        $country = 'SomeNonexistingCountry';
        $user = create('App\User', ['country' => $country]);
        $this->signIn($user);

        // Country may not be empty
        $response = $this->patchJson(route('user.update.data', $user), ['country' => null])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['country']));

        // Country must be in the list of available countries
        $response = $this->patchJson(route('user.update.data', $user), ['country' => $country])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['country']));

        $this->assertEquals($country, $user->fresh()->country);
    }

    /** @test */
    public function valid_password_should_be_provided()
    {
        $originalPassword = 'Original Password';
        $user = create('App\User', ['password' => $originalPassword]);
        $this->signIn($user);

        // Password may not be empty
        $response = $this->patchJson(route('user.update.password', $user), ['password' => null, 'password_confirmation' => null])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['password']));

        // Password must be confirmed
        $response = $this->patchJson(route('user.update.password', $user), ['password' => 'New Password'])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['password']));

        // Password must be longer then 6 symbols
        $response = $this->patchJson(route('user.update.password', $user), ['password' => 'New'])
            ->assertStatus(422)->json();

        $this->assertTrue(isset($response['errors']['password']));

        $this->assertEquals($originalPassword, $user->fresh()->password);
    }
}
