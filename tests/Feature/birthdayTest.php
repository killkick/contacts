<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class birthdayTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_fetch_contacts_with_birthday__in_this_month() {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $birthdayContact =  factory(Contact::class)
            ->create(['user_id' => $user->id , 'birthday' => now()]);
        $noBirthdayContact =  factory(Contact::class)
            ->create(['user_id' => $user->id , 'birthday' => now()->subMonth()]);
        $this->get('/api/birthdays?api_token=' . $user->api_token)->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => ['contact_id' => $birthdayContact->id]
                ]
            ]
        ]);
    }
}
