<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            -- TRIGGER NOTIFIKASI STATUS UPDATE
            CREATE OR REPLACE FUNCTION notify_update_submission_status()
            RETURNS TRIGGER AS $$
            DECLARE
                target_user_id UUID; -- Variabel untuk menyimpan user_id
            BEGIN
                -- Memetakan submitter_id ke user_id melalui tabel submitters
                SELECT user_id INTO target_user_id
                FROM submitters
                WHERE submitter_id = NEW.submitter_id;

                -- Jika user_id ditemukan
                IF target_user_id IS NOT NULL THEN
                    -- Memeriksa apakah kolom status berubah
                    IF OLD.status IS DISTINCT FROM NEW.status THEN
                        -- Memeriksa apakah notifikasi untuk user_id terkait sudah ada
                        IF EXISTS (
                            SELECT 1 
                            FROM notifications 
                            WHERE notifiable_id = target_user_id::text
                                AND notifiable_type = \'User\'
                                AND message LIKE CONCAT(\'%\', NEW.submission_title, \'%\')
                        ) THEN
                            -- Jika ada, perbarui kolom message dan updated_at
                            UPDATE notifications
                            SET message = CONCAT(\'Status pengajuan Anda dengan judul "\', NEW.submission_title, \'" telah diperbarui menjadi \', NEW.status),
                                updated_at = NOW(),
                                "isRead" = FALSE
                            WHERE notifiable_id = target_user_id::text
                                AND notifiable_type = \'User\'
                                AND message LIKE CONCAT(\'%\', NEW.submission_title, \'%\');
                        ELSE
                            -- Jika tidak ada, tambahkan notifikasi baru
                            INSERT INTO notifications (user_id, notifiable_id, notifiable_type, message, "isRead", created_at, updated_at)
                            VALUES (
                                target_user_id,
                                target_user_id::text,
                                \'User\',
                                CONCAT(\'Status pengajuan Anda dengan judul "\', NEW.submission_title, \'" telah diperbarui menjadi \', NEW.status), 
                                FALSE, 
                                NOW(), 
                                NOW()
                            );
                        END IF;
                    END IF;
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            -- TRIGGER UNTUK MENJALANKAN FUNGSI DI ATAS
            CREATE TRIGGER notify_update_status
            AFTER UPDATE OF status ON submissions
            FOR EACH ROW
            EXECUTE FUNCTION notify_update_submission_status();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("
            DROP TRIGGER IF EXISTS notify_update_status ON submissions;
            DROP FUNCTION IF EXISTS notify_update_submission_status();
        ");
    }
};