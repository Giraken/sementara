<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('sessions')->delete();

        DB::table('sessions')->insert([
            0 => [
                'id' => 'arkIC4ZG2gvu5QQ1NUt897wbDUzGKSODncuKemua',
                'ip_address' => '127.0.0.1',
                'last_activity' => 1654299687,
                'payload' => 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWnZQaDlxQ1FGYTJJSUticERsVzdMcElkejl5R1dhUEE1ZTZoYllrcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjExO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkQ0k4cHFidjViYjE1aklTcWhLWFJPdTJPNktOZVBZWHZGenQudjl6dWE0ODRrUmU1QUJHL1ciO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO319',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.63 Safari/537.36',
                'user_id' => 11,
            ],
        ]);
    }
}
