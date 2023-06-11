<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Course Enrollment Api
    public function  courseEnrollment(Request $request)
    {
        //validate
        $request->validate([
            "title" => "required",
            "description" => "required",
            "total_videos" => "required"
        ]);

        $course = new Course();
        //create course
        $course->user_id = auth()->user()->id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->total_videos = $request->total_videos;

        $course->save();

        //send response
        return response()->json([
            "status" => 1,
            "message" => "Course Enrolled Successfull"
        ]);
    }

    //Total Courses Enrollment API
    public function totalCourses()
    {

        $id = auth()->user()->id;

        $courses = User::find($id)->courses;

        return response()->json([
            "status" => 1,
            "message" => "Total Courses Enrolled",
            "data" => $courses

        ]);
    }

    //Delete Course API
    public function deleteCourse($id)
    {
        $user_id = auth()->user()->id;

        if (Course::where([
            "id" => $id,
            "user_id" => $user_id
        ])->exists()) {

            $course = Course::find($id);

            $course->delete();

            return response()->json([
                "status" => 1,
                "message" => "Course deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Course not found"
            ]);
        }
    }
}
