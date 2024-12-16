<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\FeedbackMail;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Notification; 
class HomeController extends Controller
{
    public function index()
    {
        $count_pengajuan = Submission::count();
        $newest_pengajuan = DB::table('submissions')
            ->select('submission_code', 'submission_title', 'created_at')
            ->orderBy('created_at', 'desc')
            ->first();

        Carbon::setLocale('id');

        $time_ago = $newest_pengajuan 
        ? Carbon::parse($newest_pengajuan->created_at)->diffForHumans() 
        : null;

        return view('home.index', compact('count_pengajuan', 'newest_pengajuan', 'time_ago'));
    }

    public function about()
    {
        return view('home.about');
    }

    public function help()
    {
        return view('home.faq');
    }

    public function feedback()
    {
        return view('home.feedback');
    }

    public function feedbackStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);
    
        $feedback = $request->only(['email', 'subject', 'message']);
    
        try {
            
            Mail::to('contactsims11@gmail.com')->send(new FeedbackMail($feedback));
    
            return redirect()->back()->with('success', 'Terima kasih atas feedback Anda, pesan Anda sudah terkirim.');
        } catch (\Exception $e) {
            \Log::error('Error saat mengirim feedback: ' . $e->getMessage());
    
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengirim pesan Anda.');
        }
    }
    
    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role == 1) {
            $pengajuan = DB::table('submissions')
                ->join('submitters', 'submissions.submitter_id', '=', 'submitters.submitter_id') // Sesuaikan nama tabel dan kolom
                ->where('submissions.submitter_id', $user->submitter->submitter_id)
                ->take(3)
                ->get();
        } else if ($user->role == 4) {
            $pengajuan = DB::table('submissions')
            ->where('status', 'belum_direview')
            ->where('nip_reviewer', $user->reviewer->nip_reviewer)
            ->take(3) // Membatasi hasil hanya 3
            ->get();
        } else {
            $pengajuan = DB::table('submissions')
                ->where('status', '!=', 'diarsipkan')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }
        
        $jumlah_terverifikasi = Submission::where('status', 'terverifikasi')->count();
        $jumlah_belum = Submission::where('status', 'belum_direview')->count();

        return view('dashboard.index', compact(['pengajuan', 'jumlah_terverifikasi', 'jumlah_belum', 'user']));
    }
}
