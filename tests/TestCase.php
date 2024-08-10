<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        //Создание тестовой БД - если её нет.
        $this->createDataBase();
    }

    private function createDataBase()
    {
        $databaseName = env('TEST_DB_DATABASE', 'test_db');

        //проверяем существует ли БД
        $exists = DB::connection('pgsql')->select("SELECT 1 FROM pg_database WHERE datname = ?", [$databaseName]);

        if (empty($exists)) {
            // Если нет, создаем базу данных
            DB::connection('pgsql')->statement("CREATE DATABASE \"$databaseName\";");
        }
    }
}
