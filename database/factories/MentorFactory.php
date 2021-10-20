<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

class MentorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mentor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullName' => $this->faker->name(),
            'city' => $this->faker->city(),
            'skype' => $this->faker->name(),
            'username' => $this->faker->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            "intern_id" => Intern::factory(),
            "group_id" => Group::factory()
        ];
    }
}
