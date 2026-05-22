<?php

use App\Models\User;
use App\Models\Application;

test('archived applications page shows soft-deleted applications', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $application->delete();

    $response = $this->actingAs($user)->get(route('archives.index'));

    $response->assertStatus(200);
    $response->assertSee($application->company_name);
});

test('archived applications page is empty when no archives', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('archives.index'));

    $response->assertStatus(200);
});

test('user can restore archived application', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $application->delete();
    $this->assertSoftDeleted($application);

    $response = $this->actingAs($user)->post(route('archives.restore', $application->id));

    $response->assertRedirect();
    $this->assertDatabaseHas('applications', [
        'id' => $application->id,
        'deleted_at' => null,
    ]);
});

test('user cannot restore another user archived application', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);
    $application->delete();

    $response = $this->actingAs($user2)->post(route('archives.restore', $application->id));

    $response->assertStatus(403);
});

test('user can force delete archived application', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $application->delete();

    $response = $this->actingAs($user)->delete(route('archives.forceDelete', $application->id));

    $response->assertRedirect();
    $this->assertDatabaseMissing('applications', ['id' => $application->id]);
});

test('user cannot force delete another user archived application', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);
    $application->delete();

    $response = $this->actingAs($user2)->delete(route('archives.forceDelete', $application->id));

    $response->assertStatus(403);
});

test('unauthenticated user cannot view archives', function () {
    $response = $this->get(route('archives.index'));
    $response->assertRedirect(route('login'));
});

test('unauthenticated user cannot restore archived application', function () {
    $application = Application::factory()->create();
    $application->delete();

    $response = $this->post(route('archives.restore', $application->id));
    $response->assertRedirect(route('login'));
});

test('unauthenticated user cannot force delete archived application', function () {
    $application = Application::factory()->create();
    $application->delete();

    $response = $this->delete(route('archives.forceDelete', $application->id));
    $response->assertRedirect(route('login'));
});

test('restored application appears in active list', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $application->delete();

    $this->actingAs($user)->post(route('archives.restore', $application->id));

    $response = $this->actingAs($user)->get(route('applications.index'));
    $response->assertSee($application->company_name);
});
