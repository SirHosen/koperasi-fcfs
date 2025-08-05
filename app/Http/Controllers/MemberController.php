<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Http\Requests\MemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('member_number', 'like', "%{$search}%")
              ->orWhere('nik', 'like', "%{$search}%");
        }

        $members = $query->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(MemberRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => 'member',
            ]);

            $memberNumber = 'KOP' . date('Y') . str_pad(Member::count() + 1, 3, '0', STR_PAD_LEFT);

            Member::create([
                'user_id' => $user->id,
                'member_number' => $memberNumber,
                'nik' => $request->nik,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'occupation' => $request->occupation,
                'monthly_income' => $request->monthly_income,
                'join_date' => $request->join_date ?? now(),
                'status' => $request->status ?? 'active',
            ]);

            DB::commit();
            return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Member $member)
    {
        $member->load('user', 'savings', 'loans');
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(MemberRequest $request, Member $member)
    {
        DB::beginTransaction();
        try {
            $member->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->filled('password')) {
                $member->user->update(['password' => Hash::make($request->password)]);
            }

            $member->update([
                'nik' => $request->nik,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'occupation' => $request->occupation,
                'monthly_income' => $request->monthly_income,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Member $member)
    {
        try {
            $member->user->delete();
            return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus anggota yang memiliki transaksi.']);
        }
    }
}
