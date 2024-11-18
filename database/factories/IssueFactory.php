<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    /**
     * The name of the model that is being factory generated.
     *
     * @var string
     */
    protected $model = Issue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Set the issue date to a past date
        $issueDate = $this->faker->dateTimeBetween('-2 months', '-1 month');

        // Set the due date to a date after the issue date (e.g., 14 days after)
        $dueDate = Carbon::instance($issueDate)->addDays(14);

        // Optionally, set a return date (50% chance) that can be before or after the due date
        $returnDate = $this->faker->boolean(50) 
            ? Carbon::instance($dueDate)->addDays($this->faker->numberBetween(-5, 10)) // Range: returned early or late
            : null;

        // Calculate fine if returned late
        $fineAmount = 0;
        if ($returnDate && $returnDate->greaterThan($dueDate)) {
            $daysLate = $returnDate->diffInDays($dueDate);
            $fineAmount = $daysLate * 5;  // Example fine rate: 5 currency units per day late
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'book_id' => Book::inRandomOrder()->first()->id,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'return_date' => $returnDate,
            'fine_amount' => $fineAmount,
        ];
    }
}
