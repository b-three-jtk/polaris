<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Reference;
use App\Models\Submission;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5);
    
        $submissions = DB::table('submissions')
            ->select('submission_code', 'submission_title', 'problem_description', 'project_type', 'platform', 'created_at')
            ->where('status', 'terverifikasi')
            ->paginate($perPage);
    
        $organizations = DB::table('organizations')
            ->select('organization_code', 'organization_name')
            ->get();
    
        if ($request->ajax()) {
            return view('components.list_view', compact('submissions'));
        }
    
        return view('submissions.index', compact('submissions', 'organizations'));
    }

    public function print(Request $request)
    {
        // Ambil input pencarian dari form
        $submission_title = $request->input('submission_title');

        // Ambil user yang sedang login
        $user = auth()->user();

        // Query untuk mengambil semua data dengan pencarian tanpa pagination, hanya yang 'terverifikasi'
        $data_pengajuans = Submission::with('submitter') // Mengambil relasi user
            ->where('status', 'terverifikasi') // Tambahkan kondisi untuk status 'terverifikasi'
            ->when($submission_title, function ($query) use ($submission_title) {
                // Filter berdasarkan judul pengajuan jika ada pencarian
                return $query->where('submission_title', 'LIKE', '%' . $submission_title . '%');
            })
            ->get(); // Mengambil semua data tanpa pagination

        // Kirimkan data ke view dengan hasil pencarian
        return view('dashboard.submissions.print-submission', [
            'data_pengajuans' => $data_pengajuans,
            'submission_title' => $submission_title,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $sort_by = $request->input('sort_by', 'submission_title');
        $sort_direction = $request->input('sort_direction', 'desc');
        $platform_filter = $request->input('platform', []);
        $existing_app = $request->boolean('existing_app', true);
        $organization = $request->input('organization');
        $perPage = $request->input('perPage', 5);

        $organizations = DB::table('organizations')
        ->select('organization_code', 'organization_name')
        ->get();

        $submissions = Submission::query()
            ->when($query, function ($q) use ($query) {
                return $q->where('submission_title', 'like', "%{$query}%");
            })
            ->when($platform_filter, function ($q) use ($platform_filter) {
                return $q->whereIn('platform', $platform_filter);
            })
            ->when(!is_null($existing_app), function ($q) use ($existing_app) {
                return $existing_app
                    ? $q->where('project_type', true) // Hanya aplikasi yang sudah ada
                    : $q->where('project_type', false); // Hanya aplikasi baru
            })
            ->when($organization, function ($q) use ($organization) {
                if ($organization) {
                    return $q->whereHas('submitter.organization', function ($query) use ($organization) {
                        $query->where('organization_code', $organization);
                    });
                }
                return $q;
            })            
            ->where('status', 'terverifikasi')
            ->orderBy($sort_by, $sort_direction)
            ->paginate($perPage);
    
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.list_view', ['submissions' => $submissions, 'organizations' => $organizations])->render(),
                'count' => $submissions->total(),
            ]);
        }
    
        return view('submissions.index', compact('submissions', 'organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.submissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubmissionRequest $request)
    {
        try {
            // Validasi data dari request
            $data = $request->validated();
    
            // Tambahkan data tambahan
            $data['submitter_id'] = Auth::user()->submitter->submitter_id;
            $data['submission_code'] = 'PGN-' . strtoupper(uniqid());
            $data['status'] = 'belum_direview';
    
            // Buat data pengajuan
            $submission = Submission::create($data);
    
            // Penanganan referensi
            $referensiData = $request->input('referensi', []);
            foreach ($referensiData as $index => $ref) {
                $path = null;
    
                // Pastikan file tersedia jika tipe adalah 'file'
                if (isset($ref['tipe']) && $ref['tipe'] === 'file') {
                    $file = $request->file('referensi.' . $index . '.file_path'); // Mengakses file berdasarkan array index

                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('uploads', $fileName, 'public');
                    }
                } elseif ($ref['tipe'] === 'link') {
                    $path = $ref['link_path'] ?? null;
                }
    
                // Hanya buat entri jika path sudah di-set
                if ($path !== null) {
                    $submission->reference()->create([
                        'description' => $ref['keterangan'] ?? null,
                        'type' => $ref['tipe'],
                        'path' => $path,
                    ]);
                }
            }
    
            return redirect()->route('dashboard.submissions.index')->with('success', 'Anda berhasil mengirim pengajuan!');
        } catch (ValidationException $e) {
            // Menangani kesalahan validasi
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan dalam validasi data. Silakan periksa kembali input Anda.');
        } catch (ModelNotFoundException $e) {
            // Menangani kesalahan model tidak ditemukan (misalnya submitter)
            return redirect()->back()->withInput()->with('error', 'Data yang Anda cari tidak ditemukan.');
        } catch (Exception $e) {
            // Menangani kesalahan lainnya
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan, coba lagi nanti.');
        }
    }    
    /**
     * Display the specified resource.
     */
    public function show(string $submission_code)
    {
        $submission = Submission::with('submitter.organization')->where('submission_code', $submission_code)->first();

        if (!$submission) {
            return redirect()->route('submissions.index')->with('error', 'Pengajuan tidak ditemukan!');
        }

        return view('submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($submission_code)
    {
        $submission = Submission::findOrFail($submission_code);
        return view('dashboard.submissions.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        // Perbarui data utama pengajuan
        $submission->update(
            array_merge($request->validated(),
            ['status' => 'belum_direview'] // Set status menjadi 'belum_direview'
        ));
    
        // Tangani referensi (file/link)
        if ($request->has('references')) {
            $references = collect($request->input('references'))->map(function ($reference) {
                if ($reference['type'] === 'file' && request()->hasFile("references.{$reference['index']}.file_path")) {
                    $file = request()->file("references.{$reference['index']}.file_path");
                    $reference['file_path'] = $file->store('references'); // Simpan file
                }
                return $reference;
            });
    
            $submission->references()->delete(); // Hapus referensi lama
            $submission->references()->createMany($references->toArray()); // Tambahkan referensi baru
        }
    
        return redirect()->route('dashboard.submissions.index')->with('success', 'Pengajuan berhasil diperbaharui!');
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $submission_code)
    {
        $submission = Submission::where('submission_code', $submission_code)->firstOrFail();

        $submission->delete();

        return redirect()->back()->with('success', 'Pengajuan berhasil dihapus!');
    }

    public function showAllSubmissions(Request $request)
    {
        $submission_title = $request->input('submission_title');

        $user = auth()->user();

        if ($user->role == 1) {
            $data_pengajuans = Submission::with('submitter')
                ->when($user->role === 1, function ($query) use ($user) {
                    return $query->where('submitter_id', $user->submitter->submitter_id);
                })
                ->when($submission_title, function ($query) use ($submission_title) {
                    return $query->where('submission_code', 'PGN-675EEF9270A4A');
                })->get();
        } else if ($user->role == 2) {
            $data_pengajuans = Submission::with('submitter')
                ->where('status', '!=', 'diarsipkan')
                ->when($submission_title, function ($query) use ($submission_title) {
                    return $query->where('submission_title', 'LIKE', '%' . $submission_title . '%');
                })
                ->get();
        } else {
            $data_pengajuans = DB::table('submissions_need_review')
                ->where('nip_reviewer', trim($user->reviewer->nip_reviewer))
                ->when($submission_title, function ($query) use ($submission_title) {
                    return $query->where('submission_title', 'LIKE', '%' . $submission_title . '%');
                })
                ->get();
        }

        $title = 'Hapus Pengajuan!';
        $text = "Apakah kamu yakin akan menghapus pengajuan?";
        confirmDelete($title, $text);

        return view('dashboard.submissions.index', [
            'data_pengajuans' => $data_pengajuans,
            'submission_title' => $submission_title,
        ]);
    }

    // Menampilkan detail pengajuan tertentu
    public function showSubmission(string $submission_code)
    {
        $submission = Submission::with('reference')->where('submission_code', $submission_code)->first();

        if (!$submission) {
            return redirect()->route('submissions.index')->with('error', 'Pengajuan tidak ditemukan!');
        }


        return view('dashboard.submissions.show', compact('submission'));
    }

    public function updateSubmissionStatus($submissionCode, $newStatus)
    {
        $submission = Submission::where('submission_code', $submissionCode)->first();
        
        if (!$submission) {
            return redirect()->back()->withErrors('Submission tidak ditemukan.');
        }

        // Update status submission
        $submission->status = $newStatus;
        $submission->review_date = now(); // Jika perlu update tanggal review
        $submission->save();

        // Membuat pesan notifikasi berdasarkan status
        $message = match ($newStatus) {
            'terverifikasi' => "Submission '{$submission->submission_title}' Anda telah terverifikasi.",
            'ditolak' => "Submission '{$submission->submission_title}' Anda telah ditolak.",
            'diarsipkan' => "Submission '{$submission->submission_title}' telah diarsipkan.",
            default => "Submission '{$submission->submission_title}' belum direview.",
        };

        // Membuat notifikasi
        Notification::create([
            'user_id' => $submission->submitter_id,
            'submission_code' => $submission->submission_code,
            'message' => $message,
            'notifiable_id' => $submission->submission_code,
            'notifiable_type' => Submission::class,
        ]);
        

        return redirect()->route('dashboard.submissions.index')->with('success', 'Status submission berhasil diupdate.');
    }

    public function sendNotification($userId)
    {
        $submissions = Submission::where('user_id', $userId)->get();
        return view('notification.notificationEmail', compact('submissions'));
    }

    public function archiveSubmission(string $submission_code)
    {
        $submission = Submission::where('submission_code', $submission_code)->firstOrFail();

        $submission->update(['status' => 'diarsipkan']);

        return redirect()->back()->with('success', 'Pengajuan berhasil diarsipkan!');
    }

}
