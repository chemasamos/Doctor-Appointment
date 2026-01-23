<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);       

test('El usuario no puede borrar su propia cuenta', function () {
    // Create a user
    $user = User::factory()->create();

    // Act as the created user
    $this->actingAs($user, 'web');

    // Send a DELETE request to the self-delete route
    $response = $this->delete(route('admin.users.destroy', $user));

    // Controller redirects back with an error message
    $response->assertStatus(302);
    $response->assertRedirect(route('admin.users.index'));
    $response->assertSessionHas('swal');

    // Assert the user is NOT deleted from the database
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});