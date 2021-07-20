<?php

namespace App\Http\Controllers;

use App\Models\EmployeeNote;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Validator;

class EmployeeNoteController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeNote
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeNote::with(['employeeId','reportToEmployeeId','reportToPositionId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"report_to_position",$oQb);
        $oQb = QB::whereLike($oInput,"report_to_employee",$oQb);
        $oQb = QB::whereLike($oInput,"badge_no",$oQb);
        $oQb = QB::whereLike($oInput,"security_user_id",$oQb);
        $oQb = QB::whereLike($oInput,"attendance_no",$oQb);
        $oQb = QB::whereLike($oInput,"picture",$oQb);
        $oQb = QB::whereLike($oInput,"notes",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeNote = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Note"]), $oEmployeeNote, false);
        $this->urlRec(56, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'report_to_position'   => 'nullable|exists:designations,id',
            'report_to_employee'   => 'nullable|exists:employees,id',
            'badge_no'   => 'nullable|integer',
            'security_user_id'   => 'nullable|max:50',
            'attendance_no' => 'nullable|max:50',
            'picture' => 'nullable|max:200',
            'notes' => 'nullable|max:200',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        if(isset($request->picture)){
            $pictureExtension = $request->picture->extension();
            if($pictureExtension != "png" && $pictureExtension != "jpg" && $pictureExtension != "jpeg"){
                abort(400,"The picture must be a file of type: jpeg, jpg, png.");
            }
            $oPaths = FileHelper::saveImages($request->picture,'employee_picture');
        }

        $oEmployeeNote = EmployeeNote::create([
            'report_to_position' =>  $oInput['report_to_position'],
            'report_to_employee' =>  $oInput['report_to_employee'],
            'badge_no'=>  $oInput['badge_no'],
            'security_user_id'=>  $oInput['security_user_id'],
            'attendance_no'   =>  $oInput['attendance_no'],
            'picture'   =>  isset($oPaths)? $oPaths : '',
            'notes'   =>  $oInput['notes'],
            'employee_id'   =>  $oInput['employee_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeNote= EmployeeNote::with(['employeeId','reportToEmployeeId','reportToPositionId','createdBy','updatedBy'])->findOrFail($oEmployeeNote->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Note"]), $oEmployeeNote, false);
        $this->urlRec(56, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeNote= EmployeeNote::with(['employeeId','reportToEmployeeId','reportToPositionId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Note"]), $oEmployeeNote, false);
        $this->urlRec(56, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'report_to_position'   => 'nullable|exists:designations,id',
            'report_to_employee'   => 'nullable|exists:employees,id',
            'badge_no'   => 'nullable|integer',
            'security_user_id'   => 'nullable|max:50',
            'attendance_no' => 'nullable|max:50',
            'notes' => 'nullable|max:200',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeNote = EmployeeNote::findOrFail($id);
        $oPaths = $oEmployeeNote->picture;
        if(isset($request->picture)){

            FileHelper::deleteImages($oPaths);
            $pictureExtension = $request->picture->extension();
            if($pictureExtension != "png" && $pictureExtension != "jpg" && $pictureExtension != "jpeg"){
                abort(400,"The picture must be a file of type: jpeg, jpg, png.");
            }
            $oPaths = FileHelper::saveImages($request->picture,'employee_picture');
        }
        $oEmployeeNote = $oEmployeeNote->update([
            'report_to_position' =>  $oInput['report_to_position'],
            'report_to_employee' =>  $oInput['report_to_employee'],
            'badge_no'=>  $oInput['badge_no'],
            'security_user_id'=>  $oInput['security_user_id'],
            'attendance_no'   =>  $oInput['attendance_no'],
            'picture'   =>  $oPaths,
            'notes'   =>  $oInput['notes'],
            'employee_id'   =>  $oInput['employee_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeNote = EmployeeNote::with(['employeeId','reportToEmployeeId','reportToPositionId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Note"]), $oEmployeeNote, false);
        
        $this->urlRec(56, 3, $oResponse);
        
        return $oResponse;
    }

    // Soft Delete country 

    public function destroy(Request $request)
    {
        $oInput = $request->all();
        $oValidator = Validator::make($oInput,[
            'ids'        => 'required',
        ]);
        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $aIds = $request->ids;
        if(is_array($aIds)){
            foreach($aIds as $id){
                $oEmployeeNote = EmployeeNote::find($id);
                if($oEmployeeNote){
                    $oEmployeeNote->delete();
                }
            }
        }else{
            $oEmployeeNote = EmployeeNote::findOrFail($aIds);
            $oEmployeeNote->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Note"]));
        $this->urlRec(56, 4, $oResponse);
        return $oResponse;
    }
}
