<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//Usar la funcion para refrescar la base de datos
uses(RefreshDatabase::class);

test('un usuario no puede eliminar a si mismo',function(){
    $user = User::factory()->create();
    $this->actingAs($user, 'web');
    $response = $this->delete(route('admin.users.destroy', $user));
    $response->assertStatus(302);
    $response->assertSessionHas('swal');
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});