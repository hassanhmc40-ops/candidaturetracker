<?php

use App\Models\User;
use App\Models\Application;
use App\Models\Interview;

test('authenticated user can view applications index', function () {
    $user = User::factory()->create();
    Application::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('applications.index'));

    $response->assertStatus(200);
    $response->assertViewHas('applications');
});

test('unauthenticated user cannot view applications index', function () {
    $response = $this->get(route('applications.index'));
    $response->assertRedirect(route('login'));
});

test('user can create an application', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('applications.store'), [
        'company_name' => 'Tech Corp',
        'job_title' => 'Laravel Developer',
        'status' => 'en_attente',
        'priority' => 'haute',
        'application_date' => now()->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('applications', [
        'user_id' => $user->id,
        'company_name' => 'Tech Corp',
        'job_title' => 'Laravel Developer',
    ]);
});

test('application creation fails with invalid data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('applications.store'), [
        'company_name' => '',
        'job_title' => '',
        'status' => 'invalid_status',
        'priority' => 'invalid_priority',
        'application_date' => 'not-a-date',
    ]);

    $response->assertSessionHasErrors(['company_name', 'job_title', 'status', 'priority', 'application_date']);
});

test('user can view own application', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('applications.show', $application));

    $response->assertStatus(200);
    $response->assertSee($application->company_name);
});

test('user cannot view another user application', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);

    $response = $this->actingAs($user2)->get(route('applications.show', $application));

    $response->assertStatus(403);
});

test('user can edit own application', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create([
        'user_id' => $user->id,
        'company_name' => 'Old Company',
    ]);

    $response = $this->actingAs($user)->patch(route('applications.update', $application), [
        'company_name' => 'New Company',
        'job_title' => $application->job_title,
        'status' => $application->status,
        'priority' => $application->priority,
        'application_date' => $application->application_date->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('applications', [
        'id' => $application->id,
        'company_name' => 'New Company',
    ]);
});

test('user cannot edit another user application', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);

    $response = $this->actingAs($user2)->patch(route('applications.update', $application), [
        'company_name' => 'Hacked',
        'job_title' => $application->job_title,
        'status' => $application->status,
        'priority' => $application->priority,
        'application_date' => $application->application_date->format('Y-m-d'),
    ]);

    $response->assertStatus(403);
});

test('user can archive (soft delete) own application', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('applications.destroy', $application));

    $response->assertRedirect();
    $this->assertSoftDeleted($application);
});

test('user cannot archive another user application', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);

    $response = $this->actingAs($user2)->delete(route('applications.destroy', $application));

    $response->assertStatus(403);
});

test('archived application does not appear in active list', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $application->delete();

    $response = $this->actingAs($user)->get(route('applications.index'));

    $response->assertDontSee($application->company_name);
});

test('applications can be filtered by status', function () {
    $user = User::factory()->create();
    Application::factory()->create(['user_id' => $user->id, 'status' => 'en_attente']);
    Application::factory()->create(['user_id' => $user->id, 'status' => 'offre_recue']);

    $response = $this->actingAs($user)->get(route('applications.index', ['status' => 'en_attente']));

    $response->assertStatus(200);
});

test('applications can be filtered by priority', function () {
    $user = User::factory()->create();
    Application::factory()->create(['user_id' => $user->id, 'priority' => 'haute']);
    Application::factory()->create(['user_id' => $user->id, 'priority' => 'basse']);

    $response = $this->actingAs($user)->get(route('applications.index', ['priority' => 'haute']));

    $response->assertStatus(200);
});

test('user sees only their own applications in list', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    Application::factory()->create(['user_id' => $user1->id, 'company_name' => 'User1 Corp']);
    Application::factory()->create(['user_id' => $user2->id, 'company_name' => 'User2 Corp']);

    $response = $this->actingAs($user1)->get(route('applications.index'));

    $response->assertSee('User1 Corp');
    $response->assertDontSee('User2 Corp');
});

test('unauthenticated user cannot create application', function () {
    $response = $this->get(route('applications.create'));
    $response->assertRedirect(route('login'));

    $response = $this->post(route('applications.store'), [
        'company_name' => 'Hacked Corp',
        'job_title' => 'Hacker',
        'status' => 'en_attente',
        'priority' => 'haute',
        'application_date' => now()->format('Y-m-d'),
    ]);
    $response->assertRedirect(route('login'));
});

test('unauthenticated user cannot edit application', function () {
    $application = Application::factory()->create();

    $response = $this->get(route('applications.edit', $application));
    $response->assertRedirect(route('login'));

    $response = $this->patch(route('applications.update', $application), [
        'company_name' => 'Hacked Corp',
        'job_title' => $application->job_title,
        'status' => $application->status,
        'priority' => $application->priority,
        'application_date' => $application->application_date->format('Y-m-d'),
    ]);
    $response->assertRedirect(route('login'));
});

test('unauthenticated user cannot delete application', function () {
    $application = Application::factory()->create();

    $response = $this->delete(route('applications.destroy', $application));
    $response->assertRedirect(route('login'));
});

test('application update fails with invalid data', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->patch(route('applications.update', $application), [
        'company_name' => '',
        'job_title' => '',
        'status' => 'invalid_status',
        'priority' => 'invalid_priority',
        'application_date' => 'not-a-date',
    ]);

    $response->assertSessionHasErrors(['company_name', 'job_title', 'status', 'priority', 'application_date']);
});

test('archived application returns 404 on show page', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $application->delete();

    $response = $this->actingAs($user)->get(route('applications.show', $application));

    $response->assertStatus(404);
});
