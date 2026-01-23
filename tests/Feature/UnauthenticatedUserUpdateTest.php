<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Un usuario no autenticado no puede actualizar un usuario', function () {
    // 1. Create a user (target to be updated)
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    // Data to attempt update
    $newData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'role_id' => 1, // Assuming role_id is required
    ];

    // 2. Attempt update WITHOUT actingAs (Unauthenticated)
    // We expect a JSON response to get a clear 401, or check for redirect if it's a web route.
    // The user requested checking for 401 or 403. 
    // If I use $this->putJson(), Laravel usually returns 401 for unauth.
    $response = $this->putJson(route('admin.users.update', $user), $newData);

    // 3. Verify status 401 or 403
    // Note: Default middleware might return 401 Unauthenticated.
    $response->assertStatus(401);

    // 4. Verify user info did NOT change
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
});
