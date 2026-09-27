<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Test\Concerns;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

trait CountsQueries
{
    protected int $queries = 0;

    /**
     * Start counting every query the application executes.
     */
    protected function countQueries(): void
    {
        $this->queries = 0;

        DB::listen(function (QueryExecuted $query): void {
            $this->queries++;
        });
    }

    /**
     * Assert the number of queries executed since the last assertion, then reset.
     */
    protected function assertQueries(int $count): void
    {
        $this->assertSame($count, $this->queries);

        $this->queries = 0;
    }

    /**
     * Reset the counter without asserting.
     */
    protected function resetQueryCount(): void
    {
        $this->queries = 0;
    }
}
