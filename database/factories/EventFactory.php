<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_name' => $this->faker->words(3, true), // Generates 3 random words as the event name
            'event_description' => $this->faker->text, // Generates random text as the event description
            'isApproved' => $this->faker->boolean(80), // 80% chance to get true
            'isCancelled' => $this->faker->boolean(20), // 80% chance to get true
            'event_status' => $this->faker->randomElement(['upcoming', 'past', 'cancelled']), // Random event status
            'event_type' => $this->faker->word, // Random word as the event type
            'event_age_group' => $this->faker->randomElement(['all', 'adults', 'teens', 'kids']), // Random age group
            'event_gender_group' => $this->faker->randomElement(['all', 'male', 'female']), // Random gender group
            'event_address' => $this->faker->streetAddress, // Random street address
            'event_picture' => $this->faker->imageUrl(640, 480, 'event', true), // Placeholder image URL
            'event_capacity' => $this->faker->numberBetween(50, 500), // Random number between 50 and 500
            'event_number_of_participants' => $this->faker->numberBetween(0, 50), // Random number between 0 and 50
            'event_link' => $this->faker->url, // Random URL
            'creatorID' => User::factory(), // Assuming you have a User factory for the creator
            // 'adminID' => User::factory(), // If you need to assign an admin, assuming you have a User factory
            // You can add or modify fields as necessary for your application
        ];
    }
}
