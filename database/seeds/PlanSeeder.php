<?php

use App\Models\Plan;

class PlanSeeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Starter Plan',
                'description' => 'Perfect for beginners',
                'min_amount' => 100,
                'max_amount' => 999,
                'interest_rate' => 1.5,
                'compound_frequency' => 'daily',
                'duration_days' => 30,
                'status' => 'active'
            ],
            [
                'name' => 'Premium Plan',
                'description' => 'High returns for serious investors',
                'min_amount' => 1000,
                'max_amount' => 9999,
                'interest_rate' => 2.0,
                'compound_frequency' => 'daily',
                'duration_days' => 60,
                'status' => 'active'
            ],
            [
                'name' => 'VIP Plan',
                'description' => 'Maximum returns for VIP investors',
                'min_amount' => 10000,
                'max_amount' => null,
                'interest_rate' => 2.5,
                'compound_frequency' => 'daily',
                'duration_days' => 90,
                'status' => 'active'
            ]
        ];

        foreach ($plans as $planData) {
            $plan = new Plan();
            foreach ($planData as $key => $value) {
                $plan->$key = $value;
            }
            $plan->save();
        }

        echo "Plans seeded successfully!\n";
    }
}