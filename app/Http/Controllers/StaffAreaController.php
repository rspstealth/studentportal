<?php
namespace App\Http\Controllers;
use App\Resource;
use App\StaffResource;
use App\Announcement;
use App\Assesment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffAreaController extends Controller
{
    // get staff area page
    public function getStaffArea(){
        $announcements = DB::table('announcements')->get();
        $staff_resources = DB::table('staff_resources')->get();
        return view('staff-area/staff-area', compact('announcements',$announcements, 'staff_resources',$staff_resources));
    }

    // new announcement, resource, assesment based on method
    public function createNew(Request $request){
        //if ajax request
            $logged_in_user = Auth::user();//get user
            if($request->method === 'announcement'){
                $record = new Announcement;
                $record->headline =  $request->headline;
                $record->message = $request->message;
                $record->created_by = $logged_in_user->id;
                $record->save();
            }

            if($request->method === 'resource'){
                $record = new StaffResource;
                $record->shared_with =  $request->shared_with;
                $record->course =  $request->course;
                $record->description = $request->description;
                $record->created_by = $logged_in_user->id;
                if($request->hasFile('resource_file')) {
                    $file = $request->file('resource_file');
                    //you also need to keep file extension as well
                    $name = $file->getClientOriginalName();
                    //using array instead of object
                    $image['filePath'] = $name;
                    $file->move(public_path().'/resources/', $name);
                    $record->resource_file = 'resources/'. $name;
                }
                $record->save();
            }

            if($record){
                return redirect()->back()->withInput()->with('message', 'Success');
            }else{
                return redirect()->back()->withInput()->with('error', 'There was a problem, please try again.');
            }
    }

    //delete announcements, resources , assesments
    public function deleteItem(Request $request){
        $id = $request->id;
        if($request->delete_type === 'announcement'){
            DB::table("announcements")->where('id','=',$id)->delete();
        }
        if($request->delete_type === 'resource'){
            DB::table("resources")->where('id','=',$id)->delete();
        }
        if($request->delete_type === 'assesment'){
            DB::table("assesments")->where('id','=',$id)->delete();
        }
        return back()->withInput()->with('message', 'Success');
    }
}
