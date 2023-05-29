<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Models\Students;
use Illuminate\Support\Facades\File;


class StudentsController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id;
        $data['status'] = 0;
        $data['massage'] = "record not submit";

        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . $file->getClientOriginalName();
            $destination = public_path('/upload/');
            $file->move($destination, $filename);
            if ($id != "") {
                $image_path = public_path("/upload/" . $request->image_name);
                if (File::exists($image_path)) {
                    unlink($image_path);
                }
            }
        } else {
            $filename = $request->image_name;
        }
        if ($request->firstname) {
            $datainsert['firstname'] =  $request->firstname;
            $datainsert['lastname'] =  $request->lastname;
            $datainsert['date'] =  $request->add_date;
            $datainsert['salary'] =  $request->salary;
            $datainsert['image'] =  $filename;


            if (!empty($id)) {
                $save = Students::where('id', $id)
                ->update($datainsert);
                $data['status'] = 1;
                $data['massage'] = "record update Successfully";
            } else {
                $save = DB::table('students')->insert($datainsert);
                $data['status'] = 1;
                $data['massage'] = "record submit";
            }
        }
        return json_encode($data);
    }
    public function userlist(Request $request)
    {
        if ($request->ajax()) {
            $data = Students::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($data) {
                    return  "/upload/" . $data->image;
                })
                ->addColumn('action', function ($data) {
                    $btn = '<button id="edit" data-id="' . $data->id . '" class="btn btn-primary btn-sm">Edit</button>';
                    $btn .= '<button id="delete" data-id="' . $data->id . '" class="btn btn-danger btn-sm">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function delete(Request $request)
    {
        $data['status'] = 0;
        $data['massage'] = "not delete record";
        if ($request->id > 0) {
            $id = $request->id;
            // $delete = DB::table('students')->where('id', $id)->delete();
            $delete_data = Students::findOrFail($id);

            $image_path = public_path("/upload/" . $delete_data->image);
            if (File::exists($image_path)) {

                //File::delete($image_path);
                unlink($image_path);
            }
            $delete_data->delete();
            $data['status'] = 1;
            $data['massage'] = "Record Delete Successfully";
        }
        return json_encode($data);
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        if ($id > 0) {
            $students = Students::select('*')
                ->where('id', '=', $id)
                ->first();
            $students->myimage = '/upload/' . $students->image;
            return json_encode($students);
        }
    }
}
