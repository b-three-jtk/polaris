<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Membuat fungsi notify_reviewer
        DB::unprepared('
        CREATE OR REPLACE FUNCTION notify_reviewer()
        RETURNS TRIGGER AS $$
        BEGIN
            IF NEW.nip_reviewer IS NOT NULL THEN
                INSERT INTO notifications (
                    id,
                    user_id,
                    "isRead",
                    message,
                    notifiable_id,
                    notifiable_type,
                    created_at,
                    updated_at
                )
                VALUES (
                    gen_random_uuid(),
                    (SELECT user_id FROM reviewers WHERE nip_reviewer = NEW.nip_reviewer),
                    FALSE,
                    CONCAT(\'A new submission has been assigned to you: \', NEW.submission_title),
                    (SELECT user_id FROM reviewers WHERE nip_reviewer = NEW.nip_reviewer),
                    \'App\\Models\\Reviewer\',
                    NOW(),
                    NOW()
                );
            END IF;
            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
    ');

        // Membuat trigger after_submission_with_reviewer
        DB::unprepared('
            CREATE TRIGGER after_submission_with_reviewer
            AFTER INSERT ON submissions
            FOR EACH ROW
            EXECUTE FUNCTION notify_reviewer();
        ');

        // Membuat trigger after_update_reviewer_assignment
        DB::unprepared('
            CREATE TRIGGER after_update_reviewer_assignment
            AFTER UPDATE OF nip_reviewer ON submissions
            FOR EACH ROW
            -- Trigger aktif hanya jika nip_reviewer baru berbeda dengan lama dan tidak NULL
            WHEN (NEW.nip_reviewer IS DISTINCT FROM OLD.nip_reviewer AND NEW.nip_reviewer IS NOT NULL)
            EXECUTE FUNCTION notify_reviewer();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Menghapus trigger dan fungsi jika rollback
        DB::unprepared('DROP TRIGGER IF EXISTS after_submission_with_reviewer ON submissions;');
        DB::unprepared('DROP TRIGGER IF EXISTS after_update_reviewer_assignment ON submissions;');
        DB::unprepared('DROP FUNCTION IF EXISTS notify_reviewer();');
    }
};