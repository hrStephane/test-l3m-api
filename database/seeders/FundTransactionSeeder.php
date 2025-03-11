<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\FundTransaction::factory(5)->create();
        \App\Models\FundTransaction::factory()->create([
            'user_id' => 1,
            'reference' => \Illuminate\Support\Str::uuid(),
            'type' => 'withdrawal',
            'amount' => 50,
            'status' => 'completed',
            'description' => 'Withdrawal of 50',
        ]);
    }
}
