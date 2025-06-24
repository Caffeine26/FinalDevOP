<?php

use App\Models\Terrain;
use App\Models\User;

test('can view terrain listing', function () {
    $response = $this->get('/terrains');
    $response->assertStatus(200);
});

test('can create new terrain', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/terrains', [
            'title' => 'Test Terrain',
            'location' => 'Phnom Penh',
            'price_per_day' => 50.00
        ]);
        
    $response->assertStatus(201);
    $this->assertDatabaseHas('terrains', ['title' => 'Test Terrain']);
});

test('can view single terrain', function () {
    $terrain = Terrain::factory()->create();
    $response = $this->get("/terrains/{$terrain->id}");
    $response->assertStatus(200);
});

test('can update terrain', function () {
    $user = User::factory()->create();
    $terrain = Terrain::factory()->create(['owner_id' => $user->id]);
    
    $response = $this->actingAs($user)
        ->put("/terrains/{$terrain->id}", [
            'title' => 'Updated Title'
        ]);
        
    $response->assertStatus(200);
    $this->assertEquals('Updated Title', $terrain->fresh()->title);
});

test('can delete terrain', function () {
    $user = User::factory()->create();
    $terrain = Terrain::factory()->create(['owner_id' => $user->id]);
    
    $response = $this->actingAs($user)
        ->delete("/terrains/{$terrain->id}");
        
    $response->assertStatus(204);
    $this->assertSoftDeleted($terrain);
});