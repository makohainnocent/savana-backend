<?php

namespace Database\Factories;
use App\Models\Course;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
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

            'name' => $this->faker->word()."_course",
            'teacher' => $this->faker->name(),
        ];
    }
}
