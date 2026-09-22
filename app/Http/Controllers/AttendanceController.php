<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;

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

        if ($attendance) {
            $attendanceStatus = '出勤中';
        } else {
            $attendanceStatus = '勤務外';
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

        return redirect('/attendance');
    }
}
