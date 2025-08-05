<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use App\Models\Saving;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admins
        $admin1 = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@koperasi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Sudirman No. 1, Jakarta',
        ]);

        $admin2 = User::create([
            'name' => 'Admin Kedua',
            'email' => 'admin2@koperasi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567891',
            'address' => 'Jl. Thamrin No. 2, Jakarta',
        ]);

        // Create Members
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '081234567892',
            'address' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        $member1 = Member::create([
            'user_id' => $user1->id,
            'member_number' => 'KOP2024001',
            'nik' => '3273051234567890',
            'birth_date' => '1985-05-15',
            'gender' => 'L',
            'occupation' => 'Pegawai Swasta',
            'monthly_income' => 5000000,
            'join_date' => '2024-01-01',
            'status' => 'active',
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '081234567893',
            'address' => 'Jl. Diponegoro No. 25, Surabaya',
        ]);

        $member2 = Member::create([
            'user_id' => $user2->id,
            'member_number' => 'KOP2024002',
            'nik' => '3578101234567890',
            'birth_date' => '1990-08-20',
            'gender' => 'P',
            'occupation' => 'Guru',
            'monthly_income' => 4000000,
            'join_date' => '2024-01-05',
            'status' => 'active',
        ]);

        $user3 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '081234567894',
            'address' => 'Jl. Gatot Subroto No. 30, Medan',
        ]);

        $member3 = Member::create([
            'user_id' => $user3->id,
            'member_number' => 'KOP2024003',
            'nik' => '1271051234567890',
            'birth_date' => '1988-03-10',
            'gender' => 'L',
            'occupation' => 'Wiraswasta',
            'monthly_income' => 7000000,
            'join_date' => '2024-01-10',
            'status' => 'active',
        ]);

        // Create Savings
        Saving::create([
            'member_id' => $member1->id,
            'transaction_code' => 'SAV202401001',
            'type' => 'deposit',
            'amount' => 1000000,
            'balance' => 1000000,
            'transaction_date' => '2024-01-15',
            'description' => 'Setoran awal',
            'created_by' => $admin1->name,
        ]);

        Saving::create([
            'member_id' => $member1->id,
            'transaction_code' => 'SAV202401002',
            'type' => 'deposit',
            'amount' => 500000,
            'balance' => 1500000,
            'transaction_date' => '2024-02-15',
            'description' => 'Setoran bulanan',
            'created_by' => $admin1->name,
        ]);

        Saving::create([
            'member_id' => $member2->id,
            'transaction_code' => 'SAV202401003',
            'type' => 'deposit',
            'amount' => 2000000,
            'balance' => 2000000,
            'transaction_date' => '2024-01-20',
            'description' => 'Setoran awal',
            'created_by' => $admin2->name,
        ]);

        // Create Loans
        $loan1 = Loan::create([
            'member_id' => $member1->id,
            'loan_number' => 'LOAN202401001',
            'amount' => 5000000,
            'duration_months' => 12,
            'interest_rate' => 1.5,
            'monthly_payment' => 433333,
            'total_payment' => 5200000,
            'remaining_payment' => 5200000,
            'purpose' => 'Modal usaha',
            'status' => 'approved',
            'request_date' => '2024-02-01',
            'approval_date' => '2024-02-03',
            'approved_by' => $admin1->name,
        ]);

        $loan2 = Loan::create([
            'member_id' => $member3->id,
            'loan_number' => 'LOAN202401002',
            'amount' => 10000000,
            'duration_months' => 24,
            'interest_rate' => 1.5,
            'monthly_payment' => 458333,
            'total_payment' => 11000000,
            'remaining_payment' => 11000000,
            'purpose' => 'Renovasi rumah',
            'status' => 'pending',
            'request_date' => '2024-03-01',
        ]);

        // Create Payments for loan1
        Payment::create([
            'loan_id' => $loan1->id,
            'payment_code' => 'PAY202403001',
            'installment_number' => 1,
            'amount' => 433333,
            'payment_date' => '2024-03-03',
            'penalty' => 0,
            'status' => 'paid',
            'received_by' => $admin1->name,
        ]);

        // Update remaining payment
        $loan1->update(['remaining_payment' => 4766667]);

        // Create Notifications
        Notification::create([
            'user_id' => $user1->id,
            'title' => 'Pinjaman Disetujui',
            'message' => 'Selamat! Pinjaman Anda sebesar Rp 5.000.000 telah disetujui.',
            'type' => 'success',
        ]);

        Notification::create([
            'user_id' => $user1->id,
            'title' => 'Pembayaran Berhasil',
            'message' => 'Pembayaran angsuran ke-1 sebesar Rp 433.333 telah berhasil.',
            'type' => 'info',
        ]);

        Notification::create([
            'user_id' => $user3->id,
            'title' => 'Pengajuan Pinjaman',
            'message' => 'Pengajuan pinjaman Anda sebesar Rp 10.000.000 sedang dalam proses review.',
            'type' => 'info',
        ]);
    }
}
