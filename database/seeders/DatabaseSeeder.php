<?php

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'tanggal' => now(),
                'nama_reimbursement' => 'Expense 1',
                'deskripsi' => 'Description for Expense 1',
                'file_pendukung' => 'expense1.pdf',
                'status' => 'approved',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => now(),
                'nama_reimbursement' => 'Expense 2',
                'deskripsi' => 'Description for Expense 2',
                'file_pendukung' => 'expense2.pdf',
                'status' => 'pending',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('reimbursements')->insert($data);
    }
}
