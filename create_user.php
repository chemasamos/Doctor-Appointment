<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
    echo "User Created Successfully: " . $user->id;
} catch (\Exception $e) {
    file_put_contents('user_creation_error.log', $e->getMessage());
    echo "Error logged to user_creation_error.log";
}
