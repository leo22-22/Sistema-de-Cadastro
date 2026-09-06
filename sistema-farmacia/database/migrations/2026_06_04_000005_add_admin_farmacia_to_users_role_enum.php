<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            $this->replacePgsqlCheckConstraint("role IN ('superadmin','admin_farmacia','funcionario')");
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin_farmacia','funcionario') NOT NULL DEFAULT 'funcionario'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            $this->replacePgsqlCheckConstraint("role IN ('superadmin','funcionario')");
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','funcionario') NOT NULL DEFAULT 'funcionario'");
        }
    }

    /**
     * Laravel gera o enum() do Postgres como VARCHAR + CHECK constraint (nao ha tipo
     * ENUM nativo portavel). Descobre o nome da constraint existente na coluna role
     * (o nome padrao do Laravel pode variar entre versoes) e a substitui.
     */
    private function replacePgsqlCheckConstraint(string $newCheck): void
    {
        $constraint = DB::selectOne("
            SELECT con.conname
            FROM pg_constraint con
            JOIN pg_class rel ON rel.oid = con.conrelid
            WHERE rel.relname = 'users'
              AND con.contype = 'c'
              AND pg_get_constraintdef(con.oid) ILIKE '%role%'
            LIMIT 1
        ");

        if ($constraint) {
            DB::statement('ALTER TABLE users DROP CONSTRAINT "' . $constraint->conname . '"');
        }

        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK ({$newCheck})");
    }
};
