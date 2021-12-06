<?php
namespace App\Http\Controllers;
use App\Roles;
use App\Student;
use App\Course;
use App\Material;
use Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MaterialController extends Controller
{
    public function createMaterial(Request $request){
        if ($request->ajax()) {
            if($request->method === 'new_material'){
                $material = new Material;
                if($request->course_specific === 'all'){
                    $material->course_specific = 'all';
                }elseif($request->course_specific === 'course_specific'){
                    $material->course_specific = $request->course_id;
                }

                $file = $request->file('material_file');
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/materials/', $name);
                $material->material_file = $name;
                $material->description = $request->description;
                $material->save();
                $msg = 'Material Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }
    }


    private $pageLimit;
    // View Materials
    public function viewMaterials($page_var,Request $request){
        //get courses
        $courses = DB::table('courses')->orderBy('name','asc')->get();

        $query = DB::table('materials');

        if($request->input('accessibility_filter') === 'course'){
            if($request->input('single_course_search')){
                $query = $query->where('course_specific','=',$request->searched_course_id);
            }
        }

        if($request->input('accessibility_filter') === 'unit') {
            //$query = $query->where('course_specific','=',);
        }

        $query = $query->orderBy('id','DESC');

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

        $materials = $query->get();

        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('materials/materials',compact('materials' , $materials,'courses',$courses))->with($params);
    }

    //delete selected materials
    public function deleteSelectedMaterials(Request $request)
    {
        $ids = $request->ids;
        DB::table("materials")->whereIn('id',explode(",",$ids))->delete();
        return back()->withInput()->with('message', 'Material(s) Deleted');
    }
}
