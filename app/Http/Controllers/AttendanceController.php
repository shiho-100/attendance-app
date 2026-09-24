<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use App\Models\AttendanceBreak;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $formattedDate = now()->format('Y年m月d日');
        $formattedTime = now()->format('H:i');

        $attendance = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('date', now()->toDateString())
            ->first();


        if (!$attendance) {
            $attendanceStatus = '勤務外';
        } elseif ($attendance->clock_out) {
            $attendanceStatus = '退勤済';
        } else {
            $activeBreak = $attendance->breaks()
                ->whereNull('break_end')
                ->latest()
                ->first();

            if ($activeBreak) {
                $attendanceStatus = '休憩中';
            } else {
                $attendanceStatus = '出勤中';
            }
        }

        return view('user.attendance-register', compact(
            'user',
            'formattedDate',
            'formattedTime',
            'attendanceStatus'
            ));
    }

    public function store(Request $request)
    {
        if ($request->action === 'clock_in') {
            AttendanceRecord::create([
                'user_id' => Auth::id(),
                'date' => now()->toDateString(),
                'clock_in' => now()->format('H:i:s'),
            ]);
        }

        if ($request->action === 'break_in') {
            $attendance = AttendanceRecord::where('user_id', Auth::id())
                ->whereDate('date', now()->toDateString())
                ->first();

            AttendanceBreak::create([
                'attendance_record_id' => $attendance->id,
                'break_start' => now()->format('H:i:s'),
            ]);
        }

        if ($request->action === 'break_out') {
            $attendance = AttendanceRecord::where('user_id', Auth::id())
                ->whereDate('date', now()->toDateString())
                ->first();

            $activeBreak = AttendanceBreak::where(
                'attendance_record_id',
                $attendance->id
            )
                ->whereNull('break_end')
                ->latest()
                ->first();

            if ($activeBreak) {
                $activeBreak->update([
                    'break_end' => now()->format('H:i:s'),
                ]);
            }

        }

        if ($request->action === 'clock_out') {
            $attendance = AttendanceRecord::where('user_id', Auth::id())
                ->whereDate('date', now()->toDateString())
                ->first();

            if ($attendance) {
                $attendance->update([
                    'clock_out' => now()->format('H:i:s'),
                ]);
            }
        }

        return redirect('/attendance');
    }
}
