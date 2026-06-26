<?php
/**
 * Trait for processing TodolistProcess
 */
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Users\StudentUser;
use App\Models\StudentHomework;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Log;

/**
 *
 * @class trait
 * Trait for TodolistProcess Processes
 */
trait HomeworkProcess
{
    use EventProcess;

    public function addStudentHomework($homework)
    { 
        try
        {
            $standardLinkId =$homework->standardLink_id;

            $students = User::whereHas('studentAcademic', function ($query) use ($standardLinkId) {
                $query->where('standardLink_id', $standardLinkId);
            })->get();

            foreach($students as $student)
            {
                $student_homework = new StudentHomework;

                $student_homework->homework_id       = $homework->id;
                $student_homework->user_id           = $student->id;
                // $student_homework->submitted_on      = date('Y-m-d');
                $student_homework->status            = 'unchecked';

                $path = [];
                
                $student_homework->attachment = $path;
                     
                $student_homework->save();

            }
                
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }
    }
    
}