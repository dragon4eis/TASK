<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $disabled = $this->faker->boolean;
        return [
            'title' => $this->faker->monthName,
            'disabled' => $disabled,
            'ready' => $disabled ? false : $this->faker->boolean,
            'deadline' => date('Y-m-d', rand(strtotime('2020-09-30'), strtotime('2020-10-08')))
        ];
    }
}
