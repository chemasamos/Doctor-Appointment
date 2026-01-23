<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Usuario no admin no puede eliminar otro usuario', function () {
    // 1. Setup - Create Roles
    // Ensure 'admin' role exists (just in case, though we won't give it to our actor)
    // Create a 'user' role for the non-admin
    $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

    // 2. Create "Normal" User (Actor)
    $normalUser = User::factory()->create();
    $normalUser->assignRole($userRole);

    // 3. Create Target User (Victim)
    $targetUser = User::factory()->create();

    // 4. Act as Normal User
    $response = $this->actingAs($normalUser, 'web')
                     ->delete(route('admin.users.destroy', $targetUser));

    // 5. Assertions
    // Expecting 403 Forbidden
    $response->assertStatus(403);

    // Verify target user still exists
    $this->assertDatabaseHas('users', [
        'id' => $targetUser->id,
    ]);
});
