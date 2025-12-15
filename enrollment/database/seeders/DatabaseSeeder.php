<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Fee;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@daycare.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Registrar User
        User::create([
            'name' => 'Registrar User',
            'email' => 'registrar@daycare.com',
            'password' => Hash::make('password'),
            'role' => 'registrar',
        ]);

        // Create Cashier User
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@daycare.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        // Create Teachers
        $teacher1 = Teacher::create([
            'teacher_name' => 'Maria Santos',
            'contact_information' => '09123456789',
        ]);

        $teacher2 = Teacher::create([
            'teacher_name' => 'Jose Garcia',
            'contact_information' => '09234567890',
        ]);

        // Create Fees
        $tuitionFee = Fee::create([
            'fee_name' => 'Tuition Fee',
            'amount' => 15000.00,
            'description' => 'Annual tuition fee for kindergarten',
        ]);

        $miscFee = Fee::create([
            'fee_name' => 'Miscellaneous Fee',
            'amount' => 2500.00,
            'description' => 'Books, materials, and activities',
        ]);

        $uniformFee = Fee::create([
            'fee_name' => 'Uniform Fee',
            'amount' => 1500.00,
            'description' => 'School uniform set',
        ]);

        // Create Sample Students
        $student1 = Student::create([
            'student_name' => 'Juan Dela Cruz Jr.',
            'date_of_birth' => '2019-05-15',
            'gender' => 'male',
            'contact_information' => '09345678901',
            'address' => '123 Main St, Manila',
            'guardian_name' => 'Juan Dela Cruz Sr.',
        ]);

        $student2 = Student::create([
            'student_name' => 'Maria Clara Reyes',
            'date_of_birth' => '2019-08-22',
            'gender' => 'female',
            'contact_information' => '09456789012',
            'address' => '456 Oak Ave, Quezon City',
            'guardian_name' => 'Pedro Reyes',
        ]);

        $student3 = Student::create([
            'student_name' => 'Pedro Penduco',
            'date_of_birth' => '2020-01-10',
            'gender' => 'male',
            'contact_information' => '09567890123',
            'address' => '789 Pine St, Makati',
            'guardian_name' => 'Ana Penduco',
        ]);

        // Create Student User Account (for student1)
        User::create([
            'name' => 'Juan Dela Cruz Jr.',
            'email' => 'juan.student@daycare.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => $student1->student_id,
        ]);

        // Create Enrollments
        Enrollment::create([
            'student_id' => $student1->student_id,
            'school_year' => '2024-2025',
            'enrollment_date' => '2024-06-01',
            'status' => 'enrolled',
        ]);

        Enrollment::create([
            'student_id' => $student2->student_id,
            'school_year' => '2024-2025',
            'enrollment_date' => '2024-06-05',
            'status' => 'enrolled',
        ]);

        Enrollment::create([
            'student_id' => $student3->student_id,
            'school_year' => '2024-2025',
            'enrollment_date' => '2024-06-10',
            'status' => 'pending',
        ]);

        // Create Payments
        Payment::create([
            'student_id' => $student1->student_id,
            'fee_id' => $tuitionFee->fee_id,
            'payment_date' => '2024-06-01',
            'payment_amount' => 15000.00,
            'payment_type' => 'full',
            'remarks' => 'Full payment',
        ]);

        Payment::create([
            'student_id' => $student2->student_id,
            'fee_id' => $tuitionFee->fee_id,
            'payment_date' => '2024-06-05',
            'payment_amount' => 5000.00,
            'payment_type' => 'installment',
            'remarks' => 'First installment',
        ]);

        // Create Grades/Performance Records
        Grade::create([
            'student_id' => $student1->student_id,
            'teacher_id' => $teacher1->teacher_id,
            'academic_period' => 'Q1',
            'cognitive_skills' => 'excellent',
            'motor_skills' => 'good',
            'social_skills' => 'excellent',
            'emotional_dev' => 'good',
            'behavior' => 'excellent',
            'teacher_remarks' => 'Juan is doing great! Very active in class activities.',
        ]);

        Grade::create([
            'student_id' => $student2->student_id,
            'teacher_id' => $teacher1->teacher_id,
            'academic_period' => 'Q1',
            'cognitive_skills' => 'good',
            'motor_skills' => 'excellent',
            'social_skills' => 'good',
            'emotional_dev' => 'excellent',
            'behavior' => 'good',
            'teacher_remarks' => 'Maria is very creative and loves art activities.',
        ]);
    }
}
