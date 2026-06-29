<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use App\Models\Standard;
use App\Models\Section;
use App\Models\School;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreSubjects = [
            "Playgroup" => [
                'English',
                'Mathematics',
                'General Awareness',
                'Environmental Science'
            ],

            "Pre KG" => [
                'English',
                'Mathematics',
                'General Awareness',
                'Environmental Science'
            ],

            "LKG" => [
                'English',
                'Mathematics',
                'General Awareness',
                'Environmental Science'
            ],

            "UKG" => [
                'English',
                'Mathematics',
                'General Awareness',
                'Environmental Science'
            ],

            "Grade I" => [
                'Skills',
                'Tamil',
                'English',
                'Mathematics',
                'Environmental Science'
            ],

            "Grade II" => [
                'Skills',
                'Tamil',
                'English',
                'Mathematics',
                'Environmental Science'
            ],

            "Grade III" => [
                'Skills',
                'Tamil',
                'English',
                'Mathematics',
                'Environmental Science'
            ],

            "Grade IV" => [
                'Skills',
                'English',
                'Mathematics',
                'Science',
                'Social Science'
            ],

            "Grade V" => [
                'Skills',
                'English',
                'Mathematics',
                'Science',
                'Social Science'
            ],

            "Grade VI" => [
                'English',
                'Mathematics',
                'Science',
                'Social Science'
            ],

            "Grade VII" => [
                'English',
                'Mathematics',
                'Science',
                'Social Science'
            ],

            "Grade VIII" => [
                'English',
                'Mathematics',
                'Science',
                'Social Science'
            ],
        ];

        $schools = School::where('status', 1)->get();

        foreach ($schools as $school) {

            $academicYear = AcademicYear::where([
                ['school_id', $school->id],
                ['status', 1]
            ])->first();

            if (!$academicYear) {
                continue;
            }

            $standards = Standard::where('school_id', $school->id)
                ->orderBy('order')
                ->get();

            $sections = Section::where('school_id', $school->id)->get();

            foreach ($standards as $standard) {

                if (!isset($coreSubjects[$standard->name])) {
                    continue;
                }

                foreach ($sections as $section) {

                    foreach ($coreSubjects[$standard->name] as $subject) {

                        DB::table('subjects')->insert([
                            'school_id'        => $school->id,
                            'academic_year_id' => $academicYear->id,
                            'standard_id'      => $standard->id,
                            'section_id'       => $section->id,
                            'name'             => $subject,
                            'code'             => strtoupper(substr($subject, 0, 3))
                                . '-' . $section->name
                                . '-' . str_replace(' ', '', $standard->name),
                            'type'             => 'core',
                            'status'           => 1,
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ]);
                    }
                }
            }
        }
    }
}