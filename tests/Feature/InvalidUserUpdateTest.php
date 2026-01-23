<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuario autenticado no puede actualizar otro usuario con datos invalidos', function () {
    // 1. Setup - Create Role (needed for validation rule exists:roles,id)
    $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);

    // 2. Create Acting User (Admin)
    $admin = User::factory()->create();
    
    // 3. Create Target User
    $targetUser = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    // 4. Define Invalid Data (Empty name, invalid email)
    // We provide other required fields correctly to ensure the error is specifically about name/email
    $invalidData = [
        'name' => '', // Invalid: required
        'email' => 'not-an-email', // Invalid: email format
        'phone' => '1234567890',
        'address' => 'Valid Address',
        'id_number' => '123456789',
        'role_id' => $role->id, // Valid role
    ];

    // 5. Attempt Update acting as Admin
    $response = $this->actingAs($admin, 'web')
                     ->putJson(route('admin.users.update', $targetUser), $invalidData);

    // 6. Assertions
    $response->assertStatus(422)
             ->assertJsonValidationErrors(['name', 'email']);

    // Verify DB integrity: Data should still be the original
    $this->assertDatabaseHas('users', [
        'id' => $targetUser->id,
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);
});
