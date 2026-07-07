<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('registrasi user baru mengembalikan token', function () {
    $this->postJson('/api/register', [
        'name' => 'Andi',
        'email' => 'andi@example.com',
        'password' => 'rahasia',
        'password_confirmation' => 'rahasia',
    ])
        ->assertCreated()
        ->assertJsonPath('data.user.email', 'andi@example.com')
        ->assertJsonStructure(['data' => ['token']]);
});

it('login dengan kredensial benar berhasil', function () {
    User::create([
        'name' => 'Andi',
        'email' => 'andi@example.com',
        'role' => 'user',
        'password' => Hash::make('rahasia'),
    ]);

    $this->postJson('/api/login', [
        'email' => 'andi@example.com',
        'password' => 'rahasia',
    ])
        ->assertOk()
        ->assertJsonStructure(['data' => ['token']]);
});

it('login dengan password salah ditolak 422', function () {
    User::create([
        'name' => 'Andi',
        'email' => 'andi@example.com',
        'role' => 'user',
        'password' => Hash::make('rahasia'),
    ]);

    $this->postJson('/api/login', [
        'email' => 'andi@example.com',
        'password' => 'salah',
    ])->assertStatus(422);
});

it('mengakses route terproteksi tanpa token ditolak 401', function () {
    $this->getJson('/api/categories')->assertStatus(401);
});

it('mengakses route terproteksi dengan token berhasil', function () {
    $user = User::create([
        'name' => 'Andi',
        'email' => 'andi@example.com',
        'role' => 'user',
        'password' => Hash::make('rahasia'),
    ]);
    $token = $user->createToken('api-token')->plainTextToken;

    $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/categories')
        ->assertOk();
});
