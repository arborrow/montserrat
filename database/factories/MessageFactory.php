<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Email;
use Carbon\Carbon;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     * 
     * id , mailgun_id , mailgun_timestamp , storage_url , recipients , from , from_id , to , to_id , subject , body , is_processed , deleted_at , remember_token , created_at , updated_at , 
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['order','touchpoint','donation']);
        $from = Contact::factory()->create();
        $to = Contact::factory()->create();
        $to_email = Email::factory()->create(['contact_id' => $to->id]);

        return [
            'mailgun_id' => $this->faker->uuid(),
            'mailgun_timestamp' =>  Carbon::now(), 
            'storage_url' => $this->faker->url() , 
            'recipients' =>  $type.'@mailgun.montserratretreat.org', 
            'from' => $from->first_name.'@'.config('polanco.socialite_domain_restriction'), 
            'from_id' =>  $from->id, 
            'to' => $to_email->email,
            'to_id' => $to->id, 
            'subject' => $this->faker->sentence(), 
            'body' =>  $this->faker->sentence(), 
            'is_processed' => $this->faker->boolean() , 

        ];
    }
}
