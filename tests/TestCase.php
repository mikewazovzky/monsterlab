<?php

namespace Tests;

use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();
        Mail::fake();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');
        $this->be($user);
        return $this;
    }
}
