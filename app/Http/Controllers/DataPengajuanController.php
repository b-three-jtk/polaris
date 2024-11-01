<?php

namespace App\Http\Controllers;

use App\Models\data_pengajuan;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use App\Models\Pengajuan; // Pastikan Anda mengimpor model ini

class DataPengajuanController extends Controller
{
    //function index()
    //{
      //  $pengajuans = DB::table('pengajuans')->get();
        //return $pengajuans;
    //}

    public function index(Request $request)
{
    // Ambil input pencarian dari form
    $judul_pengajuan = $request->input('judul_pengajuan');

    // Query untuk mengambil data dengan pencarian dan paginasi
    $data_pengajuans = Pengajuan::with('user') // Mengambil relasi user
        ->when($judul_pengajuan, function ($query) use ($judul_pengajuan) {
            return $query->where('judul_pengajuan', 'LIKE', '%' . $judul_pengajuan . '%');
        })
        ->paginate(10);

    // Kirimkan data ke view dengan hasil pencarian
    return view('dashboard.submissions.index', [
        'data_pengajuans' => $data_pengajuans,
        'judul_pengajuan' => $judul_pengajuan
    ]);
    }

    //public function index()
    //{
    // Mengambil data pengajuan dari database
    //$data_pengajuans = Pengajuan::paginate(10);  // Misalnya menggunakan pagination

    // Mengirim data ke view
    //return view('dashboard.submissions.index', compact('data_pengajuans'));
    //}

    // Menampilkan halaman pengajuan (submissions)
    public function indexSubmissions()
    {
        return view('dashboard.submissions.index'); 
    }

    // Menampilkan detail pengajuan tertentu
    public function show(string $kode_pengajuan)
    {
        $pengajuan = Pengajuan::with('referensi')->where('kode_pengajuan', $kode_pengajuan)->first();

        if (!$pengajuan) {
            return redirect()->route('submissions.index')->with('error', 'Pengajuan tidak ditemukan!');
        }
    
        return view('dashboard.submissions.show', compact('pengajuan'));
    }
    
}