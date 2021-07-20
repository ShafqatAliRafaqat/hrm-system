<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDependent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeDependentController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeDependent
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeDependent::with(['employeeId','columnId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_middle_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_middle_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_grand_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_grand_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_family_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_family_name",$oQb);
        $oQb = QB::whereDate($oInput,"dob",$oQb);
        $oQb = QB::whereLike($oInput,"dob_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"sex",$oQb);
        $oQb = QB::whereLike($oInput,"iqama_no",$oQb);
        $oQb = QB::whereLike($oInput,"mobile_no",$oQb);
        $oQb = QB::where($oInput,"hijri_age",$oQb);
        $oQb = QB::where($oInput,"age",$oQb);
        $oQb = QB::whereLike($oInput,"address",$oQb);
        $oQb = QB::where($oInput,"column_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeDependent = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Dependent"]), $oEmployeeDependent, false);
        $this->urlRec(55, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'nullable|max:50',
            'ar_name'   => 'nullable|max:50',
            'en_middle_name'   => 'nullable|max:50',
            'ar_middle_name'   => 'nullable|max:50',
            'en_grand_name' => 'nullable|max:50',
            'ar_grand_name' => 'nullable|max:50',
            'en_family_name' => 'nullable|max:50',
            'ar_family_name' => 'nullable|max:50',
            'dob' => 'nullable|date',
            'dob_hijri' => 'nullable|max:10',
            'sex' => 'nullable|max:3',
            'iqama_no' => 'nullable|max:20',
            'mobile_no' => 'nullable|max:20',
            'hijri_age' => 'nullable|max:20',
            'age' => 'nullable|max:20',
            'address' => 'nullable|max:200',
            'column_id' => 'required|exists:column_selects,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeDependent = EmployeeDependent::create([
            'en_name' =>  $oInput['en_name'],
            'ar_name' =>  $oInput['ar_name'],
            'en_middle_name'=>  $oInput['en_middle_name'],
            'ar_middle_name'=>  $oInput['ar_middle_name'],
            'en_grand_name'   =>  $oInput['en_grand_name'],
            'ar_grand_name'   =>  $oInput['ar_grand_name'],
            'en_family_name'   =>  $oInput['en_family_name'],
            'ar_family_name'=>  $oInput['ar_family_name'],
            'employee_id'   =>  $oInput['employee_id'],
            'dob'=>  $oInput['dob'],
            'dob_hijri'=>  $oInput['dob_hijri'],
            'sex'=>  $oInput['sex'],
            'iqama_no'=>  $oInput['iqama_no'],
            'mobile_no'=>  $oInput['mobile_no'],
            'hijri_age'=>  $oInput['hijri_age'],
            'age'=>  $oInput['age'],
            'address'=>  $oInput['address'],
            'column_id'=>  $oInput['column_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeDependent= EmployeeDependent::with(['employeeId','columnId','createdBy','updatedBy'])->findOrFail($oEmployeeDependent->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Dependent"]), $oEmployeeDependent, false);
        $this->urlRec(55, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeDependent= EmployeeDependent::with(['employeeId','columnId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Dependent"]), $oEmployeeDependent, false);
        $this->urlRec(55, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'nullable|max:50',
            'ar_name'   => 'nullable|max:50',
            'en_middle_name'   => 'nullable|max:50',
            'ar_middle_name'   => 'nullable|max:50',
            'en_grand_name' => 'nullable|max:50',
            'ar_grand_name' => 'nullable|max:50',
            'en_family_name' => 'nullable|max:50',
            'ar_family_name' => 'nullable|max:50',
            'dob' => 'nullable|date',
            'dob_hijri' => 'nullable|max:10',
            'sex' => 'nullable|max:3',
            'iqama_no' => 'nullable|max:20',
            'mobile_no' => 'nullable|max:20',
            'hijri_age' => 'nullable|max:20',
            'age' => 'nullable|max:20',
            'address' => 'nullable|max:200',
            'column_id' => 'required|exists:column_selects,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeDependent = EmployeeDependent::findOrFail($id); 

        $oEmployeeDependent = $oEmployeeDependent->update([
            'en_name' =>  $oInput['en_name'],
            'ar_name' =>  $oInput['ar_name'],
            'en_middle_name'=>  $oInput['en_middle_name'],
            'ar_middle_name'=>  $oInput['ar_middle_name'],
            'en_grand_name'   =>  $oInput['en_grand_name'],
            'ar_grand_name'   =>  $oInput['ar_grand_name'],
            'en_family_name'   =>  $oInput['en_family_name'],
            'ar_family_name'=>  $oInput['ar_family_name'],
            'employee_id'   =>  $oInput['employee_id'],
            'dob'=>  $oInput['dob'],
            'dob_hijri'=>  $oInput['dob_hijri'],
            'sex'=>  $oInput['sex'],
            'iqama_no'=>  $oInput['iqama_no'],
            'mobile_no'=>  $oInput['mobile_no'],
            'hijri_age'=>  $oInput['hijri_age'],
            'age'=>  $oInput['age'],
            'address'=>  $oInput['address'],
            'column_id'=>  $oInput['column_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeDependent = EmployeeDependent::with(['employeeId','columnId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Dependent"]), $oEmployeeDependent, false);
        
        $this->urlRec(55, 3, $oResponse);
        
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
                $oEmployeeDependent = EmployeeDependent::find($id);
                if($oEmployeeDependent){
                    $oEmployeeDependent->delete();
                }
            }
        }else{
            $oEmployeeDependent = EmployeeDependent::findOrFail($aIds);
            $oEmployeeDependent->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Dependent"]));
        $this->urlRec(55, 4, $oResponse);
        return $oResponse;
    }
}
