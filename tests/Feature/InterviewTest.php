<?php

use App\Models\User;
use App\Models\Application;
use App\Models\Interview;

test('user can add interview to own application', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('interviews.store', $application), [
        'type' => 'telephone',
        'scheduled_date' => now()->addDays(1)->format('Y-m-d'),
        'scheduled_time' => '14:00',
        'preparation_notes' => 'Prepare questions',
        'result' => 'en_attente',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('interviews', [
        'application_id' => $application->id,
        'type' => 'telephone',
    ]);
});

test('user cannot add interview to another user application', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);

    $response = $this->actingAs($user2)->post(route('interviews.store', $application), [
        'type' => 'telephone',
        'scheduled_date' => now()->addDays(1)->format('Y-m-d'),
        'scheduled_time' => '14:00',
        'result' => 'en_attente',
    ]);

    $response->assertStatus(403);
});

test('invalid interview data is rejected', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('interviews.store', $application), [
        'type' => 'invalid_type',
        'scheduled_date' => 'not-a-date',
        'scheduled_time' => 'not-a-time',
    ]);

    $response->assertSessionHasErrors(['type', 'scheduled_date', 'scheduled_time']);
});

test('user can edit own interview', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $interview = Interview::factory()->create([
        'application_id' => $application->id,
        'type' => 'telephone',
    ]);

    $response = $this->actingAs($user)->put(route('interviews.update', $interview), [
        'type' => 'visioconference',
        'scheduled_date' => now()->addDays(2)->format('Y-m-d'),
        'scheduled_time' => '15:00',
        'result' => 'en_attente',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('interviews', [
        'id' => $interview->id,
        'type' => 'visioconference',
    ]);
});

test('user cannot edit another user interview', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);
    $interview = Interview::factory()->create(['application_id' => $application->id]);

    $response = $this->actingAs($user2)->put(route('interviews.update', $interview), [
        'type' => 'technique',
        'scheduled_date' => now()->addDays(2)->format('Y-m-d'),
        'scheduled_time' => '15:00',
        'result' => 'en_attente',
    ]);

    $response->assertStatus(403);
});

test('user can delete own interview', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $interview = Interview::factory()->create(['application_id' => $application->id]);

    $response = $this->actingAs($user)->delete(route('interviews.destroy', $interview));

    $response->assertRedirect();
    $this->assertDatabaseMissing('interviews', ['id' => $interview->id]);
});

test('user cannot delete another user interview', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user1->id]);
    $interview = Interview::factory()->create(['application_id' => $application->id]);

    $response = $this->actingAs($user2)->delete(route('interviews.destroy', $interview));

    $response->assertStatus(403);
});

test('interviews appear on application show page', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create(['user_id' => $user->id]);
    $interview = Interview::factory()->create([
        'application_id' => $application->id,
        'type' => 'technique',
    ]);

    $response = $this->actingAs($user)->get(route('applications.show', $application));

    $response->assertStatus(200);
    $response->assertSee($interview->type_label);
});
