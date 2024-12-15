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
        $pengajuan = Submission::with('reference')->where('submission_code', $submission_code)->first();

        return view('dashboard.submissions.review', compact('pengajuan')); // Sesuaikan nama view
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
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction(); // Memulai transaksi
        try {
            // Mendapatkan data submission berdasarkan ID
            $submission = Submission::findOrFail($id);

            // Mengisi data submission dengan input dari request
            $submission->fill($request->all());
            $submission->review_description = $request->review_description;
            $submission->status = $request->status;
            $submission->review_date = now(); // Menyimpan tanggal review

            // Menyimpan perubahan ke database
            $submission->save();

            // Mengirim notifikasi
            // $response = Http::timeout(120)->get(route('send-notification', ['submission' => $submission->submission_code]));
            $response = app(EmailNotificationsController::class)->sendNotification($submission->submission_code);

            // Periksa status response
            if ($response->getData()->status == 'success') {
                Alert::success('Berhasil', 'Anda berhasil mereview pengajuan!');
            } else {
                Alert::error('Gagal', 'Terjadi kesalahan saat mengirim email notifikasi: ' . $response->getData()->message);
            }

            DB::commit(); // Commit transaksi jika semua berhasil
            return redirect()->route('dashboard.submissions.index');

        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaksi jika terjadi error
            Alert::error('Gagal', 'Terjadi kesalahan');
            return redirect()->route('dashboard.submissions.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hasilReview)
    {
        //
    }
}
