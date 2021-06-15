<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDeducation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeDeducationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeDeducations
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeDeducation::with(['companyId','branchId','employeeId','deductionId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"start_date",$oQb);
        $oQb = QB::whereDate($oInput,"end_date",$oQb);
        $oQb = QB::whereDate($oInput,"start_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"end_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"loan_date",$oQb);
        $oQb = QB::whereDate($oInput,"loan_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"contract_no",$oQb);
        $oQb = QB::whereLike($oInput,"amount",$oQb);
        $oQb = QB::whereLike($oInput,"amount_to_be_paid",$oQb);
        $oQb = QB::whereLike($oInput,"amount_paid",$oQb);
        $oQb = QB::whereLike($oInput,"paid_flag",$oQb);
        $oQb = QB::whereLike($oInput,"to_be_paid",$oQb);
        $oQb = QB::whereLike($oInput,"leave_no",$oQb);
        $oQb = QB::whereLike($oInput,"req_no",$oQb);
        $oQb = QB::whereLike($oInput,"status",$oQb);
        $oQb = QB::whereLike($oInput,"no_of_payments",$oQb);
        $oQb = QB::whereLike($oInput,"deduction_remarks",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"deduction_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeDeducations = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Deducation"]), $oEmployeeDeducations, false);
        $this->urlRec(48, 0, $oResponse);
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
            'loan_date'   => 'nullable|date',
            'loan_date_hijri'=> 'nullable|date',
            'contract_no' => 'nullable|integer',
            'to_be_paid' => 'nullable|in:0,1',
            'leave_no' => 'nullable|in:0,1',
            'amount' => 'nullable|max:5|min:0',
            'amount_to_be_paid' => 'nullable|max:5|min:0',
            'amount_paid' => 'nullable|max:5|min:0',
            'paid_flag' => 'nullable|max:5|min:0',
            'req_no' => 'nullable|max:10',
            'status' => 'nullable|max:10',
            'no_of_payments' => 'nullable|max:10',
            'deduction_remarks' => 'nullable|max:500',
            'deduction_id' => 'required|exists:deductions,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeDeducation = EmployeeDeducation::create([
            'start_date' =>  $oInput['start_date'],
            'end_date' =>  $oInput['end_date'],
            'start_date_hijri'=>  $oInput['start_date_hijri'],
            'end_date_hijri'=>  $oInput['end_date_hijri'],
            'loan_date'  =>  $oInput['loan_date'],
            'transaction_date'  =>  $oInput['transaction_date'],
            'loan_date_hijri' =>  $oInput['loan_date_hijri'],
            'transaction_date_hijri'=>  $oInput['transaction_date_hijri'],
            'contract_no'   =>  $oInput['contract_no'],
            'amount'        =>  $oInput['amount'],
            'amount_to_be_paid'   =>  $oInput['amount_to_be_paid'],
            'amount_paid'   =>  $oInput['amount_paid'],
            'paid_flag'      =>  $oInput['paid_flag'],
            'to_be_paid'   =>  $oInput['to_be_paid'],
            'leave_no'=>  $oInput['leave_no'],
            'req_no'=>  $oInput['req_no'],
            'status'    =>  $oInput['status'],
            'no_of_payments' =>  $oInput['no_of_payments'],
            'deduction_remarks'=>  $oInput['deduction_remarks'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'deduction_id'=>  $oInput['deduction_id'],
            'company_id'    =>  $oInput['company_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeDeducation= EmployeeDeducation::with(['companyId','branchId','employeeId','deductionId','createdBy','updatedBy','deletedBy'])->findOrFail($oEmployeeDeducation->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Deducation"]), $oEmployeeDeducation, false);
        $this->urlRec(48, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeDeducation= EmployeeDeducation::with(['companyId','branchId','employeeId','deductionId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Deducation"]), $oEmployeeDeducation, false);
        $this->urlRec(48, 2, $oResponse);
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
            'loan_date'   => 'nullable|date',
            'loan_date_hijri'=> 'nullable|date',
            'contract_no' => 'nullable|integer',
            'paid_flag' => 'nullable|max:5|min:0',
            'req_no' => 'nullable|max:10',
            'status' => 'nullable|max:10',
            'to_be_paid' => 'nullable|in:0,1',
            'leave_no' => 'nullable|in:0,1',

            'amount' => 'nullable|max:5|min:0',
            'amount_to_be_paid' => 'nullable|max:5|min:0',
            'amount_paid' => 'nullable|max:5|min:0',
            
            'no_of_payments' => 'nullable|max:10',
            'deduction_remarks' => 'nullable|max:500',
            'deduction_id' => 'required|exists:deductions,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeDeducation = EmployeeDeducation::findOrFail($id); 

        $oEmployeeDeducations = $oEmployeeDeducation->update([
            'start_date' =>  $oInput['start_date'],
            'end_date' =>  $oInput['end_date'],
            'start_date_hijri'=>  $oInput['start_date_hijri'],
            'end_date_hijri'=>  $oInput['end_date_hijri'],
            'loan_date'  =>  $oInput['loan_date'],
            'transaction_date'  =>  $oInput['transaction_date'],
            'loan_date_hijri' =>  $oInput['loan_date_hijri'],
            'transaction_date_hijri'=>  $oInput['transaction_date_hijri'],
            'contract_no'   =>  $oInput['contract_no'],
            'amount'        =>  $oInput['amount'],
            'amount_to_be_paid'   =>  $oInput['amount_to_be_paid'],
            'amount_paid'   =>  $oInput['amount_paid'],
            'paid_flag'      =>  $oInput['paid_flag'],
            'to_be_paid'   =>  $oInput['to_be_paid'],
            'leave_no'=>  $oInput['leave_no'],
            'req_no'=>  $oInput['req_no'],
            'status'    =>  $oInput['status'],
            'no_of_payments' =>  $oInput['no_of_payments'],
            'deduction_remarks'=>  $oInput['deduction_remarks'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'deduction_id'=>  $oInput['deduction_id'],
            'company_id'    =>  $oInput['company_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeDeducation = EmployeeDeducation::with(['companyId','branchId','employeeId','deductionId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Deducation"]), $oEmployeeDeducation, false);
        
        $this->urlRec(48, 3, $oResponse);
        
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
                $oEmployeeDeducation = EmployeeDeducation::find($id);
                $oEmployeeDeducation->update(['deleted_by'=>Auth::user()->id]);
                if($oEmployeeDeducation){
                    $oEmployeeDeducation->delete();
                }
            }
        }else{
            $oEmployeeDeducation = EmployeeDeducation::findOrFail($aIds);
            $oEmployeeDeducation->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Deducation"]));
        $this->urlRec(48, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEmployeeDeducation = EmployeeDeducation::onlyTrashed()->with(['companyId','branchId','employeeId','deductionId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Employee Deducation"]), $oEmployeeDeducation, false);
        $this->urlRec(48, 5, $oResponse); 
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
                
                $oEmployeeDeducation = EmployeeDeducation::onlyTrashed()->find($id);
                if($oEmployeeDeducation){
                    $oEmployeeDeducation->restore();
                }
            }
        }else{
            $oEmployeeDeducation = EmployeeDeducation::onlyTrashed()->findOrFail($aIds);
            $oEmployeeDeducation->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Employee Deducation"]));
        $this->urlRec(48, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEmployeeDeducation = EmployeeDeducation::onlyTrashed()->findOrFail($id);
        
        $oEmployeeDeducation->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Employee Deducation"]));
        $this->urlRec(48, 7, $oResponse);
        return $oResponse;
    }
}
