<?php

use App\Models\User;

test('simple example', function () {
    expect(true)->toBeTrue();
    $user = User::factory()->create();
    expect($user)->toBeInstanceOf(User::class);
});
