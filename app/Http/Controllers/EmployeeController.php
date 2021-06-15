<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Employees
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Employee::with(['companyId','branchId','positionId','religionId','departmentId','costCenterId','countryId','cityId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_first_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_first_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_middle_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_middle_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_last_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_last_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_grand_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_grand_name",$oQb);
        $oQb = QB::whereLike($oInput,"civil_position_as_per_iqama",$oQb);
        $oQb = QB::where($oInput,"sex",$oQb);
        $oQb = QB::whereLike($oInput,"birthplace",$oQb);
        $oQb = QB::whereDate($oInput,"hired_date",$oQb);
        $oQb = QB::whereDate($oInput,"dob",$oQb);
        $oQb = QB::whereLike($oInput,"dob_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"email",$oQb);
        $oQb = QB::whereLike($oInput,"hired_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"position_as_per_iqama",$oQb);
        $oQb = QB::whereLike($oInput,"remarks_1",$oQb);
        $oQb = QB::whereLike($oInput,"remarks_2",$oQb);
        $oQb = QB::whereLike($oInput,"status",$oQb);
        $oQb = QB::whereLike($oInput,"contract",$oQb);
        $oQb = QB::whereLike($oInput,"insurance",$oQb);
        $oQb = QB::whereLike($oInput,"section",$oQb);
        $oQb = QB::whereLike($oInput,"hijri_age",$oQb);
        $oQb = QB::whereLike($oInput,"bank_account_no",$oQb);
        $oQb = QB::whereLike($oInput,"iqama_no",$oQb);
        $oQb = QB::whereLike($oInput,"mobile_no",$oQb);
        $oQb = QB::whereLike($oInput,"attendance_no",$oQb);
        $oQb = QB::whereLike($oInput,"report_to_pos",$oQb);
        $oQb = QB::whereLike($oInput,"report_to_emp",$oQb);
        $oQb = QB::whereLike($oInput,"use_ms_glid",$oQb);
        $oQb = QB::whereLike($oInput,"lang",$oQb);
        $oQb = QB::whereLike($oInput,"badgeno",$oQb);
        $oQb = QB::whereLike($oInput,"attuser",$oQb);
        $oQb = QB::whereLike($oInput,"delegate",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"position_id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"city_id",$oQb);
        $oQb = QB::where($oInput,"country_id",$oQb);
        $oQb = QB::where($oInput,"religion_id",$oQb);
        $oQb = QB::where($oInput,"department_id",$oQb);
        $oQb = QB::where($oInput,"cost_center_id",$oQb);
        $oQb = QB::where($oInput,"sponsor_id",$oQb);
        $oQb = QB::where($oInput,"shift_id",$oQb);
        $oQb = QB::where($oInput,"security_user_id",$oQb);
        
        $oEmployees = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee"]), $oEmployees, false);
        $this->urlRec(29, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_first_name'   => 'required|max:50',
            'ar_first_name'   => 'required|max:50',
            'en_middle_name'   => 'required|max:50',
            'ar_middle_name'   => 'required|max:50',
            'en_last_name'   => 'nullable|max:50',
            'ar_last_name'   => 'nullable|max:50',
            'en_grand_name'=> 'nullable|max:50',
            'ar_grand_name'=> 'nullable|max:50',
            'civil_position_as_per_iqama'=> 'nullable|max:30',
            'sex' => 'nullable|max:3',
            'birthplace' => 'nullable|max:30',
            'email' => 'nullable|max:30',
            'fax_1' => 'nullable|max:15',
            'dob' => 'nullable|date',
            'hired_date' => 'nullable|date',
            'dob_hijri' => 'nullable|max:10',
            'hired_date_hijri' => 'nullable|max:10',
            'position_as_per_iqama' => 'nullable|max:30',
            'remarks_1' => 'nullable|max:100',
            'remarks_2' => 'nullable|max:100',
            'status' => 'nullable|max:10',
            'sponsor_id' => 'nullable|integer',
            'shift_id' => 'nullable|integer',
            'security_user_id' => 'nullable|integer',
            'civil_status' => 'nullable|max:10',
            'dt_onloc' => 'nullable|max:10',
            'contract' => 'nullable|max:20',
            'insurance' => 'nullable|max:20',
            'section' => 'nullable|max:20',
            'hijri_age' => 'nullable|max:20',
            'bank_account_no' => 'nullable|max:20',
            'iqama_no' => 'nullable|max:20',
            'mobile_no' => 'nullable|max:20',
            'attendance_no' => 'nullable|max:20',
            'report_to_pos' => 'nullable|max:20',
            'report_to_emp' => 'nullable|max:20',
            'use_ms_glid' => 'nullable|max:20',
            'lang' => 'nullable|max:20',
            'badgeno' => 'nullable|max:20',
            'attuser' => 'nullable|max:20',
            'delegate' => 'nullable|max:20',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'position_id' => 'required|exists:designations,id',
            'religion_id' => 'required|exists:religions,id',
            'department_id' => 'required|exists:company_departments,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployee = Employee::create([
            'en_first_name' =>  $oInput['en_first_name'],
            'ar_first_name' =>  $oInput['ar_first_name'],
            'en_middle_name'=>  $oInput['en_middle_name'],
            'ar_middle_name'=>  $oInput['ar_middle_name'],
            'en_last_name'  =>  $oInput['en_last_name'],
            'ar_last_name'  =>  $oInput['ar_last_name'],
            'en_grand_name' =>  $oInput['en_grand_name'],
            'ar_grand_name' =>  $oInput['ar_grand_name'],
            'civil_position_as_per_iqama'=>  $oInput['civil_position_as_per_iqama'],
            'sex'           =>  $oInput['sex'],
            'country_id'    =>  $oInput['country_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'birthplace'    =>  $oInput['birthplace'],
            'dob'           =>  $oInput['dob'],
            'fax_1'         =>  $oInput['fax_1'],
            'hired_date'    =>  $oInput['hired_date'],
            'dob_hijri'     =>  $oInput['dob_hijri'],
            'email'         =>  $oInput['email'],
            'hired_date_hijri'=>  $oInput['hired_date_hijri'],
            'position_as_per_iqama'=>  $oInput['position_as_per_iqama'],
            'remarks_1'     =>  $oInput['remarks_1'],
            'remarks_2'     =>  $oInput['remarks_2'],
            'status'        =>  $oInput['status'],
            'sponsor_id'    =>  $oInput['sponsor_id'],
            'shift_id'      =>  $oInput['shift_id'],
            'security_user_id'=>  $oInput['security_user_id'],
            'civil_status'  =>  $oInput['civil_status'],
            'dt_onloc'      =>  $oInput['dt_onloc'],
            'contract'      =>  $oInput['contract'],
            'insurance'     =>  $oInput['insurance'],
            'section'       =>  $oInput['section'],
            'hijri_age'     =>  $oInput['hijri_age'],
            'bank_account_no'=>  $oInput['bank_account_no'],
            'iqama_no'      =>  $oInput['iqama_no'],
            'mobile_no'     =>  $oInput['mobile_no'],
            'attendance_no' =>  $oInput['attendance_no'],
            'report_to_pos' =>  $oInput['report_to_pos'],
            'report_to_emp' =>  $oInput['report_to_emp'],
            'use_ms_glid'   =>  $oInput['use_ms_glid'],
            'lang'          =>  $oInput['lang'],
            'badgeno'       =>  $oInput['badgeno'],
            'attuser'       =>  $oInput['attuser'],
            'delegate'      =>  $oInput['delegate'],
            'branch_id'     =>  $oInput['branch_id'],
            'position_id'   =>  $oInput['position_id'],
            'religion_id'   =>  $oInput['religion_id'],
            'department_id' =>  $oInput['department_id'],
            'cost_center_id'=>  $oInput['cost_center_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployee= Employee::with(['companyId','branchId','positionId','religionId','departmentId','costCenterId','countryId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($oEmployee->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee"]), $oEmployee, false);
        $this->urlRec(29, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployee= Employee::with(['companyId','branchId','positionId','religionId','departmentId','costCenterId','countryId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee"]), $oEmployee, false);
        $this->urlRec(29, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_first_name'   => 'required|max:50',
            'ar_first_name'   => 'required|max:50',
            'en_middle_name'   => 'required|max:50',
            'ar_middle_name'   => 'required|max:50',
            'en_last_name'   => 'nullable|max:50',
            'ar_last_name'   => 'nullable|max:50',
            'en_grand_name'=> 'nullable|max:50',
            'ar_grand_name'=> 'nullable|max:50',
            'civil_position_as_per_iqama'=> 'nullable|max:30',
            'sex' => 'nullable|max:3',
            'birthplace' => 'nullable|max:30',
            'email' => 'nullable|max:30',
            'fax_1' => 'nullable|max:15',
            'dob' => 'nullable|date',
            'hired_date' => 'nullable|date',
            'dob_hijri' => 'nullable|max:10',
            'hired_date_hijri' => 'nullable|max:10',
            'position_as_per_iqama' => 'nullable|max:30',
            'remarks_1' => 'nullable|max:100',
            'remarks_2' => 'nullable|max:100',
            'status' => 'nullable|max:10',
            'sponsor_id' => 'nullable|integer',
            'shift_id' => 'nullable|integer',
            'security_user_id' => 'nullable|integer',
            'civil_status' => 'nullable|max:10',
            'dt_onloc' => 'nullable|max:10',
            'contract' => 'nullable|max:20',
            'insurance' => 'nullable|max:20',
            'section' => 'nullable|max:20',
            'hijri_age' => 'nullable|max:20',
            'bank_account_no' => 'nullable|max:20',
            'iqama_no' => 'nullable|max:20',
            'mobile_no' => 'nullable|max:20',
            'attendance_no' => 'nullable|max:20',
            'report_to_pos' => 'nullable|max:20',
            'report_to_emp' => 'nullable|max:20',
            'use_ms_glid' => 'nullable|max:20',
            'lang' => 'nullable|max:20',
            'badgeno' => 'nullable|max:20',
            'attuser' => 'nullable|max:20',
            'delegate' => 'nullable|max:20',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'position_id' => 'required|exists:designations,id',
            'religion_id' => 'required|exists:religions,id',
            'department_id' => 'required|exists:company_departments,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployee = Employee::findOrFail($id); 

        $oEmployees = $oEmployee->update([
            'en_first_name' =>  $oInput['en_first_name'],
            'ar_first_name' =>  $oInput['ar_first_name'],
            'en_middle_name'=>  $oInput['en_middle_name'],
            'ar_middle_name'=>  $oInput['ar_middle_name'],
            'en_last_name'  =>  $oInput['en_last_name'],
            'ar_last_name'  =>  $oInput['ar_last_name'],
            'en_grand_name' =>  $oInput['en_grand_name'],
            'ar_grand_name' =>  $oInput['ar_grand_name'],
            'civil_position_as_per_iqama'=>  $oInput['civil_position_as_per_iqama'],
            'sex'           =>  $oInput['sex'],
            'country_id'    =>  $oInput['country_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'birthplace'    =>  $oInput['birthplace'],
            'dob'           =>  $oInput['dob'],
            'fax_1'         =>  $oInput['fax_1'],
            'hired_date'    =>  $oInput['hired_date'],
            'dob_hijri'     =>  $oInput['dob_hijri'],
            'email'         =>  $oInput['email'],
            'hired_date_hijri'=>  $oInput['hired_date_hijri'],
            'position_as_per_iqama'=>  $oInput['position_as_per_iqama'],
            'remarks_1'     =>  $oInput['remarks_1'],
            'remarks_2'     =>  $oInput['remarks_2'],
            'status'        =>  $oInput['status'],
            'sponsor_id'    =>  $oInput['sponsor_id'],
            'shift_id'      =>  $oInput['shift_id'],
            'security_user_id'=>  $oInput['security_user_id'],
            'civil_status'  =>  $oInput['civil_status'],
            'dt_onloc'      =>  $oInput['dt_onloc'],
            'contract'      =>  $oInput['contract'],
            'insurance'     =>  $oInput['insurance'],
            'section'       =>  $oInput['section'],
            'hijri_age'     =>  $oInput['hijri_age'],
            'bank_account_no'=>  $oInput['bank_account_no'],
            'iqama_no'      =>  $oInput['iqama_no'],
            'mobile_no'     =>  $oInput['mobile_no'],
            'attendance_no' =>  $oInput['attendance_no'],
            'report_to_pos' =>  $oInput['report_to_pos'],
            'report_to_emp' =>  $oInput['report_to_emp'],
            'use_ms_glid'   =>  $oInput['use_ms_glid'],
            'lang'          =>  $oInput['lang'],
            'badgeno'       =>  $oInput['badgeno'],
            'attuser'       =>  $oInput['attuser'],
            'delegate'      =>  $oInput['delegate'],
            'branch_id'     =>  $oInput['branch_id'],
            'position_id'   =>  $oInput['position_id'],
            'religion_id'   =>  $oInput['religion_id'],
            'department_id' =>  $oInput['department_id'],
            'cost_center_id'=>  $oInput['cost_center_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployee = Employee::with(['companyId','branchId','positionId','religionId','departmentId','costCenterId','countryId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee"]), $oEmployee, false);
        
        $this->urlRec(29, 3, $oResponse);
        
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
                $oEmployee = Employee::find($id);
                $oEmployee->update(['deleted_by'=>Auth::user()->id]);
                if($oEmployee){
                    $oEmployee->delete();
                }
            }
        }else{
            $oEmployee = Employee::findOrFail($aIds);
            $oEmployee->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee"]));
        $this->urlRec(29, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEmployee = Employee::onlyTrashed()->with(['companyId','branchId','positionId','religionId','departmentId','costCenterId','countryId','cityId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Employee"]), $oEmployee, false);
        $this->urlRec(29, 5, $oResponse); 
        return $oResponse;
    }
    // Restore any deleted data
    public function restore(Request $request)
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
                
                $oEmployee = Employee::onlyTrashed()->find($id);
                if($oEmployee){
                    $oEmployee->restore();
                }
            }
        }else{
            $oEmployee = Employee::onlyTrashed()->findOrFail($aIds);
            $oEmployee->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Employee"]));
        $this->urlRec(29, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEmployee = Employee::onlyTrashed()->findOrFail($id);
        
        $oEmployee->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Employee"]));
        $this->urlRec(29, 7, $oResponse);
        return $oResponse;
    }
}
