<?php

namespace Database\Factories;
use App\Models\Student;
use App\Models\Course;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            
            'name' => $this->faker->name(),
            'contact' => $this->faker->phoneNumber(),
            'course_id'=>$this->faker->unique()->numberBetween(1, Course::count())
        ];
    }
}
