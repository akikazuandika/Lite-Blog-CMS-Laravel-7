<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultAdmin::class);
        $this->call(DefaultCategory::class);
        $this->call(DefaultTags::class);
    }
}
