<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrectionBreak extends Model
{
    use HasFactory;

    public function attendanceCorrectionRequest()
    {
        return $this->belongsTo(AttendanceCorrectionRequest::class);
    }
}
