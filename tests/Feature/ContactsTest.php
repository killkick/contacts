<?php

namespace Tests\Feature;

use App\Contact;

use App\User;
use Carbon\Carbon;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseCookieValueSame;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function an_authenticated_user_should_redirect_to_login_page()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['api_token' => '']));
        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function a_list_of_contacts_can_be_fetched_for_authenticated_user()
    {

        $user = factory(User::class)->create();
        $another_user = factory(User::class)->create();
        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $another_contact = factory(Contact::class)->create(['user_id' => $another_user->id]);

        $response = $this->get('/api/contacts?api_token=' . $user->api_token);
        $response->assertJsonCount(1)
            ->assertJson([
            'data' => [
                 [
                     'data' => ['contact_id' => $contact->id]
                 ]
            ]
        ]);
    }

    /** @test */
    public function an_authenticated_can_add_the_contact()
    {

        $response = $this->post('/api/contacts', array_merge($this->data()));
        $contact = Contact::first();
        $this->assertEquals('test name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('test company', $contact->company);
        $this->assertEquals('24-03-1998', $contact->birthday->format('d-m-Y'));
        $response->assertStatus(Response::HTTP_CREATED)->assertJson([
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' => [
                'path' => $contact->path(),
            ]
        ]);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name', 'email', 'birthday'])->each(function ($field) {
            $response = $this->post('/api/contacts', array_merge($this->data(), [$field => '']));
            $response->assertSessionHasErrors($field);
            $this->assertCount(0, Contact::all());
        });
    }

    /** @test */
    public function email_must_be_valid()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['email' => 'NOT AN EMAIL']));
        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdays_are_properly_stored()
    {

        $response = $this->post('/api/contacts', array_merge($this->data()));
        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
    }

    /** @test */
    public function a_contact_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'company' => $contact->company,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('d-m-Y'),
            ]
        ]);
    }

    /** @test */
    public function only_the_user_contacts_can_be_retrieved()
    {

        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $anotherUser = factory(User::class)->create();
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $anotherUser->api_token);
        $response->assertStatus(403);
    }

    /** @test */
    public function a_contact_can_be_patched()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());
        $contact = $contact->fresh();
        $this->assertEquals('test name', $contact->name);
        $this->assertEquals('test company', $contact->company);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('24-03-1998', $contact->birthday->format('d-m-Y'));
        $response->assertStatus(Response::HTTP_OK)->assertJson([
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' =>  [
                'path' =>  $contact->path()
            ]
        ]);

    }

    /** @test */
    public function only_authenticated_user_can_patch_the_contact()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/contacts/' . $contact->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));
        $response->assertStatus(403);
    }

    /** @test */
    public function a_contact_can_be_deleted()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_authenticated_user_can_delete_the_contact()
    {
        $contact = factory(Contact::class)->create();
        $anotherUser = factory(User::class)->create();
        $response = $this->delete('/api/contacts/' . $contact->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));
        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'name' => 'test name',
            'email' => 'test@email.com',
            'birthday' => '24-03-1998',
            'company' => 'test company',
            'api_token' => $this->user->api_token

        ];
    }

}
