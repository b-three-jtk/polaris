<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;
use App\Models\Submission;

class EmailNotificationsController extends Controller
{
    public function sendNotification($submissionCode)
    {
        // Ambil data submission berdasarkan kode
        $submission = Submission::where('submission_code', $submissionCode)->with(['submitter.user'])->first();
    
        if (!$submission) {
            return response()->json(['status' => 'failed', 'message' => 'Submission not found']);
        }
    
        try {
            // Kirim email
            Mail::send('notification.notificationEmail', ['submission' => $submission], function ($message) use ($submission) {
                $message->to($submission->submitter->user->email)
                        ->subject('Submission Status Update');
            });
    
            // Jika berhasil
            return response()->json(['status' => 'success', 'message' => 'Notification email sent successfully!']);
        } catch (\Exception $e) {
            // Jika gagal
            return response()->json(['status' => 'failed', 'message' => 'Error sending email: ' . $e->getMessage()]);
        }
    }
    

}
