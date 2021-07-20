<?php

namespace App\Http\Controllers;

use App\Models\EmployeeExperience;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeExperienceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeExperiences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeExperience::with(['employeeId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"date_from",$oQb);
        $oQb = QB::whereDate($oInput,"date_to",$oQb);
        $oQb = QB::whereDate($oInput,"date_from_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_to_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"ex_company",$oQb);
        $oQb = QB::whereLike($oInput,"ex_position",$oQb);
        $oQb = QB::whereLike($oInput,"ex_salary",$oQb);
        $oQb = QB::whereLike($oInput,"reason_for_leaving",$oQb);
        $oQb = QB::where($oInput,"ex_address",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeExperiences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Experience"]), $oEmployeeExperiences, false);
        $this->urlRec(53, 0, $oResponse);
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
            'ex_company' => 'nullable|max:100',
            'ex_position' => 'nullable|max:100',
            'ex_salary' => 'nullable|max:10',
            'reason_for_leaving' => 'nullable|max:500',
            'ex_address' => 'nullable|max:500',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeExperience = EmployeeExperience::create([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'ex_company'   =>  $oInput['ex_company'],
            'ex_position'   =>  $oInput['ex_position'],
            'ex_salary'   =>  $oInput['ex_salary'],
            'reason_for_leaving'=>  $oInput['reason_for_leaving'],
            'employee_id'   =>  $oInput['employee_id'],
            'ex_address'=>  $oInput['ex_address'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeExperience= EmployeeExperience::with(['employeeId','createdBy','updatedBy'])->findOrFail($oEmployeeExperience->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Experience"]), $oEmployeeExperience, false);
        $this->urlRec(53, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeExperience= EmployeeExperience::with(['employeeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Experience"]), $oEmployeeExperience, false);
        $this->urlRec(53, 2, $oResponse);
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
            'ex_company' => 'nullable|max:100',
            'ex_position' => 'nullable|max:100',
            'ex_salary' => 'nullable|max:10',
            'reason_for_leaving' => 'nullable|max:500',
            'ex_address' => 'nullable|max:500',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeExperience = EmployeeExperience::findOrFail($id); 

        $oEmployeeExperiences = $oEmployeeExperience->update([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'ex_company'   =>  $oInput['ex_company'],
            'ex_position'   =>  $oInput['ex_position'],
            'ex_salary'   =>  $oInput['ex_salary'],
            'reason_for_leaving'=>  $oInput['reason_for_leaving'],
            'employee_id'   =>  $oInput['employee_id'],
            'ex_address'=>  $oInput['ex_address'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeExperience = EmployeeExperience::with(['employeeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Experience"]), $oEmployeeExperience, false);
        
        $this->urlRec(53, 3, $oResponse);
        
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
                $oEmployeeExperience = EmployeeExperience::find($id);
                if($oEmployeeExperience){
                    $oEmployeeExperience->delete();
                }
            }
        }else{
            $oEmployeeExperience = EmployeeExperience::findOrFail($aIds);
            $oEmployeeExperience->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Experience"]));
        $this->urlRec(53, 4, $oResponse);
        return $oResponse;
    }
}
