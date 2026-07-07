<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function actingUser(string $role): array
{
    $user = User::create([
        'name' => ucfirst($role),
        'email' => $role.'@example.com',
        'role' => $role,
        'password' => Hash::make('rahasia'),
    ]);

    return [$user, $user->createToken('api-token')->plainTextToken];
}

it('user biasa dilarang menghapus data (403)', function () {
    [, $token] = actingUser('user');
    $category = Category::create(['name' => 'Novel']);

    $this->withHeader('Authorization', "Bearer {$token}")
        ->deleteJson("/api/categories/{$category->id}")
        ->assertStatus(403);
});

it('admin boleh menghapus data', function () {
    [, $token] = actingUser('admin');
    $category = Category::create(['name' => 'Novel']);

    $this->withHeader('Authorization', "Bearer {$token}")
        ->deleteJson("/api/categories/{$category->id}")
        ->assertOk();

    expect(Category::find($category->id))->toBeNull();
});
