<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTraining;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeTrainingController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeTrainings
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeTraining::with(['employeeId','educationId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"date_from",$oQb);
        $oQb = QB::whereDate($oInput,"date_to",$oQb);
        $oQb = QB::whereDate($oInput,"date_from_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_to_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"school",$oQb);
        $oQb = QB::whereLike($oInput,"course",$oQb);
        $oQb = QB::whereLike($oInput,"school_address",$oQb);
        $oQb = QB::whereLike($oInput,"comments",$oQb);
        $oQb = QB::where($oInput,"education_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeTrainings = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Training"]), $oEmployeeTrainings, false);
        $this->urlRec(52, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'date_from'   => 'nullable|date',
            'date_to'   => 'nullable|date',
            'date_from_hijri'   => 'nullable|date',
            'date_to_hijri'   => 'nullable|date',
            'school' => 'nullable|max:100',
            'course' => 'nullable|max:100',
            'school_address' => 'nullable|max:200',
            'comments' => 'nullable|max:200',
            'education_id' => 'required|exists:education,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeTraining = EmployeeTraining::create([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'school'   =>  $oInput['school'],
            'course'   =>  $oInput['course'],
            'school_address'   =>  $oInput['school_address'],
            'comments'=>  $oInput['comments'],
            'employee_id'   =>  $oInput['employee_id'],
            'education_id'=>  $oInput['education_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeTraining= EmployeeTraining::with(['employeeId','educationId','createdBy','updatedBy'])->findOrFail($oEmployeeTraining->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Training"]), $oEmployeeTraining, false);
        $this->urlRec(52, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeTraining= EmployeeTraining::with(['employeeId','educationId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Training"]), $oEmployeeTraining, false);
        $this->urlRec(52, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'date_from'   => 'nullable|date',
            'date_to'   => 'nullable|date',
            'date_from_hijri'   => 'nullable|date',
            'date_to_hijri'   => 'nullable|date',
            'school' => 'nullable|max:100',
            'course' => 'nullable|max:100',
            'school_address' => 'nullable|max:200',
            'comments' => 'nullable|max:200',
            'education_id' => 'required|exists:education,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeTraining = EmployeeTraining::findOrFail($id); 

        $oEmployeeTrainings = $oEmployeeTraining->update([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'school'   =>  $oInput['school'],
            'course'   =>  $oInput['course'],
            'school_address'   =>  $oInput['school_address'],
            'comments'=>  $oInput['comments'],
            'employee_id'   =>  $oInput['employee_id'],
            'education_id'=>  $oInput['education_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeTraining = EmployeeTraining::with(['employeeId','educationId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Training"]), $oEmployeeTraining, false);
        
        $this->urlRec(52, 3, $oResponse);
        
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
                $oEmployeeTraining = EmployeeTraining::find($id);
                if($oEmployeeTraining){
                    $oEmployeeTraining->delete();
                }
            }
        }else{
            $oEmployeeTraining = EmployeeTraining::findOrFail($aIds);
            $oEmployeeTraining->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Training"]));
        $this->urlRec(52, 4, $oResponse);
        return $oResponse;
    }
}
