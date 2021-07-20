<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeLeaveController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeLeaves
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeLeave::with(['employeeId','leaveId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"start_date",$oQb);
        $oQb = QB::whereDate($oInput,"end_date",$oQb);
        $oQb = QB::whereDate($oInput,"start_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"end_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"back_to_work_date",$oQb);
        $oQb = QB::whereDate($oInput,"back_to_work_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"application_date",$oQb);
        $oQb = QB::whereDate($oInput,"application_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"vacation_due_date",$oQb);
        $oQb = QB::whereDate($oInput,"work_from_date",$oQb);
        $oQb = QB::whereDate($oInput,"work_from_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"work_to_date",$oQb);
        $oQb = QB::whereDate($oInput,"work_to_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"balance",$oQb);
        $oQb = QB::whereLike($oInput,"re_entry_exit_visa_no",$oQb);
        $oQb = QB::whereLike($oInput,"status",$oQb);
        $oQb = QB::whereLike($oInput,"contract_no",$oQb);
        $oQb = QB::whereLike($oInput,"vacation_value",$oQb);
        $oQb = QB::whereLike($oInput,"ticket_value",$oQb);
        $oQb = QB::whereLike($oInput,"end_service_value",$oQb);
        $oQb = QB::whereLike($oInput,"pay_roll_flag",$oQb);
        $oQb = QB::whereLike($oInput,"salary_before_leave",$oQb);
        $oQb = QB::whereLike($oInput,"vacation_value_paid",$oQb);
        $oQb = QB::whereLike($oInput,"ticket_value_paid",$oQb);
        $oQb = QB::whereLike($oInput,"end_service_value_paid",$oQb);
        $oQb = QB::whereLike($oInput,"unused_days",$oQb);
        $oQb = QB::whereLike($oInput,"begbal_setup",$oQb);
        $oQb = QB::whereLike($oInput,"vacation_days",$oQb);
        $oQb = QB::whereLike($oInput,"leave_due_days",$oQb);
        $oQb = QB::whereLike($oInput,"req_no",$oQb);
        $oQb = QB::whereLike($oInput,"days_req",$oQb);
        $oQb = QB::whereLike($oInput,"isvdue_paid",$oQb);
        $oQb = QB::whereLike($oInput,"monthly_salary",$oQb);
        $oQb = QB::whereLike($oInput,"full_salary",$oQb);
        $oQb = QB::whereLike($oInput,"period_covered",$oQb);
        $oQb = QB::whereLike($oInput,"paid_days",$oQb);
        $oQb = QB::whereLike($oInput,"duration",$oQb);
        $oQb = QB::whereLike($oInput,"grant_days",$oQb);
        $oQb = QB::whereLike($oInput,"month_due",$oQb);
        $oQb = QB::whereLike($oInput,"remaining_balance",$oQb);
        $oQb = QB::whereLike($oInput,"remarks",$oQb);
        $oQb = QB::where($oInput,"leave_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeLeaves = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Leave"]), $oEmployeeLeaves, false);
        $this->urlRec(59, 0, $oResponse);
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
            'back_to_work_date' => 'nullable|date',
            'back_to_work_date_hijri' => 'nullable|date',
            'application_date' => 'nullable|date',
            'application_date_hijri' => 'nullable|date',
            'vacation_due_date' => 'nullable|date',
            'vacation_due_date_hijri' => 'nullable|date',
            'work_from_date' => 'nullable|date',
            'work_from_date_hijri' => 'nullable|date',
            'work_to_date' => 'nullable|date',
            'work_to_date_hijri' => 'nullable|date',
            'balance' => 'nullable|max:50',
            're_entry_exit_visa_no' => 'nullable|max:50',
            'status' => 'nullable|max:50',
            'contract_no' => 'nullable|max:50',
            'vacation_value' => 'nullable|max:50',
            'ticket_value' => 'nullable|max:50',
            'end_service_value' => 'nullable|max:50',
            'pay_roll_flag' => 'nullable|max:50',
            'salary_before_leave' => 'nullable|max:50',
            'vacation_value_paid' => 'nullable|max:50',
            'ticket_value_paid' => 'nullable|max:50',
            'end_service_value_paid' => 'nullable|max:50',
            'unused_days' => 'nullable|max:50',
            'begbal_setup' => 'nullable|max:50',
            'vacation_days' => 'nullable|max:50',
            'leave_due_days' => 'nullable|max:50',
            'req_no' => 'nullable|max:50',
            'days_req' => 'nullable|max:50',
            'isvdue_paid' => 'nullable|max:50',
            'monthly_salary' => 'nullable|max:50',
            'full_salary' => 'nullable|max:50',
            'period_covered' => 'nullable|max:50',
            'paid_days' => 'nullable|max:50',
            'duration' => 'nullable|max:50',
            'grant_days' => 'nullable|max:50',
            'month_due' => 'nullable|max:50',
            'remaining_balance' => 'nullable|max:50',
            'remarks' => 'nullable|max:50',
            'leave_id' => 'required|exists:leaves,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeLeave = EmployeeLeave::create([
            'start_date' =>  $oInput['start_date'],
            'end_date' =>  $oInput['end_date'],
            'start_date_hijri'=>  $oInput['start_date_hijri'],
            'end_date_hijri'=>  $oInput['end_date_hijri'],
            'back_to_work_date'   =>  $oInput['back_to_work_date'],
            'back_to_work_date_hijri'   =>  $oInput['back_to_work_date_hijri'],
            'application_date'   =>  $oInput['application_date'],
            'application_date_hijri'=>  $oInput['application_date_hijri'],
            'vacation_due_date'=>  $oInput['vacation_due_date'],
            'vacation_due_date_hijri'=>  $oInput['vacation_due_date_hijri'],
            'work_from_date'=>  $oInput['work_from_date'],
            'work_from_date_hijri'=>  $oInput['work_from_date_hijri'],
            'work_to_date'=>  $oInput['work_to_date'],
            'work_to_date_hijri'=>  $oInput['work_to_date_hijri'],
            'balance'=>  $oInput['balance'],
            're_entry_exit_visa_no'=>  $oInput['re_entry_exit_visa_no'],
            'status'   =>  $oInput['status'],
            'contract_no'   =>  $oInput['contract_no'],
            'vacation_value'   =>  $oInput['vacation_value'],
            'ticket_value'   =>  $oInput['ticket_value'],
            'end_service_value'   =>  $oInput['end_service_value'],
            'pay_roll_flag'   =>  $oInput['pay_roll_flag'],
            'salary_before_leave'   =>  $oInput['salary_before_leave'],
            'vacation_value_paid'   =>  $oInput['vacation_value_paid'],
            'ticket_value_paid'   =>  $oInput['ticket_value_paid'],
            'end_service_value_paid'   =>  $oInput['end_service_value_paid'],
            'unused_days'   =>  $oInput['unused_days'],
            'begbal_setup'   =>  $oInput['begbal_setup'],
            'vacation_days'   =>  $oInput['vacation_days'],
            'leave_due_days'   =>  $oInput['leave_due_days'],
            'req_no'   =>  $oInput['req_no'],
            'days_req'   =>  $oInput['days_req'],
            'isvdue_paid'   =>  $oInput['isvdue_paid'],
            'monthly_salary'   =>  $oInput['monthly_salary'],
            'full_salary'   =>  $oInput['full_salary'],
            'period_covered'   =>  $oInput['period_covered'],
            'paid_days'   =>  $oInput['paid_days'],
            'duration'   =>  $oInput['duration'],
            'grant_days'   =>  $oInput['grant_days'],
            'month_due'   =>  $oInput['month_due'],
            'remaining_balance'   =>  $oInput['remaining_balance'],
            'remarks'        =>  $oInput['remarks'],
            'employee_id'   =>  $oInput['employee_id'],
            'leave_id'      =>  $oInput['leave_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeLeave= EmployeeLeave::with(['employeeId','leaveId','createdBy','updatedBy'])->findOrFail($oEmployeeLeave->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Leave"]), $oEmployeeLeave, false);
        $this->urlRec(59, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeLeave= EmployeeLeave::with(['employeeId','leaveId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Leave"]), $oEmployeeLeave, false);
        $this->urlRec(59, 2, $oResponse);
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
            'back_to_work_date' => 'nullable|date',
            'back_to_work_date_hijri' => 'nullable|date',
            'application_date' => 'nullable|date',
            'application_date_hijri' => 'nullable|date',
            'vacation_due_date' => 'nullable|date',
            'vacation_due_date_hijri' => 'nullable|date',
            'work_from_date' => 'nullable|date',
            'work_from_date_hijri' => 'nullable|date',
            'work_to_date' => 'nullable|date',
            'work_to_date_hijri' => 'nullable|date',
            'balance' => 'nullable|max:50',
            're_entry_exit_visa_no' => 'nullable|max:50',
            'status' => 'nullable|max:50',
            'contract_no' => 'nullable|max:50',
            'vacation_value' => 'nullable|max:50',
            'ticket_value' => 'nullable|max:50',
            'end_service_value' => 'nullable|max:50',
            'pay_roll_flag' => 'nullable|max:50',
            'salary_before_leave' => 'nullable|max:50',
            'vacation_value_paid' => 'nullable|max:50',
            'ticket_value_paid' => 'nullable|max:50',
            'end_service_value_paid' => 'nullable|max:50',
            'unused_days' => 'nullable|max:50',
            'begbal_setup' => 'nullable|max:50',
            'vacation_days' => 'nullable|max:50',
            'leave_due_days' => 'nullable|max:50',
            'req_no' => 'nullable|max:50',
            'days_req' => 'nullable|max:50',
            'isvdue_paid' => 'nullable|max:50',
            'monthly_salary' => 'nullable|max:50',
            'full_salary' => 'nullable|max:50',
            'period_covered' => 'nullable|max:50',
            'paid_days' => 'nullable|max:50',
            'duration' => 'nullable|max:50',
            'grant_days' => 'nullable|max:50',
            'month_due' => 'nullable|max:50',
            'remaining_balance' => 'nullable|max:50',
            'remarks' => 'nullable|max:50',
            'leave_id' => 'required|exists:leaves,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeLeave = EmployeeLeave::findOrFail($id); 

        $oEmployeeLeaves = $oEmployeeLeave->update([
            'start_date' =>  $oInput['start_date'],
            'end_date' =>  $oInput['end_date'],
            'start_date_hijri'=>  $oInput['start_date_hijri'],
            'end_date_hijri'=>  $oInput['end_date_hijri'],
            'back_to_work_date'   =>  $oInput['back_to_work_date'],
            'back_to_work_date_hijri'   =>  $oInput['back_to_work_date_hijri'],
            'application_date'   =>  $oInput['application_date'],
            'application_date_hijri'=>  $oInput['application_date_hijri'],
            'vacation_due_date'=>  $oInput['vacation_due_date'],
            'vacation_due_date_hijri'=>  $oInput['vacation_due_date_hijri'],
            'work_from_date'=>  $oInput['work_from_date'],
            'work_from_date_hijri'=>  $oInput['work_from_date_hijri'],
            'work_to_date'=>  $oInput['work_to_date'],
            'work_to_date_hijri'=>  $oInput['work_to_date_hijri'],
            'balance'=>  $oInput['balance'],
            're_entry_exit_visa_no'=>  $oInput['re_entry_exit_visa_no'],
            'status'   =>  $oInput['status'],
            'contract_no'   =>  $oInput['contract_no'],
            'vacation_value'   =>  $oInput['vacation_value'],
            'ticket_value'   =>  $oInput['ticket_value'],
            'end_service_value'   =>  $oInput['end_service_value'],
            'pay_roll_flag'   =>  $oInput['pay_roll_flag'],
            'salary_before_leave'   =>  $oInput['salary_before_leave'],
            'vacation_value_paid'   =>  $oInput['vacation_value_paid'],
            'ticket_value_paid'   =>  $oInput['ticket_value_paid'],
            'end_service_value_paid'   =>  $oInput['end_service_value_paid'],
            'unused_days'   =>  $oInput['unused_days'],
            'begbal_setup'   =>  $oInput['begbal_setup'],
            'vacation_days'   =>  $oInput['vacation_days'],
            'leave_due_days'   =>  $oInput['leave_due_days'],
            'req_no'   =>  $oInput['req_no'],
            'days_req'   =>  $oInput['days_req'],
            'isvdue_paid'   =>  $oInput['isvdue_paid'],
            'monthly_salary'   =>  $oInput['monthly_salary'],
            'full_salary'   =>  $oInput['full_salary'],
            'period_covered'   =>  $oInput['period_covered'],
            'paid_days'   =>  $oInput['paid_days'],
            'duration'   =>  $oInput['duration'],
            'grant_days'   =>  $oInput['grant_days'],
            'month_due'   =>  $oInput['month_due'],
            'remaining_balance'   =>  $oInput['remaining_balance'],
            'remarks'   =>  $oInput['remarks'],
            'employee_id'   =>  $oInput['employee_id'],
            'leave_id'=>  $oInput['leave_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeLeave = EmployeeLeave::with(['employeeId','leaveId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Leave"]), $oEmployeeLeave, false);
        
        $this->urlRec(59, 3, $oResponse);
        
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
                $oEmployeeLeave = EmployeeLeave::find($id);
                if($oEmployeeLeave){
                    $oEmployeeLeave->delete();
                }
            }
        }else{
            $oEmployeeLeave = EmployeeLeave::findOrFail($aIds);
            $oEmployeeLeave->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Leave"]));
        $this->urlRec(59, 4, $oResponse);
        return $oResponse;
    }
}
