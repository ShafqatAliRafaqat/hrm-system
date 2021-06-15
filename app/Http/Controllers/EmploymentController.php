<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmploymentController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Employments
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Employment::with(['companyId','branchId','employeeId','cityId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"start_date",$oQb);
        $oQb = QB::whereDate($oInput,"end_date",$oQb);
        $oQb = QB::whereDate($oInput,"start_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"end_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"termination_date",$oQb);
        $oQb = QB::whereDate($oInput,"termination_notice_date",$oQb);
        $oQb = QB::whereDate($oInput,"termination_effective_date",$oQb);
        $oQb = QB::whereDate($oInput,"termination_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"termination_notice_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"termination_effective_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"vacation_due_date",$oQb);
        $oQb = QB::whereDate($oInput,"vacation_due_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"contract_date",$oQb);
        $oQb = QB::whereLike($oInput,"bank_id",$oQb);
        $oQb = QB::whereLike($oInput,"current_flag",$oQb);
        $oQb = QB::whereLike($oInput,"contract_status",$oQb);
        $oQb = QB::whereLike($oInput,"final_set_flag",$oQb);
        $oQb = QB::whereLike($oInput,"vacation_month_due",$oQb);
        $oQb = QB::whereLike($oInput,"no_login",$oQb);
        $oQb = QB::whereLike($oInput,"bank_account_no",$oQb);
        $oQb = QB::whereLike($oInput,"contract_type",$oQb);
        $oQb = QB::whereLike($oInput,"contract_family_flag",$oQb);
        $oQb = QB::whereLike($oInput,"contract_no",$oQb);
        $oQb = QB::whereLike($oInput,"contract_duration",$oQb);
        $oQb = QB::whereLike($oInput,"time_unit_duration",$oQb);
        $oQb = QB::whereLike($oInput,"termination_type",$oQb);
        $oQb = QB::whereLike($oInput,"contract_created_by",$oQb);
        $oQb = QB::whereLike($oInput,"terminated_by",$oQb);
        $oQb = QB::whereLike($oInput,"terminated_when",$oQb);
        $oQb = QB::whereLike($oInput,"vacation_days",$oQb);
        $oQb = QB::whereLike($oInput,"renew",$oQb);
        $oQb = QB::whereLike($oInput,"rank",$oQb);
        $oQb = QB::whereLike($oInput,"work_hrs",$oQb);
        $oQb = QB::whereLike($oInput,"contract_remark",$oQb);
        $oQb = QB::where($oInput,"termination_remark",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"city_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployments = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employment"]), $oEmployments, false);
        $this->urlRec(46, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'start_date'   => 'nullable|date',
            'end_date'   => 'nullable|date',
            'start_date_hijri'   => 'nullable|date',
            'end_date_hijri'   => 'nullable|date',
            'termination_date'   => 'nullable|date',
            'termination_notice_date'   => 'nullable|date',
            'termination_effective_date'=> 'nullable|date',
            'termination_date_hijri'=> 'nullable|date',
            'termination_notice_date_hijri'=> 'nullable|date',
            'termination_effective_date_hijri' => 'nullable|date',
            'vacation_due_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'vacation_due_date_hijri' => 'nullable|date',
            'bank_id' => 'nullable|integer',
            'current_flag' => 'nullable|in:0,1',
            'terminate_flag' => 'nullable|in:0,1',
            'contract_status' => 'nullable|in:0,1',
            'final_set_flag' => 'nullable|max:10',
            'vacation_month_due' => 'nullable|max:20',
            'no_login' => 'nullable|max:20',
            'bank_account_no' => 'nullable|max:30',
            'contract_type' => 'nullable|max:50',
            'contract_family_flag' => 'nullable|max:50',
            'contract_no' => 'nullable|max:50',
            'contract_duration' => 'nullable|max:50',
            'time_unit_duration' => 'nullable|max:50',
            'termination_type' => 'nullable|max:50',
            'contract_created_by' => 'nullable|max:100',
            'terminated_by' => 'nullable|max:100',
            'terminated_when' => 'nullable|max:100',
            'vacation_days' => 'nullable|max:100',
            'renew' => 'nullable|max:100',
            'rank' => 'nullable|max:100',
            'work_hrs' => 'nullable|max:100',
            'contract_remark' => 'nullable|max:500',
            'termination_remark' => 'nullable|max:500',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployment = Employment::create([
            'start_date' =>  $oInput['start_date'],
            'end_date' =>  $oInput['end_date'],
            'start_date_hijri'=>  $oInput['start_date_hijri'],
            'end_date_hijri'=>  $oInput['end_date_hijri'],
            'termination_date'  =>  $oInput['termination_date'],
            'termination_notice_date'  =>  $oInput['termination_notice_date'],
            'termination_effective_date' =>  $oInput['termination_effective_date'],
            'termination_date_hijri' =>  $oInput['termination_date_hijri'],
            'termination_notice_date_hijri'=>  $oInput['termination_notice_date_hijri'],
            'termination_effective_date_hijri'           =>  $oInput['termination_effective_date_hijri'],
            'vacation_due_date'      =>  $oInput['vacation_due_date'],
            'contract_date'          =>  $oInput['contract_date'],
            'vacation_due_date_hijri'=>  $oInput['vacation_due_date_hijri'],
            'bank_id'             =>  $oInput['bank_id'],
            'current_flag'        =>  $oInput['current_flag'],
            'terminate_flag'      =>  $oInput['terminate_flag'],
            'contract_status'     =>  $oInput['contract_status'],
            'final_set_flag'      =>  $oInput['final_set_flag'],
            'vacation_month_due'  =>  $oInput['vacation_month_due'],
            'no_login'            =>  $oInput['no_login'],
            'contract_type'       =>  $oInput['contract_type'],
            'contract_family_flag'=>  $oInput['contract_family_flag'],
            'contract_duration'  =>  $oInput['contract_duration'],
            'contract_no'        =>  $oInput['contract_no'],
            'bank_account_no'    =>  $oInput['bank_account_no'],
            'time_unit_duration' =>  $oInput['time_unit_duration'],
            'termination_type'   =>  $oInput['termination_type'],
            'contract_created_by'=>  $oInput['contract_created_by'],
            'terminated_by'     =>  $oInput['terminated_by'],
            'terminated_when'   =>  $oInput['terminated_when'],
            'vacation_days'     =>  $oInput['vacation_days'],
            'renew'             =>  $oInput['renew'],
            'rank'              =>  $oInput['rank'],
            'work_hrs'          =>  $oInput['work_hrs'],
            'termination_remark'=>  $oInput['termination_remark'],
            'contract_remark'=>  $oInput['contract_remark'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployment= Employment::with(['companyId','branchId','employeeId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($oEmployment->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employment"]), $oEmployment, false);
        $this->urlRec(46, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployment= Employment::with(['companyId','branchId','employeeId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employment"]), $oEmployment, false);
        $this->urlRec(46, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'start_date'   => 'nullable|date',
            'end_date'   => 'nullable|date',
            'start_date_hijri'   => 'nullable|date',
            'end_date_hijri'   => 'nullable|date',
            'termination_date'   => 'nullable|date',
            'termination_notice_date'   => 'nullable|date',
            'termination_effective_date'=> 'nullable|date',
            'termination_date_hijri'=> 'nullable|date',
            'termination_notice_date_hijri'=> 'nullable|date',
            'termination_effective_date_hijri' => 'nullable|date',
            'vacation_due_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'vacation_due_date_hijri' => 'nullable|date',
            'bank_id' => 'nullable|integer',
            'current_flag' => 'nullable|in:0,1',
            'terminate_flag' => 'nullable|in:0,1',
            'contract_status' => 'nullable|in:0,1',
            'final_set_flag' => 'nullable|max:10',
            'vacation_month_due' => 'nullable|max:20',
            'no_login' => 'nullable|max:20',
            'bank_account_no' => 'nullable|max:30',
            'contract_type' => 'nullable|max:50',
            'contract_family_flag' => 'nullable|max:50',
            'contract_no' => 'nullable|max:50',
            'contract_duration' => 'nullable|max:50',
            'time_unit_duration' => 'nullable|max:50',
            'termination_type' => 'nullable|max:50',
            'contract_created_by' => 'nullable|max:100',
            'terminated_by' => 'nullable|max:100',
            'terminated_when' => 'nullable|max:100',
            'vacation_days' => 'nullable|max:100',
            'renew' => 'nullable|max:100',
            'rank' => 'nullable|max:100',
            'work_hrs' => 'nullable|max:100',
            'contract_remark' => 'nullable|max:500',
            'termination_remark' => 'nullable|max:500',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployment = Employment::findOrFail($id); 

        $oEmployments = $oEmployment->update([
            'start_date' =>  $oInput['start_date'],
            'end_date' =>  $oInput['end_date'],
            'start_date_hijri'=>  $oInput['start_date_hijri'],
            'end_date_hijri'=>  $oInput['end_date_hijri'],
            'termination_date'  =>  $oInput['termination_date'],
            'termination_notice_date'  =>  $oInput['termination_notice_date'],
            'termination_effective_date' =>  $oInput['termination_effective_date'],
            'termination_date_hijri' =>  $oInput['termination_date_hijri'],
            'termination_notice_date_hijri'=>  $oInput['termination_notice_date_hijri'],
            'termination_effective_date_hijri'           =>  $oInput['termination_effective_date_hijri'],
            'vacation_due_date'      =>  $oInput['vacation_due_date'],
            'contract_date'          =>  $oInput['contract_date'],
            'vacation_due_date_hijri'=>  $oInput['vacation_due_date_hijri'],
            'bank_id'             =>  $oInput['bank_id'],
            'current_flag'        =>  $oInput['current_flag'],
            'terminate_flag'      =>  $oInput['terminate_flag'],
            'contract_status'     =>  $oInput['contract_status'],
            'final_set_flag'      =>  $oInput['final_set_flag'],
            'vacation_month_due'  =>  $oInput['vacation_month_due'],
            'no_login'            =>  $oInput['no_login'],
            'contract_type'       =>  $oInput['contract_type'],
            'contract_family_flag'=>  $oInput['contract_family_flag'],
            'contract_duration'  =>  $oInput['contract_duration'],
            'contract_no'        =>  $oInput['contract_no'],
            'bank_account_no'    =>  $oInput['bank_account_no'],
            'time_unit_duration' =>  $oInput['time_unit_duration'],
            'termination_type'   =>  $oInput['termination_type'],
            'contract_created_by'=>  $oInput['contract_created_by'],
            'terminated_by'     =>  $oInput['terminated_by'],
            'terminated_when'   =>  $oInput['terminated_when'],
            'vacation_days'     =>  $oInput['vacation_days'],
            'renew'             =>  $oInput['renew'],
            'rank'              =>  $oInput['rank'],
            'work_hrs'          =>  $oInput['work_hrs'],
            'termination_remark'=>  $oInput['termination_remark'],
            'contract_remark'=>  $oInput['contract_remark'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployment = Employment::with(['companyId','branchId','employeeId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employment"]), $oEmployment, false);
        
        $this->urlRec(46, 3, $oResponse);
        
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
                $oEmployment = Employment::find($id);
                $oEmployment->update(['deleted_by'=>Auth::user()->id]);
                if($oEmployment){
                    $oEmployment->delete();
                }
            }
        }else{
            $oEmployment = Employment::findOrFail($aIds);
            $oEmployment->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employment"]));
        $this->urlRec(46, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEmployment = Employment::onlyTrashed()->with(['companyId','branchId','employeeId','cityId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Employment"]), $oEmployment, false);
        $this->urlRec(46, 5, $oResponse); 
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
                
                $oEmployment = Employment::onlyTrashed()->find($id);
                if($oEmployment){
                    $oEmployment->restore();
                }
            }
        }else{
            $oEmployment = Employment::onlyTrashed()->findOrFail($aIds);
            $oEmployment->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Employment"]));
        $this->urlRec(46, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEmployment = Employment::onlyTrashed()->findOrFail($id);
        
        $oEmployment->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Employment"]));
        $this->urlRec(46, 7, $oResponse);
        return $oResponse;
    }
}
