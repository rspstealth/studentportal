<?php
namespace App\Http\Controllers;
use App\Traits\getSetting;
use App\Course;
use App\CourseNotes;
use App\Evidence;
use App\Assessment;
use App\Assignment;
use App\AssignmentNote;
use App\AssignmentMarker;
use App\AssignedCourse;
use App\MarkAssignment;
use App\MarkEvidence;
use App\CannedResponse;
use App\Feedback;
use App\Resource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use getSetting;//settings trait

    //find best matched courses by user query
    public function getCoursesAJAX(Request $request)
    {
        $course_list = DB::table('courses')->select('id','name')->where('name','LIKE',"$request->course%");
        $course_list = $course_list->take(10);
        $course_list = $course_list->get();
        if ($request->ajax()) {
            return response()->json($course_list);
        }else{
            return response()->json($request->all());
        }
    }

    // find best matched courses by user query except given ids
    public function getCoursesWhereNotInAJAX(Request $request)
    {
        $course_ids = explode(',',$request->added_courses_ids);
        $course_ids_string = [];
        foreach($course_ids as $id){
            $course_ids_string[] = $id;
        }

        $course_list = DB::table('courses')->select('id','name')->whereNotIn('id',$course_ids_string)->where('name','LIKE',"$request->course%");
        $course_list = $course_list->get();
        if ($request->ajax()) {
            return response()->json($course_list);
        }else{
            return response()->json($request->all());
        }
    }

    // get single course based on id
    public function getCourseByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $course = DB::table('courses')->where('id','=',$request->edit_course_id)->get();
            return response()->json($course);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    // get single course based on id
    public function getEvidenceByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $course = DB::table('evidences')->where('id','=',$request->edit_evidence_id)->get();
            return response()->json($course);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get student course assignment for manual admin upload
    public function getStudentCourseAssignmentForManualUploadByIdAJAX(Request $request){
        if ($request->ajax()){
            $return_object = array();
            //get course info
            $course = DB::table('courses')->where('id','=',$request->course_id)->first();
            $student = DB::table('students')->where('id','=',$request->student_id)->first();
            $return_object['course_title'] = $course->name;
            $return_object['total_assignments'] = $course->number_of_assignments;
            $return_object['student_name'] = $student->first_name.' '.$student->last_name;
            return response()->json($return_object);
        }else{
            return response()->json($request->all());
        }
    }

    //get student course assignment for manual admin upload to student dashboard
    public function getStudentCourseAssignmentManualUploadForDashboardByIdAJAX(Request $request){
        if ($request->ajax()){
            $return_object = array();
            //get course info
            $course = DB::table('courses')->where('id','=',$request->course_id)->first();
            $student = DB::table('students')->where('id','=',$request->student_id)->first();
            $return_object['course_title'] = $course->name;
            $return_object['total_assignments'] = $course->number_of_assignments;
            $return_object['student_name'] = $student->first_name.' '.$student->last_name;
            return response()->json($return_object);
            //return response()->json($template[0]);
        }else{
            return response()->json($request->all());
        }
    }

    //get course name by id
    public static function getCourseNameById($id)
    {
        $course_name = Course::where('id', $id)->value('name');
        return $course_name;//Works fine with php 7.2.*
    }

    //get course type by course id
    public static function getCourseTypeById($id)
    {
        $course_type = Course::where('id', $id)->value('type');
        return $course_type;//Works fine with php 7.2.*
    }

    //get course evidence uploaded file by id
    public static function getEvidenceFile($id)
    {
        $logged_user = Auth::user();
        $student_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
        $file = DB::table('standard_courses_uploads')
            ->select('assignment_file')
            ->where('unit_evidence_id','=',$id)
            ->where('student_id','=',$student_id[0])
            ->get();
        if(!empty($file)){
            return $file;
        }
        return;
    }

    //get course evidence uploaded file by id
    public static function getEvidenceStatus($id)
    {
        $logged_user = Auth::user();
        $student_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
        $status = DB::table('standard_courses_uploads')
            ->select('status')
            ->where('unit_evidence_id','=',$id)
            ->where('student_id','=',$student_id[0])
            ->get();
        if(!empty($status)){
            return $status;
        }
        return;
    }

    //get course evidence marked on by id
    public static function getEvidenceMarkingDate($id)
    {
        $logged_user = Auth::user();
        $student_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
        $marking_dates = DB::table('standard_courses_uploads')
            ->select('updated_at')
            ->where('unit_evidence_id','=',$id)
            ->where('student_id','=',$student_id[0])
            ->get();
        if(!empty($marking_dates)){
            return $marking_dates;
        }
        return;
    }

    // get single course feedback template by id
    public function getFeedbackTemplateByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $feedback = DB::table('feedback_templates')->where('id','=',$request->edit_feedback_id)->get();
            return response()->json($feedback);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    // get single course canned response template by id
    public function getCannedResponseByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $canned = DB::table('canned_responses')->where('id','=',$request->edit_canned_it)->get();
            return response()->json($canned);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    // single course page
    public function displayCourse($course_id,Request $request)
    {
        $course = DB::table('courses')->where('id','=',$course_id)->first();
        //grab feedback templates for each course
        if(!empty($course->id)){
            $course_feedback_templates = DB::table('feedback_templates')
                ->where('course_id','=',$course->id)
                ->orderBy('assignment_number','ASC')
                ->get()->toArray();
            $canned_responses = DB::table('canned_responses')
                //->where('course_id','=',$course->id)
                ->get();

            $assessment_parent_units = DB::table('evidences')
                ->where('unit_parent','=',NULL)
                ->where('course_id','=',$course->id)
                ->orderBy('id','ASC')
                ->get();

            $assessment_children = array();
            foreach($assessment_parent_units as $parent){
                $assessment_children[$parent->unit_number] = DB::table('evidences')
                    ->where('course_id','=',$course->id)
                    ->where('main_parent','=',$parent->unit_number)
                    ->orderBy('id','ASC')
                    ->get();
            }
            $assessments = DB::table('assessments')->where('course_id','=',$course->id)->orderBy('id','ASC')->get();
        }

        $params = [
            'course_id'                 => $course_id,
            'assessments'               => $assessments,
            'assessment_parent_units'   => $assessment_parent_units,
            'assessment_children'       => $assessment_children,
            'course_feedback_templates' => $course_feedback_templates,
            'canned_responses'          => $canned_responses,
        ];
        return view('courses/edit-course',compact('course', $course))->with($params);
    }

    //course progress
    public static function getCourseProgress($student_id,$course_id,$course_type){
        $course_assignments = DB::table('courses')->where('id','=',$course_id)->pluck('number_of_assignments');
        $progress = 0;
        if($course_type === 'standard'){
            if(!empty($course_assignments[0])){
                $progress = count(DB::table('standard_courses_uploads')
                    ->where('course_id','=',$course_id)
                    ->where('student_id','=',$student_id)
                    ->where('status','=','PASS')
                    ->get());
                return ($progress != 0) ? (100 / $course_assignments[0]) * $progress : 0;
            }else{
                echo 'Course has no assignments';
                return;
            }
        }elseif($course_type === 'work_based'){
            $total_evidences = DB::table('evidences')
                ->where('course_id','=',$course_id)
                ->whereBetween('unit_number',['0', '999'])
                ->where('unit_parent','<>',NULL)
                ->count();

            $passed_evidences = DB::table('standard_courses_uploads')
                ->distinct('unit_evidence_id')
                ->where('course_id','=',$course_id)
                ->where('student_id','=',$student_id)
                ->where('status','=','PASS')
                ->get();

            $unique_evidences = array();

            foreach($passed_evidences as $evidence){
                if(!in_array($evidence->unit_evidence_id,$unique_evidences)){
                    $unique_evidences[] = $evidence->unit_evidence_id;
                }
            }

            $passes_count = count($unique_evidences);
            return ($passes_count != 0) ? (100 / $total_evidences) * $passes_count : 0;
        }
    }

    //course dash page
    public function getCourseDash($course_id,Request $request){
        $logged_user  = Auth::user();
        $student_id   = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
        $course_title = DB::table('courses')->where('id','=',$course_id)->pluck('name');
        $course       = DB::table('courses')->where('id','=',$course_id)->first();

        $awaiting_feedback = count(DB::table('standard_courses_uploads')
            ->where('course_id', '=',$course_id)
            ->where('student_id','=',$student_id[0])
            ->where('status',    '=','awaiting_feedback')
            ->get());

        $next_assignment = DB::table('standard_courses_uploads')
            ->where('course_id', '=',$course_id)
            ->where('student_id','=',$student_id[0])
            ->where('status',    '=','pass')
            ->max('assignment_number');

        $my_course = DB::table('assigned_courses')
            ->where('student_id',  '=',$student_id[0])
            ->where('is_completed','=',0)
            ->where('course_id',   '=',$course_id)->first();

        $assessment_parent_units = DB::table('evidences')
            ->where('unit_parent','=',NULL)
            ->where('course_id',  '=',$course_id)
            ->orderBy('id','ASC')
            ->get();

        $assessment_children = array();
        foreach($assessment_parent_units as $parent){
            $assessment_children[$parent->unit_number] = DB::table('evidences')
                ->where('course_id',  '=',$course_id)
                ->where('main_parent','=',$parent->unit_number)
                ->orderBy('id','ASC')
                ->get();
        }

        $assessments = DB::table('assessments')
            ->where('course_id','=',$course_id)
            ->orderBy('id','ASC')->get();
        $material_file = DB::table('materials')
            ->where('course_specific','=',$course_id)->pluck('material_file');

        $params = [
            'course_id'                 => $course_id,
            'assessment_children'       => $assessment_children,
            'assessments'               => $assessments,
            'assessment_parent_units'   => $assessment_parent_units,
            'material_file'             => $material_file[0],
            'course_title'              => $course_title[0],
            'course'                    => $course,
            'student_id'                => $student_id[0],
            'next_assignment'           => $next_assignment+1,
            'awaiting_feedback'         => $awaiting_feedback,
        ];
        return view('courses/my-course-dash',compact('my_course', $my_course))->with($params);
    }

    //pdf reader, course material page
    public function courseMaterialReader($course_id,$page_var,Request $request){
        $logged_user = Auth::user();
        $student_id  = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
        $my_course   = DB::table('assigned_courses')
                        ->where('student_id',  '=',$student_id[0])
                        ->where('is_completed','=',0)
                        ->where('course_id',   '=',$course_id)->get();

        $course_notes = DB::table('course_notes')
                        ->where('student_id','=',$student_id[0])
                        ->where('page_var',  '=',$page_var)
                        ->where('course_id', '=',$course_id)->get();

        $material_file = DB::table('materials')
                        ->where('course_specific','=',$course_id)
                        ->pluck('material_file');

        $params = [
            'page_var'  => $page_var,
            'course_id'  => $course_id,
            'course_notes'  => $course_notes,
            'material_file'  => $material_file[0],
        ];
        return view('courses/my-course',compact('my_course', $my_course))->with($params);
    }

    //save notes
    public function saveCourseNotes($course_id,$page_var,Request $request){
        if ($request->ajax()) {
            $logged_user = Auth::user();
            $student_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');

            if($request->method == 'update_notes'){
                $notes = CourseNotes::find($request->id);
                $notes->notes_title = $request->notes_title;
                $notes->notes_description = $request->notes_description;
                $notes->save();
                $msg = 'Notes Updated Successfully';
            }

            if($request->method == 'new_notes'){
                $notes = new CourseNotes;
                $notes->notes_title = $request->notes_title;
                $notes->notes_description = $request->notes_description;
                $notes->student_id = $student_id[0];
                $notes->course_id = $course_id;
                $notes->page_var = $page_var;
                $notes->save();
                $msg = 'Notes Added Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //upload assignments
    public function uploadAssignment($course_id,Request $request){
        if ($request->ajax()) {
            $logged_user = Auth::user();
            $student_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');

            if($request->method === 'upload_assignment'){
                $assignment = new Assignment;
                $assignment->assignment_file = $request->assignment_file;
                $assignment->assignment_number = $request->assignment_number;
                $assignment->course_id = $course_id;
                $assignment->student_id = $student_id[0];
                $assignment->status = 'awaiting_feedback';

                if($request->hasFile('assignment_file')) {
                    $image_type = array('jpeg','jpg','bmp','png','gif','svg','docx','doc');
                    $file = $request->file('assignment_file');
                    //you also need to keep file extension as well
                    $name = $file->getClientOriginalName();
                    $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
                    if(in_array($ext,$image_type)){
                        $image['filePath'] = $name;
                        $file->move(public_path().'/assignments/', $name);
                        $assignment->assignment_file = '/assignments/'.$name;
                        $assignment->save();
                    }else{
                        return redirect()->back()->withInput()->with('error', 'File you are trying to upload is invalid');
                    }
                }
            }

            $image_file = '';
            if($request->method === 'upload_evidence'){
                $ids = array_filter(explode(',' , $request->selected_units_ids));
                $file_uploaded = false;
                foreach($ids as $chunk_id){
                    $assignment = new Assignment;
                    $assignment->assignment_file = $request->evidence_file;
                    $assignment->course_id = $course_id;
                    $assignment->student_id = $student_id[0];
                    $assignment->unit_evidence_id = $chunk_id;
                    $assignment->status = 'awaiting_feedback';

                    if(!$file_uploaded){
                        if($request->hasFile('evidence_file')) {
                            $image_type = array('jpeg','jpg','bmp','png','gif','svg','docx','doc');
                            $file = $request->file('evidence_file');
                            //you also need to keep file extension as well
                            $name = $file->getClientOriginalName();
                            $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
                            if(in_array($ext,$image_type)){
                                $image['filePath'] = $name;
                                $file->move(public_path().'/evidences/', $name);
                                $assignment->assignment_file = '/evidences/'.$name;
                                $image_file = $name;
                                $file_uploaded = true;
                            }else{
                                return redirect()->back()->withInput()->with('error', 'File you are trying to upload is invalid');
                            }
                        }
                    }else{
                        $assignment->assignment_file = $image_file;
                    }
                    $assignment->save();
                }
            }
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get student's incomplete assigned courses by student id AJAX
    public function getStudentIncompleteAssignedCoursesAJAX(Request $request){
        if ($request->ajax()) {
            $student_courses = DB::table('assigned_courses')
                ->where('student_id','=',$request->student_id)
                ->where('is_completed','=',0)
                ->orderBy('created_at','asc')
                ->get();

            $return_object = array();
            $student = DB::table('students')
                ->select('first_name','last_name')
                ->where('id','=',$request->student_id)
                ->first();

            $return_object['student_name'] = $student->first_name.' '.$student->last_name;
            $return_object['html'] = '';
            $return_object['html'] = '<table class="table" style="text-align: left;">
                                    <tr>
                                        <th class="course_col" scope="col">Course</th>
                                        <th class="rollno_col" scope="col">Feedback Action</th>
                                    </tr>
                                    <tbody>';

            foreach($student_courses as $item){
                $course = DB::table('courses')->select('name','type')->where('id','=',$item->course_id)->first();

                $return_object['html'] .= '<tr class="record_row record_'.$item->course_id.'">';
                $return_object['html'] .= '<td>'.$course->name.'</td><td>';
                if($course->type ==='standard'){
                    $return_object['html'] .= '<a href="#" id="mark_course_'.$item->course_id.'" onclick="assignmentMarking('.$request->student_id.','.$item->course_id.')" class="single_marking tiny-action-btn btn-outline-secondary " title="Give Assignment Feedback"><i class="fas fa-file"></i> Assignment Feedback</a>';
                }
                if($course->type ==='work_based'){
                    $return_object['html'] .= '<a href="#" id="mark_course_'.$item->course_id.'" onclick="evidenceMarking('.$request->student_id.','.$item->course_id.')" class="single_marking tiny-action-btn btn-outline-secondary " title="Give Evidence Feedback"><i class="fas fa-highlighter"></i> Evidence Feedback</a>';
                }
                $return_object['html'] .= '</td></tr>';
            }
            $return_object['html'] .= '</tbody></table>';
            return $return_object;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get student's incomplete assigned course assignment by student id & course id AJAX
    public function getStudentAssignedCourseAJAX(Request $request){
        if ($request->ajax()) {
            $course = DB::table('courses')
                ->where('id','=',$request->course_id)
                ->first();

            $return_object = array();
            $student = DB::table('students')
                ->select('first_name','last_name')
                ->where('id','=',$request->student_id)
                ->first();

            $assignment = DB::table('standard_courses_uploads')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->first();

            $feedback_template_ids = DB::table('marked_assignments')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->pluck('feedback_template_id');

            $feedback_template = DB::table('feedback_templates')
                ->where('course_id','=',$request->course_id)
                ->whereNotIn('id',$feedback_template_ids)
                ->inRandomOrder()
                ->first();

            if(empty($feedback_template)){
                $feedback_template = DB::table('feedback_templates')
                    ->where('course_id','=',$request->course_id)
                    ->inRandomOrder()
                    ->first();
            }

            $all_notes = DB::table('assignment_notes')
                ->where('course_id',    '=',$request->course_id)
                ->where('student_id',   '=',$request->student_id)
                ->where('assignment_id','=',$assignment->id)
                ->orderBy('id','DESC')
                ->get();

            $all_markers = DB::table('assignment_markers')
                ->where('course_id',    '=',$request->course_id)
                ->where('student_id',   '=',$request->student_id)
                ->where('assignment_id','=',$assignment->id)
                ->orderBy('id','DESC')
                ->get();

            $canned_responses = DB::table('canned_responses')
                //->where('course_id','=',$request->course_id)
                ->get();

            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';

            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['markers'] .= '</tbody></table>';

            $return_object['html'] = '';
            $return_object['html'] = '<div class="card no-padding"><div class="col-md-12 text-left">';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><h4>Student: <span class="text-muted">'.$student->first_name.' '.$student->last_name.'</span>  &nbsp;&nbsp; Course: <span class="text-muted">'.$course->name.'</span></h4></div>';
            $return_object['html'] .= '<div class="col-md-2" style="padding-left:0;"><a href="#" id="assignment_notes_btn" onclick="getAssignmentNotes('.$request->student_id.','.$request->course_id.','.$assignment->id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Notes ('.$all_notes->count().')</a></div>';
            $return_object['html'] .= '<div class="col-md-2"><a href="#" id="assignment_markers_btn" onclick="getAssignmentMarkers('.$request->student_id.','.$request->course_id.','.$assignment->id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Markers ('.$all_markers->count().')</a></div>';
            $return_object['html'] .= '<div class="col-md-4"><a href="#" id="view_all_evidence" onclick="getCourseAllEvidence('.$request->student_id.','.$request->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">View All Evidence(s)</a></div>';
            $return_object['html'] .= '<div class="col-md-4"><a class="btn btn-outline-secondary full-width tiny-action-btn" download href="'.url("/public/").$assignment->assignment_file.'" title="Download Assignment"><i class="fas fa-download"></i> Download Assignment</a></div>';
            $return_object['html'] .= '<div class="col-md-12 no-padding" style="padding: 15px 0 !important;"><hr/><div class="col-md-3 no-padding"><label>Mark All Completed <input type="radio" name="mark_all" id="mark_all_completed" onclick="setRadioActive(\'mark_all_completed\');" checked value="1"/></label></div>';
            $return_object['html'] .= '<div class="col-md-3 no-padding"><label>Mark All Progress <input type="radio" name="mark_all" id="mark_all_progress" onclick="setRadioActive(\'mark_all_progress\');" value="0"/></label></div></div>';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><hr/><label style="margin-bottom: 20px;">This portfolio is now complete and now can be signed off: <input type="checkbox" id="completed_portfolio" onclick="toggleCheckbox(\'completed_portfolio\');" value="0" /></label><hr/></div><a href="#" style="margin:10px 0;" class="btn btn-primary" id="mark_course_progress_btn" onclick="markCourseProgress('.$request->student_id.','.$request->course_id.');" title="Submit Course Feedback">Submit Feedback</a>';
            $return_object['html'] .= '<input type="hidden" id="course_progress_method" name="course_progress_method" value="course_marking"/>';
            $return_object['html'] .= '<input type="hidden" id="marking_course_id" name="marking_course_id" value="'.$request->course_id.'"/>';
            $return_object['html'] .= '<input type="hidden" id="marking_course_id" name="marking_student_id" value="'.$request->student_id.'"/>';
            $return_object['html'] .= '</div></div></div>';
            return $return_object;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get student's incomplete assigned work based course unit by student id & course id AJAX
    public function getStudentAssignedWorkBasedCourseAJAX(Request $request){
        if ($request->ajax()) {
            $course = DB::table('courses')
                ->where('id','=',$request->course_id)
                ->first();

            $return_object = array();
            $student = DB::table('students')
                ->select('first_name','last_name')
                ->where('id','=',$request->student_id)
                ->first();

            $units_uploads = DB::table('standard_courses_uploads')
                ->where('course_id',       '=',$request->course_id)
                ->where('student_id',      '=',$request->student_id)
                ->where('unit_evidence_id','<>',NULL)
                ->get();

            $uploaded_evidences = array();
            $array_counter = array();
            foreach($units_uploads as $upload){
                if(!in_array($upload->unit_evidence_id,$array_counter)){
                    $uploaded_evidences[] = $upload;
                    $array_counter[] = $upload->unit_evidence_id;
                }
            }

            $feedback_template_ids = DB::table('marked_assignments')
                ->where('course_id', '=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->pluck('feedback_template_id');

            $feedback_template = DB::table('feedback_templates')
                ->where('course_id','=',$request->course_id)
                ->whereNotIn('id',$feedback_template_ids)
                ->inRandomOrder()
                ->first();

            if(empty($feedback_template)){
                $feedback_template = DB::table('feedback_templates')
                    ->where('course_id','=',$request->course_id)
                    ->inRandomOrder()
                    ->first();
            }

            $all_notes = DB::table('course_notes')
                ->where('course_id', '=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->orderBy('id','DESC')
                ->get();

            //NEED UPDATED TO COURSE MARKERS at one point
            $all_markers = DB::table('assignment_markers')
                ->where('course_id', '=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->orderBy('id','DESC')
                ->get();

            $canned_responses = DB::table('canned_responses')
                ->get();

            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.(!empty($tutor)?$tutor->first_name.' '.$tutor->last_name: "").'</td>
                                        <td>'.$note->notes_title.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';

            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';
            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['markers'] .= '</tbody></table>';

            $return_object['html'] = '';
            $return_object['html'] = '<form id="unit_marking_form" action="'.url('/marking/list/1').'" method="POST">';
            $return_object['html'] .= '<div class="card no-padding"><div class="col-md-12 text-left">';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><h4>Student: <span class="text-muted">'.$student->first_name.' '.$student->last_name.'</span>  &nbsp;&nbsp; Course: <span class="text-muted">'.$course->name.'</span></h4></div>';
            $return_object['html'] .= '<div class="col-md-2" style="padding-left:0;"><a href="#" id="assignment_notes_btn" onclick="getCourseNotes('.$request->student_id.','.$request->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Notes ('.$all_notes->count().')</a></div>';
            $return_object['html'] .= '<div class="col-md-2"><a href="#" id="assignment_markers_btn" onclick="getCourseMarkers('.$request->student_id.','.$request->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Markers ()</a></div>';
            $return_object['html'] .= '<div class="col-md-4"><a href="#" id="view_all_evidence" onclick="getCourseAllEvidence('.$request->student_id.','.$request->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">View All Evidence(s)</a></div>';
            $return_object['html'] .= '<div class="col-md-12 no-padding" style="padding: 15px 0 !important;"><hr/><div class="col-md-3 no-padding"><label>Mark All Completed <input type="radio" name="mark_all_radio" id="mark_all_units_completed" onclick="setUnitRadioActive(\'mark_all_units_completed\');"/></label></div>';
            $return_object['html'] .= '<div class="col-md-3 no-padding"><label>Mark All Progress <input type="radio" name="mark_all_radio" id="mark_all_units_progress" onclick="setUnitRadioActive(\'mark_all_units_progress\');"/></label></div></div>';
            $return_object['html'] .= '<input id="mark_all_set" name="mark_all_set" value="" type="hidden"/>';
            $return_object['html'] .= '<table class="unit_table table text-left">
                                    <tr>
                                        <th class="course_name_col" scope="col">Unit Detail</th>
                                        <th class="unit_evidence_file_col" scope="col">Evidence</th>
                                        <th class="unit_actions_col" scope="col">Actions</th>
                                    </tr>
                                    <tbody>';
            foreach($uploaded_evidences as $evidence){
                $return_object['html'] .= '<tr>';
                $return_object['html'] .= '<td>';
                $unit = DB::table('evidences')->where('id','=',$evidence->unit_evidence_id)->first();
                $return_object['html'] .= $unit->unit_name;
                $return_object['html'] .= '<br>';
                $return_object['html'] .= $unit->evidence_description;
                $return_object['html'] .= '</td>';
                $return_object['html'] .= '<td>';
                $return_object['html'] .= '<a download href="'.url("/public").$evidence->assignment_file.'" title="Download File"><i class="fa fa-download"></i></a>';
                $return_object['html'] .= '</td>';
                $return_object['html'] .= '<td><label class="btn btn-outline-secondary pass_label"><input type="radio" id="radio_pass_'.$evidence->id.'" class="pass_progress_radio" name="radio_pass_progress_'.$evidence->id.'" onclick="setPassProgressRadioValue(';
                $return_object['html'] .= '\'pass\','.$evidence->id;
                $return_object['html'] .= ');" value="" style="margin-top: -2px;margin-right: 2px;"/> Pass</label>';
                $return_object['html'] .= '<label class="btn btn-outline-secondary progress_label"><input type="radio" id="radio_progress_'.$evidence->id.'" class="pass_progress_radio" name="radio_pass_progress_'.$evidence->id.'" onclick="setPassProgressRadioValue(';
                $return_object['html'] .= '\'progress\','.$evidence->id;
                $return_object['html'] .= ');" value="" style="margin-top: -2px;margin-right: 2px;"/> Progress</label></td>';
                $return_object['html'] .= '<input id="unit_status_'.$evidence->id.'" name="unit_status_'.$evidence->id.'" type="hidden" value=""/>';
                $return_object['html'] .= '</tr>';
                $return_object['html'] .= '<tr>';
                $return_object['html'] .= '<td colspan="4">';
                $return_object['html'] .= '<textarea id="unit_feedback_'.$evidence->id.'" name="unit_feedback_'.$evidence->id.'" col="4" rows="8" class="form-control lb-lg"></textarea>';
                $return_object['html'] .= '<div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;margin-top: 8px;"><h4 class="full-width" style="padding:5px 0;"><a href="#" onclick="slideUnitCannedResponsePanel('.$evidence->id.');" style="display:block" id="add_unit_canned_response_btn" class="full-width" title="Add Canned Responses">Canned Responses <i class="fas fa-chevron-down float-right"></i></a></h4>';
                $return_object['html'] .= '<div class="col-md-12 no-padding" id="unit_canned_responses_panel_'.$evidence->id.'" style="width:100%;display:none;">';
                foreach($canned_responses as $response){
                    $return_object['html'] .= '<label><a href="#" id="'.$response->id.'" onclick="getUnitCannedResponse('.$response->id.','.$evidence->id.')"><i class="fas fa-plus-circle"></i> <span id="unit_canned_content_'.$response->id.'">'.$response->comments.'</span></a></label><br>';
                }
                $return_object['html'] .= '</div></div>';
                $return_object['html'] .= '</td>';
            }
            $return_object['html'] .= '</tbody></table>';
            $return_object['html'] .= '<input type="hidden" id="mark_course_as_completed" name="mark_course_as_completed" value="0"/>';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><hr/><label style="margin-bottom: 20px;">This portfolio is now complete and now can be signed off: <input type="checkbox" id="completed_unit_portfolio" onclick="toggleUnitCheckbox(\'completed_unit_portfolio\');" value="0" /></label><hr/></div><a href="#" style="margin:10px 0;" class="btn btn-primary" id="mark_unit_course_progress_btn" onclick="markUnitCourseProgress('.$request->student_id.','.$request->course_id.');" title="Submit Course Feedback">Submit Feedback</a>';
            $return_object['html'] .= '<input type="hidden" id="unit_method" name="unit_method" value="unit_marking"/>';
            $return_object['html'] .= '<input type="hidden" id="marking_unit_course_id" name="marking_unit_course_id" value="'.$request->course_id.'"/>';
            $return_object['html'] .= '<input type="hidden" id="marking_unit_student_id" name="marking_unit_student_id" value="'.$request->student_id.'"/>';
            $return_object['html'] .= '</div></div></div>';
            $return_object['html'] .= '</form>';
            return $return_object;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get student's incomplete assigned course assignment by student id & course id AJAX
    public function getStudentIncompleteAssignedCourseAssignmentAJAX(Request $request){
        if ($request->ajax()) {
            $course = DB::table('courses')
                ->where('id','=',$request->course_id)
                ->first();

            $return_object = array();
            $student = DB::table('students')
                ->select('first_name','last_name')
                ->where('id','=',$request->student_id)
                ->first();

            $assignment = DB::table('standard_courses_uploads')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->where('status','<>','pass')
                ->first();

            $feedback_template_ids = DB::table('marked_assignments')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->pluck('feedback_template_id');

            $feedback_template = DB::table('feedback_templates')
                ->where('course_id','=',$request->course_id)
                ->whereNotIn('id',$feedback_template_ids)
                ->inRandomOrder()
                ->first();

            if(empty($feedback_template)){
                $feedback_template = DB::table('feedback_templates')
                    ->where('course_id','=',$request->course_id)
                    ->inRandomOrder()
                    ->first();
            }

            $all_notes = DB::table('assignment_notes')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->where('assignment_id','=',$assignment->id)
                ->orderBy('id','DESC')
                ->get();

            $all_markers = DB::table('assignment_markers')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->where('assignment_id','=',$assignment->id)
                ->orderBy('id','DESC')
                ->get();

            $canned_responses = DB::table('canned_responses')
                //->where('course_id','=',$request->course_id)
                ->get();

            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }

            $return_object['notes'] .= '</tbody></table>';

            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';
            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }

            $return_object['markers'] .= '</tbody></table>';
            $return_object['html'] = '';
            $return_object['html'] = '<div class="card no-padding"><div class="col-md-12 text-left">';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><h4>Student: <span class="text-muted">'.$student->first_name.' '.$student->last_name.'</span>  &nbsp;&nbsp; Course: <span class="text-muted">'.$course->name.'</span></h4></div>';
            $return_object['html'] .= '<div class="col-md-2 no-padding"><a href="#" id="assignment_notes_btn" onclick="getAssignmentNotes('.$request->student_id.','.$request->course_id.','.$assignment->id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Notes ('.$all_notes->count().')</a></div>';
            $return_object['html'] .= '<div class="col-md-2"><a href="#" id="assignment_markers_btn" onclick="getAssignmentMarkers('.$request->student_id.','.$request->course_id.','.$assignment->id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Markers ('.$all_markers->count().')</a></div>';
            $return_object['html'] .= '<div class="col-md-4"><label>Assignment Number: <span class="numeric_big">'.$assignment->assignment_number.'</span></label></div>';
            $return_object['html'] .= '<div class="col-md-4 no-padding"><a class="btn btn-outline-secondary tiny-action-btn float-right" download href="'.url("/public/").$assignment->assignment_file.'" title="Download Assignment"><i class="fas fa-download"></i> Download Assignment</a></div>';
            $return_object['html'] .= '<div class="col-md-5 no-padding"><label class="btn btn-outline-secondary" style="display: flex;width: 173px;margin: 10px 0;line-height: 26px;border-radius: 4px !important;"><span style="padding-right: 5px;">Save as template:</span> <input id="save_as_template" style="width: 16px;height: 25px;margin-top: 0px;" type="checkbox" class=""></label></div></div></div>';
            $return_object['html'] .= '<div class="col-md-12 no-padding">';
            $return_object['html'] .= '<div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;"><h4 style="padding:10px 0;">Feedback Template:</h4><textarea class="form-control lb-lg" id="template_content">'.$feedback_template->comments.'</textarea>';
            $return_object['html'] .= '</div><div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;margin-top: 8px;"><h4 class="full-width" style="padding:5px 0;"><a href="#" onclick="slideCannedResponsePanel();" style="display:block" id="add_canned_response_btn" class="full-width" title="Add Canned Responses">Canned Responses <i class="fas fa-chevron-down float-right"></i></a></h4>';
            $return_object['html'] .= '<div class="col-md-12 no-padding" id="canned_responses_panel" style="width:100%;display:none;">';
            foreach($canned_responses as $response){
                $return_object['html'] .= '<label><a href="#" id="'.$response->id.'" onclick="getCannedResponse('.$response->id.')"><i class="fas fa-plus-circle"></i> <span id="canned_content_'.$response->id.'">'.$response->comments.'</span></a></label><br>';
            }
            $return_object['html'] .= '</div></div>';
            $return_object['html'] .= '<div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;margin-top: 8px;">Grade Awarded: ';
            $return_object['html'] .= '<div class="btn-group" role="group">';
            $return_object['html'] .= '<button onclick="pass_refer(\'pass\');" style="margin: 10px 0;height: 30px;line-height: 24px;border-radius: 0 !important;" id="pass" type="button" class="btn btn-outline-secondary btn-group-ite '.(($feedback_template->grades_awarded == 'PASS')? "active" :"").'">PASS</button>';
            $return_object['html'] .= '<button onclick="pass_refer(\'refer\');" style="margin: 10px 0;height: 30px;line-height: 24px;" id="refer" type="button" class="btn btn-outline-secondary btn-group-item '.(($feedback_template->grades_awarded == 'refer')? "active" :"").'">REFER</button>';
            $return_object['html'] .= '<input type="hidden" id="grade_awarded_hidden" value="'.(($feedback_template->grades_awarded == 'PASS')? "pass" :"").(($feedback_template->grades_awarded == 'refer')? "refer" :"").'"/><input type="hidden" id="assignment_number" value="'.$assignment->assignment_number.'"/><input type="hidden" id="feedback_template_id" value="'.$feedback_template->id.'"/></div><div class="col-md-12 no-padding"><textarea placeholder="Further Action" class="form-control lb-lg" rows="10" id="additional_comments">'.(($feedback_template->grades_awarded == 'PASS')? $feedback_template->further_actions :"").(($feedback_template->grades_awarded == 'refer')? $feedback_template->further_actions_refer :"").'</textarea>';
            $return_object['html'] .= '<a href="#" style="margin:10px 0;" class="btn btn-primary" id="mark_assignment_btn" onclick="markAssignment('.$request->student_id.','.$request->course_id.','.$assignment->id.');" title="Mark Assignment">Mark Assignment</a>';
            $return_object['html'] .= '</div></div></div>';
            return $return_object;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get NEXT SAM ASSIGNMENT for marking automatically
    public function getNextSAMAssignmentMarkingAJAX(Request $request){
        if ($request->ajax()) {
            $sam_assignment = DB::table('standard_courses_uploads')
                ->where('unit_evidence_id','=',NULL)
                ->where('status','<>','pass')
                ->orderBy('created_at','ASC')//get first submitted assignment
                ->first();

            $course = DB::table('courses')
                ->where('id','=',$sam_assignment->course_id)
                ->first();

            $student = DB::table('students')
                ->select('first_name','last_name')
                ->where('id','=',$sam_assignment->student_id)
                ->first();

            $return_object = array();
            //if there is some assignment to mark
            if(!empty($sam_assignment)){
                $feedback_template_ids = DB::table('marked_assignments')
                    ->where('course_id','=',$sam_assignment->course_id)
                    ->where('student_id','=',$sam_assignment->student_id)
                    ->pluck('feedback_template_id');

                $feedback_template = DB::table('feedback_templates')
                    ->where('course_id','=',$sam_assignment->course_id)
                    ->whereNotIn('id',$feedback_template_ids)
                    ->inRandomOrder()
                    ->first();

                if(empty($feedback_template)){
                    $feedback_template = DB::table('feedback_templates')
                        ->where('course_id','=',$sam_assignment->course_id)
                        ->inRandomOrder()
                        ->first();
                }

                $all_notes = DB::table('assignment_notes')
                    ->where('course_id','=',$sam_assignment->course_id)
                    ->where('student_id','=',$sam_assignment->student_id)
                    ->where('assignment_id','=',$sam_assignment->id)
                    ->orderBy('id','DESC')
                    ->get();

                $all_markers = DB::table('assignment_markers')
                    ->where('course_id','=',$sam_assignment->course_id)
                    ->where('student_id','=',$sam_assignment->student_id)
                    ->where('assignment_id','=',$sam_assignment->id)
                    ->orderBy('id','DESC')
                    ->get();

                $canned_responses = DB::table('canned_responses')
                    //->where('course_id','=',$sam_assignment->course_id)
                    ->get();

                $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

                foreach($all_notes as $note){
                    $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                    $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
                }

                $return_object['notes'] .= '</tbody></table>';
                $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

                foreach($all_markers as $marker){
                    $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                    $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
                }

                $return_object['markers'] .= '</tbody></table>';

                $return_object['html'] = '';
                $return_object['html'] = '<div class="card no-padding"><div class="col-md-12 text-left">';
                $return_object['html'] .= '<div class="col-md-12 no-padding"><h4>Student: <span class="text-muted">'.$student->first_name.' '.$student->last_name.'</span>  &nbsp;&nbsp; Course: <span class="text-muted">'.$course->name.'</span></h4></div>';
                $return_object['html'] .= '<div class="col-md-2 no-padding"><a href="#" id="assignment_notes_btn" onclick="getAssignmentNotes('.$sam_assignment->student_id.','.$sam_assignment->course_id.','.$sam_assignment->id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Notes ('.$all_notes->count().')</a></div>';
                $return_object['html'] .= '<div class="col-md-2"><a href="#" id="assignment_markers_btn" onclick="getAssignmentMarkers('.$sam_assignment->student_id.','.$sam_assignment->course_id.','.$sam_assignment->id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Markers ('.$all_markers->count().')</a></div>';
                $return_object['html'] .= '<div class="col-md-4"><label>Assignment Number: <span class="numeric_big">'.$sam_assignment->assignment_number.'</span></label></div>';
                $return_object['html'] .= '<div class="col-md-4 no-padding"><a class="btn btn-outline-secondary tiny-action-btn float-right" download href="'.url("/public/").$sam_assignment->assignment_file.'" title="Download Assignment"><i class="fas fa-download"></i> Download Assignment</a></div>';
                $return_object['html'] .= '<div class="col-md-5 no-padding"><label class="btn btn-outline-secondary" style="display: flex;width: 173px;margin: 10px 0;line-height: 26px;border-radius: 4px !important;"><span style="padding-right: 5px;">Save as template:</span> <input id="save_as_template" style="width: 16px;height: 25px;margin-top: 0px;" type="checkbox" class=""></label></div></div></div>';
                $return_object['html'] .= '<div class="col-md-12 no-padding">';
                $return_object['html'] .= '<div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;"><h4 style="padding:10px 0;">Feedback Template:</h4><textarea class="form-control lb-lg" id="template_content">'.$feedback_template->comments.'</textarea>';
                $return_object['html'] .= '</div><div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;margin-top: 8px;"><h4 class="full-width" style="padding:5px 0;"><a href="#" onclick="slideCannedResponsePanel();" style="display:block" id="add_canned_response_btn" class="full-width" title="Add Canned Responses">Canned Responses <i class="fas fa-chevron-down float-right"></i></a></h4>';
                $return_object['html'] .= '<div class="col-md-12 no-padding" id="canned_responses_panel" style="width:100%;display:none;">';
                foreach($canned_responses as $response){
                    $return_object['html'] .= '<label><a href="#" id="'.$response->id.'" onclick="getCannedResponse('.$response->id.')"><i class="fas fa-plus-circle"></i> <span id="canned_content_'.$response->id.'">'.$response->comments.'</span></a></label><br>';
                }
                $return_object['html'] .= '</div></div>';
                $return_object['html'] .= '<div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;margin-top: 8px;">Grade Awarded: ';
                $return_object['html'] .= '<div class="btn-group" role="group">';
                $return_object['html'] .= '<button onclick="pass_refer(\'pass\');" style="margin: 10px 0;height: 30px;line-height: 24px;border-radius: 0 !important;" id="pass" type="button" class="btn btn-outline-secondary btn-group-ite '.(($feedback_template->grades_awarded == 'PASS')? "active" :"").'">PASS</button>';
                $return_object['html'] .= '<button onclick="pass_refer(\'refer\');" style="margin: 10px 0;height: 30px;line-height: 24px;" id="refer" type="button" class="btn btn-outline-secondary btn-group-item '.(($feedback_template->grades_awarded == 'refer')? "active" :"").'">REFER</button>';
                $return_object['html'] .= '<input type="hidden" id="grade_awarded_hidden" value="'.(($feedback_template->grades_awarded == 'PASS')? "pass" :"").(($feedback_template->grades_awarded == 'refer')? "refer" :"").'"/><input type="hidden" id="assignment_number" value="'.$sam_assignment->assignment_number.'"/><input type="hidden" id="feedback_template_id" value="'.$feedback_template->id.'"/></div><div class="col-md-12 no-padding"><textarea placeholder="Further Action" class="form-control lb-lg" rows="10" id="additional_comments">'.(($feedback_template->grades_awarded == 'PASS')? $feedback_template->further_actions :"").(($feedback_template->grades_awarded == 'refer')? $feedback_template->further_actions_refer :"").'</textarea>';
                $return_object['html'] .= '<a href="#" style="margin:10px 0;" class="btn btn-primary" id="mark_assignment_btn" onclick="markAssignment('.$sam_assignment->student_id.','.$sam_assignment->course_id.','.$sam_assignment->id.');" title="Mark Assignment">Mark Assignment</a>';
                $return_object['html'] .= '</div></div></div>';
                return $return_object;
            }else{
                echo 'There is no assignment to mark.\n';
            }
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //get NEXT SAM Evidence for marking automatically
    public function getNextSAMEvidenceMarkingAJAX(Request $request){
        if ($request->ajax()) {
            //get first submitted evidence - by default
            $sam_evidence = DB::table('standard_courses_uploads')
                ->where('unit_evidence_id','<>',NULL)
                ->where('status','<>','pass')
                ->orderBy('created_at','ASC')
                ->first();

            $course = DB::table('courses')
                ->where('id','=',$sam_evidence->course_id)
                ->first();

            $return_object = array();
            $student = DB::table('students')
                ->select('first_name','last_name')
                ->where('id','=',$sam_evidence->student_id)
                ->first();

            $units_uploads = DB::table('standard_courses_uploads')
                ->where('course_id','=',$sam_evidence->course_id)
                ->where('student_id','=',$sam_evidence->student_id)
                ->where('unit_evidence_id','<>',NULL)
                ->get();

            $uploaded_evidences = array();
            $array_counter = array();
            foreach($units_uploads as $upload){
                if(!in_array($upload->unit_evidence_id,$array_counter)){
                    $uploaded_evidences[] = $upload;
                    $array_counter[] = $upload->unit_evidence_id;
                }
            }

            $all_notes = DB::table('course_notes')
                ->where('course_id','=',$sam_evidence->course_id)
                ->where('student_id','=',$sam_evidence->student_id)
                ->orderBy('id','DESC')
                ->get();

            //NEED UPDATED TO COURSE MARKERS at one point
            $all_markers = DB::table('course_markers')
                ->where('course_id','=',$sam_evidence->course_id)
                ->where('student_id','=',$sam_evidence->student_id)
                ->orderBy('id','DESC')
                ->get();

            $canned_responses = DB::table('canned_responses')
                //->where('course_id','=',$sam_evidence->course_id)
                ->get();

            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.(!empty($tutor)?$tutor->first_name.' '.$tutor->last_name: "").'</td>
                                        <td>'.$note->notes_title.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';

            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['markers'] .= '</tbody></table>';

            $return_object['html'] = '';
            $return_object['html'] = '<form id="unit_marking_form" action="'.url('/marking/list/1').'" method="POST">';
            $return_object['html'] .= '<div class="card no-padding"><div class="col-md-12 text-left">';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><h4>Student: <span class="text-muted">'.$student->first_name.' '.$student->last_name.'</span>  &nbsp;&nbsp; Course: <span class="text-muted">'.$course->name.'</span></h4></div>';
            $return_object['html'] .= '<div class="col-md-2" style="padding-left:0;"><a href="#" id="assignment_notes_btn" onclick="getCourseNotes('.$sam_evidence->student_id.','.$sam_evidence->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Notes ('.$all_notes->count().')</a></div>';
            $return_object['html'] .= '<div class="col-md-2"><a href="#" id="assignment_markers_btn" onclick="getCourseMarkers('.$sam_evidence->student_id.','.$sam_evidence->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">Markers ()</a></div>';
            $return_object['html'] .= '<div class="col-md-4"><a href="#" id="view_all_evidence" onclick="getCourseAllEvidence('.$sam_evidence->student_id.','.$sam_evidence->course_id.')" class="btn btn-outline-secondary full-width tiny-action-btn">View All Evidence(s)</a></div>';
            $return_object['html'] .= '<div class="col-md-12 no-padding" style="padding: 15px 0 !important;"><hr/><div class="col-md-3 no-padding"><label>Mark All Completed <input type="radio" name="mark_all_radio" id="mark_all_units_completed" onclick="setUnitRadioActive(\'mark_all_units_completed\');"/></label></div>';
            $return_object['html'] .= '<div class="col-md-3 no-padding"><label>Mark All Progress <input type="radio" name="mark_all_radio" id="mark_all_units_progress" onclick="setUnitRadioActive(\'mark_all_units_progress\');"/></label></div></div>';
            $return_object['html'] .= '<input id="mark_all_set" name="mark_all_set" value="" type="hidden"/>';
            $return_object['html'] .= '<table class="unit_table table text-left">
                                    <tr>
                                        <th class="course_name_col" scope="col">Unit Detail</th>
                                        <th class="unit_evidence_file_col" scope="col">Evidence</th>
                                        <th class="unit_actions_col" scope="col">Actions</th>
                                    </tr>
                                    <tbody>';
            foreach($uploaded_evidences as $evidence){
                $return_object['html'] .= '<tr>';
                $return_object['html'] .= '<td>';
                $unit = DB::table('evidences')->where('id','=',$evidence->unit_evidence_id)->first();
                $return_object['html'] .= $unit->unit_name;
                $return_object['html'] .= '<br>';
                $return_object['html'] .= $unit->evidence_description;
                $return_object['html'] .= '</td>';
                $return_object['html'] .= '<td>';
                $return_object['html'] .= '<a download href="'.url("/public").$evidence->assignment_file.'" title="Download File"><i class="fa fa-download"></i></a>';
                $return_object['html'] .= '</td>';
                $return_object['html'] .= '<td><label class="btn btn-outline-secondary pass_label"><input type="radio" id="radio_pass_'.$evidence->id.'" class="pass_progress_radio" name="radio_pass_progress_'.$evidence->id.'" onclick="setPassProgressRadioValue(';
                $return_object['html'] .= '\'pass\','.$evidence->id;
                $return_object['html'] .= ');" value="" style="margin-top: -2px;margin-right: 2px;"/> Pass</label>';
                $return_object['html'] .= '<label class="btn btn-outline-secondary progress_label"><input type="radio" id="radio_progress_'.$evidence->id.'" class="pass_progress_radio" name="radio_pass_progress_'.$evidence->id.'" onclick="setPassProgressRadioValue(';
                $return_object['html'] .= '\'progress\','.$evidence->id;
                $return_object['html'] .= ');" value="" style="margin-top: -2px;margin-right: 2px;"/> Progress</label></td>';
                $return_object['html'] .= '<input id="unit_status_'.$evidence->id.'" name="unit_status_'.$evidence->id.'" type="hidden" value=""/>';
                $return_object['html'] .= '</tr>';
                $return_object['html'] .= '<tr>';
                $return_object['html'] .= '<td colspan="4">';
                $return_object['html'] .= '<textarea id="unit_feedback_'.$evidence->id.'" name="unit_feedback_'.$evidence->id.'" col="4" rows="8" class="form-control lb-lg"></textarea>';
                $return_object['html'] .= '<div class="col-md-12 text-left" style="border: 1px solid #dcdcdc;border-radius: 6px;margin-top: 8px;"><h4 class="full-width" style="padding:5px 0;"><a href="#" onclick="slideUnitCannedResponsePanel('.$evidence->id.');" style="display:block" id="add_unit_canned_response_btn" class="full-width" title="Add Canned Responses">Canned Responses <i class="fas fa-chevron-down float-right"></i></a></h4>';
                $return_object['html'] .= '<div class="col-md-12 no-padding" id="unit_canned_responses_panel_'.$evidence->id.'" style="width:100%;display:none;">';
                foreach($canned_responses as $response){
                    $return_object['html'] .= '<label><a href="#" id="'.$response->id.'" onclick="getUnitCannedResponse('.$response->id.','.$evidence->id.')"><i class="fas fa-plus-circle"></i> <span id="unit_canned_content_'.$response->id.'">'.$response->comments.'</span></a></label><br>';
                }
                $return_object['html'] .= '</div></div>';
                $return_object['html'] .= '</td>';
            }
            $return_object['html'] .= '</tbody></table>';
            $return_object['html'] .= '<input type="hidden" id="mark_course_as_completed" name="mark_course_as_completed" value="0"/>';
            $return_object['html'] .= '<div class="col-md-12 no-padding"><hr/><label style="margin-bottom: 20px;">This portfolio is now complete and now can be signed off: <input type="checkbox" id="completed_unit_portfolio" onclick="toggleUnitCheckbox(\'completed_unit_portfolio\');" value="0" /></label><hr/></div><a href="#" style="margin:10px 0;" class="btn btn-primary" id="mark_sam_unit_course_progress_btn" onclick="markSAMUnitCourseProgress('.$sam_evidence->student_id.','.$sam_evidence->course_id.');" title="Submit Course Feedback">Submit Feedback</a>';
            $return_object['html'] .= '<input type="hidden" id="unit_method" name="unit_method" value="unit_marking"/>';
            $return_object['html'] .= '<input type="hidden" id="marking_unit_course_id" name="marking_unit_course_id" value="'.$sam_evidence->course_id.'"/>';
            $return_object['html'] .= '<input type="hidden" id="marking_unit_student_id" name="marking_unit_student_id" value="'.$sam_evidence->student_id.'"/>';
            $return_object['html'] .= '</div></div></div>';
            $return_object['html'] .= '</form>';
            return $return_object;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    private $pageLimit;
    //student courses
    public function showMyCourses($page_var,Request $request){
        $logged_user = Auth::user();
        $student_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
        $my_courses = DB::table('assigned_courses')
            ->where('student_id','=',$student_id[0])
            ->where('is_completed','=',0);
        $total = $my_courses->count();
        $this->pageLimit = 10;
        //get page limit from the form post variable
        if($this->pageLimit === 10){
            // how many records to get
            $query = $my_courses->take($this->pageLimit);
            //how many records to skip
            $query = $query->skip( ($page_var-1) * $this->pageLimit );
            //total pages
            $totalPages = ceil($total / $this->pageLimit);
        }
        // check if enter page_var value is okay for pagination
        if($page_var > $totalPages){
            $page_var = 1;
        }
        $query->orderBy('created_at', 'desc');
        $my_courses = $my_courses->get();
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('courses/my-courses',compact('my_courses', $my_courses))->with($params);
    }

    //edit course
    public function editCourse(Request $request){
        if ($request->ajax()) {
            //updating course
            if($request->method === 'course_edit') {
                $course = Course::find($request->edit_course_id);
                $course->name = $request->edit_course_name;
                $course->description = $request->edit_description;
                $course->full_price = $request->edit_full_price;
                $course->deposit = $request->edit_course_deposit;
                $course->instalment_price = $request->edit_instalment_price;
                $course->support_price = $request->edit_support_price;
                $course->sale_price = $request->edit_sale_price;
                $course->number_of_assignments = $request->edit_number_of_assignments;
                $course->type = $request->edit_type;
                $course->save();
                $msg = 'Course Updated Successfully';
            }

            //new feedback template for course
            if($request->method === 'new_feedback') {
                $feedback = new Feedback;
                $feedback->assignment_number = $request->assignment_number;
                $feedback->course_id = $request->feedback_course_id;
                $feedback->comments = $request->comments;
                $feedback->grades_awarded = $request->grades_awarded;
                $feedback->further_actions = $request->further_actions;
                $feedback->further_actions_refer = $request->further_actions_refer;
                $feedback->assignment_type = $request->assignment_type;
                $feedback->save();
                $msg = 'Feedback Template Added Successfully';
            }

            //update feedback template for course
            if($request->method === 'edit_feedback') {
                $feedback = Feedback::find($request->edit_feedback_id);
                $feedback->assignment_number = $request->edit_assignment_number;
                $feedback->comments = $request->edit_comments;
                $feedback->further_actions = $request->edit_further_actions;
                $feedback->further_actions_refer = $request->edit_further_actions_refer;
                $feedback->save();
                $msg = 'Feedback Template Updated Successfully';
            }

            if($request->method === 'new_evidence') {
                $evidence = new Evidence;
                $evidence->course_id = $request->new_evidence_course_id;
                if(!empty($request->parent_unit)){
                    $evidence->main_parent = $request->parent_unit;
                }else{
                    $evidence->main_parent = $request->unit_number;
                    $evidence->unit_parent = $request->unit_number;
                }

                if(!empty($request->input('child_sub_unit_'.$request->parent_unit))){
                    $evidence->unit_parent = $request->input('child_sub_unit_'.$request->parent_unit);
                }else{
                    $evidence->unit_parent = $request->parent_unit;
                }

                $evidence->unit_number = $request->unit_number;
                $evidence->unit_name = $request->unit_name;
                $evidence->evidence_description = $request->evidence_description;
                $evidence->evidence_documents_required = $request->evidence_documents_required;
                $evidence->save();
                $msg = 'Evidence Created Successfully';
            }

            if($request->method === 'edit_evidence') {
                $evidence = Evidence::find($request->edit_evidence_id);
                $evidence->unit_parent = $request->edit_parent_unit;
                $evidence->unit_number = $request->edit_unit_number;
                $evidence->unit_name = $request->edit_unit_name;
                $evidence->evidence_description = $request->edit_evidence_description;
                $evidence->evidence_documents_required = $request->edit_evidence_documents_required;
                $evidence->save();
                $msg = 'Evidence Updated Successfully';
            }

            if($request->method === 'new_assessment') {
                $assessment = new Assessment;
                $assessment->course_id = $request->new_assessment_course_id;
                $assessment->unit_id = $request->unit_id;
                $assessment->detail = $request->assessment_detail;
                $assessment->units_required = $request->selected_units;
                $assessment->save();
                $msg = 'Assessment Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }else{
            //new canned response
            if($request->method === 'new_canned_response') {
                $canned_response = new CannedResponse;
                $canned_response->course_id = $request->canned_response_course_id;
                $canned_response->comments = $request->comments;
                $canned_response->type = $request->type;
                $canned_response->save();
                $msg = 'Canned Response Template Added Successfully';
                return redirect()->back()->withInput()->with('message', $msg);
            }

            //new canned response
            if($request->method === 'edit_canned_response') {
                $canned_response = CannedResponse::find($request->edit_canned_id);
                $canned_response->comments = $request->edit_canned_comments;
                $canned_response->type = $request->edit_canned_type;
                $canned_response->save();
                $msg = 'Canned Response Template Updated Successfully';
                return redirect()->back()->withInput()->with('message', $msg);
            }
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //add course page
    public function addCourse(Request $request){
        if ($request->ajax()) {
            if($request->method === 'new_course') {
                $course = new Course;
                $course->name = $request->course_name;
                $course->description = $request->description;
                $course->full_price = $request->full_price;
                $course->deposit = $request->course_deposit;
                $course->instalment_price = $request->instalment_price;
                $course->support_price = $request->support_price;
                $course->sale_price = $request->sale_price;
                $course->number_of_assignments = $request->number_of_assignments;
                $course->type = $request->type;
                $course->save();

                //create pre-emptive feedback template(s) for course
                for($n = 1; $n <= $request->number_of_assignments; $n++){
                    $feedback_template = new Feedback;
                    $feedback_template->course_id = $course->id;
                    $feedback_template->assignment_number = $n;//by default only
                    $feedback_template->comments = $request->comments;
                    $feedback_template->grades_awarded = 'PASS';
                    $feedback_template->further_actions = 'Congratulations you have passed this assignment! You may now move on to the next one. Good luck!';
                    $feedback_template->further_actions_refer = 'Unfortunately you have not met the requirements at this stage. Please re-submit in line with the above.';
                    $feedback_template->assignment_type = $request->assignment_type;
                    $feedback_template->save();
                }
                $msg = 'Course Added Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //mark standard course assignment
    public function markStudentAssignment(Request $request){
        if ($request->ajax()) {
            //mark standard course assignment
            if($request->method === 'mark_assignment') {
                $mark_assignment = new MarkAssignment;
                $mark_assignment->feedback_template_id = $request->feedback_template_id;
                $mark_assignment->course_id = $request->course_id;
                $mark_assignment->student_id = $request->student_id;
                $mark_assignment->assignment_id = $request->assignment_id;
                $mark_assignment->feedback_content = $request->template_content;
                $mark_assignment->comments = $request->additional_comments;
                $mark_assignment->save();

                $assignment = Assignment::where('id','=',$request->assignment_id)
                    ->update(['status' => $request->grade_awarded_hidden]);

                //save custom data as template
                if($request->save_as_template === 'on'){
                    $template = new Feedback;
                    $template->course_id = $request->course_id;
                    $template->assignment_number = $request->assignment_number;
                    $template->comments = $request->template_content;
                    $template->grades_awarded = $request->grade_awarded_hidden;
                    if($request->grade_awarded_hidden === 'pass'){
                        $template->further_actions = $request->additional_comments;
                    }
                    if($request->grade_awarded_hidden === 'refer'){
                        $template->further_actions_refer = $request->additional_comments;
                    }
                    $template->save();
                }
                $msg = 'success';
            }
           return $msg;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //extend student course subscription
    public function extendStudentCourseSubscriptionAJAX(Request $request){
        if ($request->ajax()) {
            $update_assigned_course = AssignedCourse::find($request->assigned_course_id);
            $update_assigned_course->expiry_date = Carbon::parse($update_assigned_course->expiry_date)->addDays($request->extension_period);
            //$update_assigned_course->expiry_date = $update_assigned_course->expiry_date->addDays($request->extension_period);
            $update_assigned_course->save();
            $msg = 'success';
            return $msg;
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    public function markCourseProgress(Request $request){
        $logged_user = Auth::user();
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_user->id)->pluck('id');

        //mark course progress/complete
        if($request->method === 'course_marking'){
            //get course type
            $course_type = DB::table('courses')->where('id','=',$request->course_id)->pluck('type');
            //mark all assignments / evidence completed
            if($request->mark_all_completed == '1'){
                if($course_type[0] == 'standard'){
                    $assignments = Assignment::where('course_id','=',$request->course_id)
                        ->where('student_id','=',$request->student_id)
                        ->update(['status' => 'pass']);
                }
            }

            if($request->mark_all_progress == '1'){
                if($course_type[0] == 'standard'){
                    //mark all assignments completed
                    $assignments = Assignment::where('course_id','=',$request->course_id)
                        ->where('student_id','=',$request->student_id)
                        ->update(['status' => 'refer']);
                }
            }
            if($request->completed_portfolio == '1'){
                $assigned_course = AssignedCourse::where('course_id','=',$request->course_id)
                    ->where('student_id','=',$request->student_id)
                    ->update(['is_completed' => 1]);
            }
            $return_object['msg'] = 'Course Marking Completed';
            return $return_object;
        }
    }

    //SAM Course UNIT marking
    public function markSAMUnitCourseProgress(Request $request){
        $logged_user = Auth::user();
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_user->id)->pluck('id');

        //mark course progress / complete
        if($request->unit_method === 'unit_marking'){
            //get course type
            $course_type = DB::table('courses')->where('id','=',$request->marking_unit_course_id)->pluck('type');
            //mark all assignments / evidence completed
            if($request->mark_all_set == 'all_pass'){
                if($course_type[0] == 'work_based'){
                   $assignments = Assignment::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['status' => 'pass']);
                }

                if($request->mark_course_as_completed == '1'){
                    $assigned_course = AssignedCourse::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['is_completed' => 1]);
                }
                $return_object['msg'] = 'Course Marking Completed';
                return $return_object;
            }

            if($request->mark_all_set == 'all_progress'){
                if($course_type[0] == 'work_based'){
                    //mark all assignments completed
                    $assignments = Assignment::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['status' => 'refer']);
                }
                if($request->mark_course_as_completed == '1'){
                    $assigned_course = AssignedCourse::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['is_completed' => 1]);
                }
                $return_object['msg'] = 'Course Marking Completed';
                return $return_object;
            }

            //if not marked all set to progress or pass
            //start marking one by one now
            $evidences = DB::table('standard_courses_uploads')
                ->where('course_id','=',$request->marking_unit_course_id)
                ->where('student_id','=',$request->marking_unit_student_id)
                ->get();

            foreach($evidences as $evidence){
                if($request->input('unit_status_'.$evidence->id) !== '' ){
                    if($request->input('unit_status_'.$evidence->id) == 1){
                        //pass it
                        $a =  Assignment::where('id','=',$evidence->id)
                            ->update(['status' => 'pass']);
                        $e = MarkEvidence::firstOrNew(array(
                            'course_id' => $request->marking_unit_course_id,
                            'student_id' => $request->marking_unit_student_id,
                            'evidence_id' => $evidence->id,
                        ));
                        $e->comments = $request->input('unit_feedback_'.$evidence->id);
                        $e->save();
                    }

                    if($request->input('unit_status_'.$evidence->id) == 0){
                        //progress it
                        $a =  Assignment::where('id','=',$evidence->id)
                            ->update(['status' => 'refer']);

                        $e = MarkEvidence::firstOrNew(array(
                            'course_id' => $request->marking_unit_course_id,
                            'student_id' => $request->marking_unit_student_id,
                            'evidence_id' => $evidence->id,
                        ));
                        $e->comments = $request->input('unit_feedback_'.$evidence->id);
                        $e->save();
                    }
                }
            }
            $return_object['msg'] = 'Course Marking Completed';
            return $return_object;
        }
    }

    public function markUnitCourseProgress(Request $request){
        $logged_user = Auth::user();
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_user->id)->pluck('id');

        //mark course progress / complete
        if($request->unit_method === 'unit_marking'){
            //get course type
            $course_type = DB::table('courses')->where('id','=',$request->marking_unit_course_id)->pluck('type');
            //mark all assignments / evidence completed
            if($request->mark_all_set == 'all_pass'){
                if($course_type[0] == 'work_based'){
                    $assignments = Assignment::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['status' => 'pass']);
                }

                if($request->mark_course_as_completed == '1'){
                    $assigned_course = AssignedCourse::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['is_completed' => 1]);
                    $return_object['msg'] = 'Course Marking Completed';
                    return $return_object;
                }
            }

            if($request->mark_all_set == 'all_progress'){
                if($course_type[0] == 'work_based'){
                    //mark all assignments completed
                    $assignments = Assignment::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['status' => 'refer']);
                }

                if($request->mark_course_as_completed == '1'){
                    $assigned_course = AssignedCourse::where('course_id','=',$request->marking_unit_course_id)
                        ->where('student_id','=',$request->marking_unit_student_id)
                        ->update(['is_completed' => 1]);
                    $return_object['msg'] = 'Course Marking Completed';
                    return $return_object;
                }
            }

            //if not marked all set to progress or pass
            //start marking one by one now
            $evidences = DB::table('standard_courses_uploads')
                ->where('course_id','=',$request->marking_unit_course_id)
                ->where('student_id','=',$request->marking_unit_student_id)
                ->get();

            foreach($evidences as $evidence){
                if($request->input('unit_status_'.$evidence->id) !== '' ){
                    if($request->input('unit_status_'.$evidence->id) == 1){
                        //pass it
                        $a =  Assignment::where('id','=',$evidence->id)
                            ->update(['status' => 'pass']);

                        $e = MarkEvidence::firstOrNew(array(
                            'course_id' => $request->marking_unit_course_id,
                            'student_id' => $request->marking_unit_student_id,
                            'evidence_id' => $evidence->id,
                            ));
                        $e->comments = $request->input('unit_feedback_'.$evidence->id);
                        $e->save();
                    }

                    if($request->input('unit_status_'.$evidence->id) == 0){
                        //progress it
                        $a =  Assignment::where('id','=',$evidence->id)
                            ->update(['status' => 'refer']);

                        $e = MarkEvidence::firstOrNew(array(
                            'course_id' => $request->marking_unit_course_id,
                            'student_id' => $request->marking_unit_student_id,
                            'evidence_id' => $evidence->id,
                        ));
                        $e->comments = $request->input('unit_feedback_'.$evidence->id);
                        $e->save();
                    }
                }
            }
            $return_object['msg'] = 'Course Marking Completed';
            return $return_object;
        }
    }

    // course marking + approve pending resource
    public function courseMarking(Request $request){
        if($request->method === 'new_canned_response') {
            $canned_response = new CannedResponse;
            $canned_response->course_id = $request->canned_response_course_id;
            $canned_response->comments = $request->comments;
            $canned_response->type = $request->type;
            $canned_response->save();
            $msg = 'Canned Response Template Added Successfully';
            return redirect()->back()->withInput()->with('message', $msg);
        }

        if($request->method === 'approve_resource') {
            $resource = Resource::find($request->approve_id);
            $resource->is_approved = 1;
            $resource->save();
            $msg = 'Resource Approved Successfully';
        }

        $logged_user = Auth::user();
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_user->id)->pluck('id');

        if($request->method === 'add_note') {
            $note = new AssignmentNote;
            $note->tutor_id = $tutor_id[0];
            $note->course_id = $request->note_course_id;
            $note->student_id = $request->note_student_id;
            $note->assignment_id = $request->note_assignment_id;
            $note->note = $request->note;
            $note->save();
            $return_object['msg'] = 'Note Added Successfully';

            $all_notes = DB::table('assignment_notes')
                ->where('course_id','=',$request->note_course_id)
                ->where('student_id','=',$request->note_student_id)
                ->where('assignment_id','=',$request->note_assignment_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['msg'] = 'Note Added Successfully';
            $return_object['notes'] = '';
            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';
            return $return_object;
        }

        if($request->method === 'add_course_note') {
            $note = new CourseNotes;
            $note->tutor_id = $tutor_id[0];
            $note->course_id = $request->note_course_id;
            $note->student_id = $request->note_student_id;
            $note->note = $request->note;
            $note->save();
            $return_object['msg'] = 'Note Added Successfully';

            $all_notes = DB::table('course_notes')
                ->where('course_id','=',$request->note_course_id)
                ->where('student_id','=',$request->note_student_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['msg'] = 'Note Added Successfully';
            $return_object['notes'] = '';
            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';
            return $return_object;
        }

        if($request->post_method == 'delete_course_note'){
            DB::table("course_notes")->where('id','=',$request->note_id)->delete();
            $all_notes = DB::table('course_notes')
                ->where('course_id','=',$request->course_id)
                ->where('student_id','=',$request->student_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['msg'] = 'success';
            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';
            return $return_object;
        }

        if($request->post_method == 'delete_note'){
            DB::table("assignment_notes")->where('id','=',$request->note_id)->delete();
            $all_notes = DB::table('assignment_notes')
                ->where('course_id','=',    $request->course_id)
                ->where('student_id','=',   $request->student_id)
                ->where('assignment_id','=',$request->assignment_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['msg'] = 'success';
            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';
            return $return_object;
        }

        if($request->method === 'add_marker') {
            $marker = new AssignmentMarker;
            $marker->tutor_id = $tutor_id[0];
            $marker->course_id = $request->marker_course_id;
            $marker->student_id = $request->marker_student_id;
            $marker->assignment_id = $request->marker_assignment_id;
            $marker->marker = $request->marker;
            $marker->save();
            $return_object['msg'] = 'Marker Added Successfully';

            $all_markers = DB::table('assignment_markers')
                ->where('course_id','=',$request->marker_course_id)
                ->where('student_id','=',$request->marker_student_id)
                ->where('assignment_id','=',$request->marker_assignment_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['markers'] = '';
            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">marker</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker_'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['markers'] .= '</tbody></table>';
            return $return_object;
        }

        if($request->post_method == 'delete_marker'){
            DB::table("assignment_markers")->where('id','=',$request->marker_id)->delete();
            $all_markers = DB::table('assignment_markers')
                ->where('course_id','=',    $request->course_id)
                ->where('student_id','=',   $request->student_id)
                ->where('assignment_id','=',$request->assignment_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['msg'] = 'success';
            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">marker</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker_'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['markers'] .= '</tbody></table>';
            return $return_object;
        }
        return redirect()->back()->withInput()->with('message',$msg);
    }

    //delete course "/list page"
    public function removeCourse(Request $request)
    {
        DB::table("courses")->where('id','=',$request->id)->delete();
        DB::table("feedback_templates")->where('course_id','=',$request->id)->delete();
        DB::table("canned_responses")->where('course_id','=',$request->id)->delete();
        return redirect()->back()->withInput()->with('message','Course Deleted Successfully' );
    }

    // delete Request
    public function deleteAssignmentNoteAndGetAllNotes(Request $request)
    {
        if($request->post_method == 'delete_note'){
            DB::table("assignment_notes")->where('id','=',$request->note_id)->delete();
            $all_notes = DB::table('assignment_notes')
                ->where('course_id','=',    $request->course_id)
                ->where('student_id','=',   $request->student_id)
                ->where('assignment_id','=',$request->assignment_id)
                ->orderBy('id','DESC')
                ->get();
            $return_object['msg'] = 'success';
            $return_object['notes'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">Note</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_notes as $note){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$note->tutor_id)->first();
                $return_object['notes'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$note->note.'</td>
                                        <td>'.date('d-m-Y',strtotime($note->created_at)).'</td>
                                        <td><a id="delete_note_'.$note->id.'" onclick="deleteNote('.$note->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete Note"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['notes'] .= '</tbody></table>';
        }
        return $return_object;
    }

    // delete Request
    public function deleteAssignmentMarkerAndGetAllMarkers(Request $request)
    {
        if($request->post_marker_method == 'delete_marker'){
            DB::table("assignment_markers")->where('id','=',$request->marker_id)->delete();
            $all_markers = DB::table('assignment_markers')
                ->where('course_id','=',    $request->course_id)
                ->where('student_id','=',   $request->student_id)
                ->where('assignment_id','=',$request->assignment_id)
                ->orderBy('id','DESC')
                ->get();

            $return_object['msg'] = 'success';
            $return_object['markers'] = '<table class="table text-left">
                                    <tr>
                                        <th class="name_col" scope="col">Tutor</th>
                                        <th class="description_col" scope="col">marker</th>
                                        <th class="date_col" scope="col">Date</th>
                                        <th class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>';

            foreach($all_markers as $marker){
                $tutor = DB::table("tutors")->select("first_name","last_name")->where("id","=",$marker->tutor_id)->first();
                $return_object['markers'] .= '<tr>
                                        <td>'.$tutor->first_name.' '.$tutor->last_name.'</td>
                                        <td>'.$marker->marker.'</td>
                                        <td>'.date('d-m-Y',strtotime($marker->created_at)).'</td>
                                        <td><a id="delete_marker_'.$marker->id.'" onclick="deleteMarker('.$marker->id.');" href="#" class="action_buttons tiny-action-btn btn-outline-secondary " title="Delete marker"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';
            }
            $return_object['markers'] .= '</tbody></table>';
        }
        return $return_object;
    }

    //delete course template
    public function removeCourseTemplate(Request $request)
    {
        if($request->method === 'delete_assessment'){
            DB::table("assessments")->where('id','=',$request->delete_assessment_id)->delete();
            $msg = 'Assessment Deleted Successfully';
            return redirect()->back()->withInput()->with('message',$msg);
        }

        if($request->method === 'delete_evidence'){
            DB::table("evidences")->where('id','=',$request->delete_evidence_id)->delete();
            $msg = 'Evidence Deleted Successfully';
            return redirect()->back()->withInput()->with('message',$msg);
        }

        if($request->method === 'delete_feedback'){
            DB::table("feedback_templates")->where('id','=',$request->delete_feedback_id)->delete();
            $msg = 'Feedback Template Deleted Successfully';
            return redirect()->back()->withInput()->with('message',$msg);
        }

        if($request->method === 'delete_canned'){
            DB::table("canned_responses")->where('id','=',$request->delete_canned_id)->delete();
            $msg = 'Canned Response Deleted Successfully';
            return redirect()->back()->withInput()->with('message',$msg);
        }
    }

    //show courses list page
    public function showCourses($page_var,Request $request){
        $query = DB::table('courses')->orderBy('name','asc');
        $total = $query->count();
        $this->pageLimit = 20;
        //get page limit from the form post variable
        if($this->pageLimit === 20){
            // how many records to get
            $query = $query->take($this->pageLimit);
            //how many records to skip
            $query = $query->skip( ($page_var-1) * $this->pageLimit );
            //total pages
            $totalPages = ceil($total / $this->pageLimit);
        }
        // check if enter page_var value is okay for pagination
        if($page_var > $totalPages){
            $page_var = 1;
        }
        $query->orderBy('created_at', 'desc');
        $courses = $query->get();
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('courses/list',compact('courses', $courses))->with($params);
    }

    //show courses marking list page
    public function showCoursesMarking($page_var,Request $request)
    {
        $course_type = '';
        //get logged in tutor
        $logged_user = Auth::user();
        //get tutor courses
        $tutor_courses = DB::table('tutors')->where('user_id', '=', $logged_user->id)->pluck('assigned_courses');
        $tutor_courses = explode(',', $tutor_courses);
        $priority_students = DB::table('assigned_courses')
            ->where('is_priority', '=', 1)
            ->groupBy('student_id')
            ->pluck('student_id');

        $student_ids_string = [];
        foreach ($priority_students as $id) {
            $student_ids_string[] = $id;
        }

        if ($request->q === 'priority_students') {
            $course_type = 'standard';
            $days = $this->getPrintSetting('priority_students_marking_duration');
            $ten_days_back_date = Carbon::now()->subDays($days); // today date - days
            $query = DB::table('standard_courses_uploads')
                ->whereIn('course_id', $tutor_courses)
                ->whereIn('student_id', $student_ids_string)
                //->where('unit_evidence_id', '=', NULL)//get only standard courses
                ->where('created_at', '<', $ten_days_back_date->toDatetimeString())
                ->orderBy('created_at', 'asc');
            $total_priority_students = $query->get()->count();
        }

        $days = $this->getPrintSetting('priority_students_marking_duration');
        $ten_days_back_date = Carbon::now()->subDays($days); // today date - days
        $q1 = DB::table('standard_courses_uploads')
            ->whereIn('course_id', $tutor_courses)
            ->whereIn('student_id', $student_ids_string)
            ->where('unit_evidence_id', '=', NULL)//get only standard courses
            ->where('created_at', '<', $ten_days_back_date->toDatetimeString())
            ->orderBy('created_at', 'asc');

        if ($request->q === 'current_marking') {
            $course_type = 'standard';
            $query = DB::table('standard_courses_uploads')
                ->whereIn('course_id', $tutor_courses)
                ->where('status', '=', 'awaiting_feedback')
                ->where('unit_evidence_id', '=', NULL)//get only standard courses
                ->orderBy('created_at', 'asc');
        }
        $q2 = DB::table('standard_courses_uploads')
            ->whereIn('course_id', $tutor_courses)
            ->where('status', '=', 'awaiting_feedback')
            ->where('unit_evidence_id', '=', NULL)//get only standard courses
            ->orderBy('created_at', 'asc');
        $total_current_marking = $q2->count();

        if ($request->q === 'current_unit_marking') {
            $course_type = 'work_based';
            $query = DB::table('standard_courses_uploads')
                ->whereIn('course_id', $tutor_courses)
                ->where('status', '<>', 'pass')
                ->where('unit_evidence_id', '<>', NULL)//get only work_based courses
                ->orderBy('created_at', 'asc');
        }
        $total_current_unit_marking = DB::table('standard_courses_uploads')
            ->select('student_id')->groupBy('student_id')
            ->whereIn('course_id', $tutor_courses)
            ->where('status', '<>', 'pass')
            ->where('assignment_number', '=', NULL)//get only unit based courses
            ->get()->count();

        if ($request->q === 'overdue_unit_marking') {
            $course_type = 'work_based';
            $days = $this->getPrintSetting('overdue_assignment_duration');
            $days_back_date = Carbon::now()->subDays($days); // today date - days
            $query = DB::table('standard_courses_uploads')
                ->whereIn('course_id', $tutor_courses)
                ->where('status', '=', 'awaiting_feedback')
                ->where('created_at', '<', $days_back_date->toDatetimeString())
                ->where('unit_evidence_id', '<>', NULL)//get only work_based courses
                ->orderBy('created_at', 'asc');
            $total_overdue_unit_marking = $query->count();
        }
        $days = $this->getPrintSetting('overdue_assignment_duration');
        $days_back_date = Carbon::now()->subDays($days); // today date - days
        $q4 = DB::table('standard_courses_uploads')
            ->whereIn('course_id', $tutor_courses)
            ->where('status', '=', 'awaiting_feedback')
            ->where('created_at', '<', $days_back_date->toDatetimeString())
            ->where('unit_evidence_id', '<>', NULL)//get only work_based courses
            ->orderBy('created_at', 'asc');
        $total_overdue_unit_marking = $q4->count();

        if($request->q !== 'pending_resource_approval'){


            $added_courses = array();
            $markings = $query->get();
            foreach ($markings as $key => $marking) {
                if (!in_array($marking->course_id . ',' . $marking->student_id, $added_courses)) {
                    $added_courses[] = $marking->course_id . ',' . $marking->student_id;
                } else {
                    unset($markings[$key]);
                }
            }
            $total = $markings->count();
            $total_priority_students = $total;

            if($request->q !== 'priority_students'){
                $added_courses = array();
                $m1 = $q1->get();
                foreach ($m1 as $key => $marking) {
                    if (!in_array($marking->course_id . ',' . $marking->student_id, $added_courses)) {
                        $added_courses[] = $marking->course_id . ',' . $marking->student_id;
                    } else {
                        unset($m1[$key]);
                    }
                }
                $total_priority_students = $m1->count();
            }

            if($request->q !== 'current_marking'){
                $added_courses = array();
                $m2 = $q2->get();
                foreach ($m2 as $key => $marking) {
                    if (!in_array($marking->course_id . ',' . $marking->student_id, $added_courses)) {
                        $added_courses[] = $marking->course_id . ',' . $marking->student_id;
                    } else {
                        unset($m2[$key]);
                    }
                }
                $total_current_marking = $m2->count();
            }

            if($request->q === 'current_marking'){
                $added_courses = array();
                $m2 = $query->get();
                foreach ($m2 as $key => $marking) {
                    if (!in_array($marking->course_id . ',' . $marking->student_id, $added_courses)) {
                        $added_courses[] = $marking->course_id . ',' . $marking->student_id;
                    } else {
                        unset($m2[$key]);
                    }
                }
                $total_current_marking = $m2->count();
            }

            $q5 = DB::table('resources')
                    ->where('is_approved','=',0)
                    ->orderBy('created_at','desc');
            $total_pending_resource_approval = $q5->count();

            $this->pageLimit = 999;
            //get page limit from the form post variable
            if ($this->pageLimit === 999) {
                // how many records to get
                $query = $query->take($this->pageLimit);
                //how many records to skip
                $query = $query->skip(($page_var - 1) * $this->pageLimit);
                //total pages
                $totalPages = ceil($total / $this->pageLimit);
            }
            // check if enter page_var value is okay for pagination
            if ($page_var > $totalPages) {
                $page_var = 1;
            }
        }

        if($request->q === 'pending_resource_approval'){
            if($request->q !== 'priority_students'){
                $added_courses = array();
                $m1 = $q1->get();
                foreach ($m1 as $key => $marking) {
                    if (!in_array($marking->course_id . ',' . $marking->student_id, $added_courses)) {
                        $added_courses[] = $marking->course_id . ',' . $marking->student_id;
                    } else {
                        unset($m1[$key]);
                    }
                }
                $total_priority_students = $m1->count();
            }
            if($request->q !== 'current_marking'){
                $added_courses = array();
                $m2 = $q2->get();
                foreach ($m2 as $key => $marking) {
                    if (!in_array($marking->course_id . ',' . $marking->student_id, $added_courses)) {
                        $added_courses[] = $marking->course_id . ',' . $marking->student_id;
                    } else {
                        unset($m2[$key]);
                    }
                }
                $total_current_marking = $m2->count();
            }

            $query = DB::table('resources')
                ->where('is_approved','=',0)
                ->orderBy('created_at','desc');
            $total = $query->count();
            $total_pending_resource_approval = $query->count();
            $this->pageLimit = 20;
            //get page limit from the form post variable
            if($this->pageLimit === 20){
                // how many records to get
                $query = $query->take($this->pageLimit);
                //how many records to skip
                $query = $query->skip( ($page_var-1) * $this->pageLimit );
                //total pages
                $totalPages = ceil($total / $this->pageLimit);
            }
            // check if enter page_var value is okay for pagination
            if($page_var > $totalPages){
                $page_var = 1;
            }
            $pending_resources = $query->get();
        }
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
            'course_type' => $course_type,
            'total_priority_students' => $total_priority_students,
            'total_current_marking' => $total_current_marking,
            'total_current_unit_marking' => $total_current_unit_marking,
            'total_overdue_unit_marking' => $total_overdue_unit_marking,
            'total_pending_resource_approval' => $total_pending_resource_approval,
        ];
        if($request->q === 'pending_resource_approval'){
            return view('marking/list',compact('pending_resources', $pending_resources))->with($params);
        }
        return view('marking/list',compact('markings', $markings))->with($params);
    }
}