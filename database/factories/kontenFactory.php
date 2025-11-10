<?php

namespace Database\Factories;

use App\Models\konten;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\konten>
 */
class kontenFactory extends Factory
{
    protected $model = konten::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(6),
            'isi' => fake()->paragraph(3),
            'detil' => fake()->paragraphs(5, true),
        ];
    }
}
