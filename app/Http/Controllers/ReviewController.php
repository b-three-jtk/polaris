<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function review() {
        $submission_title = Submission::all();
        return view("dashboard.submissions.review", compact('submission_title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($submission_code)
    {
        $submission = Submission::with('reference')->where('submission_code', $submission_code)->first();

        return view('dashboard.submissions.review', compact('submission')); // Sesuaikan nama view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'review_description' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Gagal melakukan review');
        }

        try {
            // Mendapatkan data submission berdasarkan ID
            $submission = Submission::findOrFail($id);

            // Mengisi data submission dengan input dari request
            $submission->fill($request->all());
            $submission->review_description = $request->review_description;
            if ($request->status == 1) {
                $submission->status = 'terverifikasi';
            } else {
                $submission->status = 'ditolak';
            }
            $submission->review_date = now(); // Menyimpan tanggal review

            // Menyimpan perubahan ke database
            $submission->save();

            // Mengirim notifikasi
            $response = app(EmailNotificationsController::class)->sendNotification($submission->submission_code);

            if ($response->getData()->status == 'success') {
                return redirect()->route('dashboard.submissions.index')->with('success', 'Anda berhasil mereview pengajuan!');
            } else {
                return redirect()->route('dashboard.submissions.index')->with('error', 'Terjadi kesalahan saat mengirim email notifikasi: ' . $response->getData()->message);
            }

        } catch (\Exception $e) {
            // Menangani exception jika terjadi kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showHistory() {
        $user = auth()->user();

        $submissions = DB::table('submissions')
            ->where('nip_reviewer', trim($user->reviewer->nip_reviewer))
            ->where('status', '!=', 'belum_direview')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard.submissions.history', compact('submissions'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hasilReview)
    {
        //
    }
}
