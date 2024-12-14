<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use App\Models\Reviewer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\StoreAdminRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UpdateAdminRequest;
use App\Notifications\AdminAccountDetail;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $nama = $request->input('name');

        $admins = User::whereIn('role', [2, 3])
            ->when($nama, function ($query) use ($nama) {
                return $query->where('name', 'LIKE', '%' . $nama . '%');
            })
            ->with('admin')
            ->paginate(10);

        return view('dashboard.admins.index', compact('admins', 'nama'));
    }

    public function create()
    {
        return view('dashboard.admins.create');
    }
    
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();

        $generatedPassword = Str::random(10);
    
        DB::beginTransaction();
    
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($generatedPassword),
                'role' => $data['role'],
            ]);
    
            if ($data['role'] == 2) {
                Admin::create([
                    'user_id' => $user->user_id,
                    'nip' => $data['nip'],
                ]);
            } else {
                Reviewer::create([
                    'user_id' => $user->user_id,
                    'nip_reviewer' => $data['nip'],
                    'isActive' => true,
                    'review_total' => 0
                ]);
            }
    
            DB::commit();

            Notification::route('mail', $data['email'])->notify(new AdminAccountDetail($data['name'], $generatedPassword));
    
            Alert::success('Berhasil', 'Admin baru berhasil diperbaharui!');
    
            return redirect()->route('admin.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Alert::error('Error', 'Terjadi kesalahan: ' . $e->getMessage());
    
            return redirect()->route('admin.index');
        }
    }
    public function edit($id)
    {
        $admin = User::with('admin')->findOrFail($id);

        return view('dashboard.admins.edit', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $user = User::findOrFail($id);

            $user->update($data);

            Alert::success('Berhasil', 'Data Admin berhasil diperbaharui!');

            return redirect()->route('admin.index', $id);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika user tidak ditemukan
            Alert::error('Gagal', 'Data Admin tidak ditemukan.');

            return redirect()->route('admin.index')->withErrors(['error' => 'Data tidak ditemukan.']);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data admin.');

            return redirect()->route('admin.index')->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);

        return view('dashboard.admins.show', compact('admin'));
    }
}
