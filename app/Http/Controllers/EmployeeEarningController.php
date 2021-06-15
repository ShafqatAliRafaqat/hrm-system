<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEarning;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeEarningController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeEarnings
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeEarning::with(['companyId','branchId','employeeId','beneficiaryId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"benefit_effective_date",$oQb);
        $oQb = QB::whereDate($oInput,"benefit_end_date",$oQb);
        $oQb = QB::whereDate($oInput,"benefit_effective_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"benefit_end_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"termination_date",$oQb);
        $oQb = QB::whereDate($oInput,"transaction_date",$oQb);
        $oQb = QB::whereDate($oInput,"termination_date_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"transaction_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"contract_no",$oQb);
        $oQb = QB::whereLike($oInput,"amount",$oQb);
        $oQb = QB::whereLike($oInput,"monthly_pay",$oQb);
        $oQb = QB::whereLike($oInput,"absence_pay",$oQb);
        $oQb = QB::whereLike($oInput,"late_pay",$oQb);
        $oQb = QB::whereLike($oInput,"money_value",$oQb);
        $oQb = QB::whereLike($oInput,"final_set_flag",$oQb);
        $oQb = QB::whereLike($oInput,"payment_scheme",$oQb);
        $oQb = QB::whereLike($oInput,"no_of_days",$oQb);
        $oQb = QB::whereLike($oInput,"return_towork",$oQb);
        $oQb = QB::whereLike($oInput,"benefit_remark",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"beneficiary_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeEarnings = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Earning"]), $oEmployeeEarnings, false);
        $this->urlRec(47, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'benefit_effective_date'   => 'nullable|date',
            'benefit_end_date'   => 'nullable|date',
            'benefit_effective_date_hijri'   => 'nullable|date',
            'benefit_end_date_hijri'   => 'nullable|date',
            'termination_date'   => 'nullable|date',
            'transaction_date'   => 'nullable|date',
            'termination_date_hijri'=> 'nullable|date',
            'transaction_date_hijri'=> 'nullable|date',
            'contract_no' => 'nullable|integer',
            'money_value' => 'nullable|in:0,1',
            'final_set_flag' => 'nullable|in:0,1',
            'amount' => 'nullable|max:5|min:0',
            'monthly_pay' => 'nullable|max:5|min:0',
            'absence_pay' => 'nullable|max:5|min:0',
            'late_pay' => 'nullable|max:5|min:0',
            'payment_scheme' => 'nullable|max:10',
            'no_of_days' => 'nullable|max:10',
            'return_towork' => 'nullable|max:10',
            'benefit_remark' => 'nullable|max:500',
            'beneficiary_id' => 'required|exists:beneficiary_types,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeEarning = EmployeeEarning::create([
            'benefit_effective_date' =>  $oInput['benefit_effective_date'],
            'benefit_end_date' =>  $oInput['benefit_end_date'],
            'benefit_effective_date_hijri'=>  $oInput['benefit_effective_date_hijri'],
            'benefit_end_date_hijri'=>  $oInput['benefit_end_date_hijri'],
            'termination_date'  =>  $oInput['termination_date'],
            'transaction_date'  =>  $oInput['transaction_date'],
            'termination_date_hijri' =>  $oInput['termination_date_hijri'],
            'transaction_date_hijri'=>  $oInput['transaction_date_hijri'],
            'contract_no'   =>  $oInput['contract_no'],
            'amount'        =>  $oInput['amount'],
            'monthly_pay'   =>  $oInput['monthly_pay'],
            'absence_pay'   =>  $oInput['absence_pay'],
            'late_pay'      =>  $oInput['late_pay'],
            'money_value'   =>  $oInput['money_value'],
            'final_set_flag'=>  $oInput['final_set_flag'],
            'payment_scheme'=>  $oInput['payment_scheme'],
            'no_of_days'    =>  $oInput['no_of_days'],
            'return_towork' =>  $oInput['return_towork'],
            'benefit_remark'=>  $oInput['benefit_remark'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'beneficiary_id'=>  $oInput['beneficiary_id'],
            'company_id'    =>  $oInput['company_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeEarning= EmployeeEarning::with(['companyId','branchId','employeeId','beneficiaryId','createdBy','updatedBy','deletedBy'])->findOrFail($oEmployeeEarning->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Earning"]), $oEmployeeEarning, false);
        $this->urlRec(47, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeEarning= EmployeeEarning::with(['companyId','branchId','employeeId','beneficiaryId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Earning"]), $oEmployeeEarning, false);
        $this->urlRec(47, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'benefit_effective_date'   => 'nullable|date',
            'benefit_end_date'   => 'nullable|date',
            'benefit_effective_date_hijri'   => 'nullable|date',
            'benefit_end_date_hijri'   => 'nullable|date',
            'termination_date'   => 'nullable|date',
            'transaction_date'   => 'nullable|date',
            'termination_date_hijri'=> 'nullable|date',
            'transaction_date_hijri'=> 'nullable|date',
            'contract_no' => 'nullable|integer',
            'money_value' => 'nullable|in:0,1',
            'final_set_flag' => 'nullable|in:0,1',
            'amount' => 'nullable|max:5|min:0',
            'monthly_pay' => 'nullable|max:5|min:0',
            'absence_pay' => 'nullable|max:5|min:0',
            'late_pay' => 'nullable|max:5|min:0',
            'payment_scheme' => 'nullable|max:10',
            'no_of_days' => 'nullable|max:10',
            'return_towork' => 'nullable|max:10',
            'benefit_remark' => 'nullable|max:500',
            'beneficiary_id' => 'required|exists:beneficiary_types,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeEarning = EmployeeEarning::findOrFail($id); 

        $oEmployeeEarnings = $oEmployeeEarning->update([
            'benefit_effective_date' =>  $oInput['benefit_effective_date'],
            'benefit_end_date' =>  $oInput['benefit_end_date'],
            'benefit_effective_date_hijri'=>  $oInput['benefit_effective_date_hijri'],
            'benefit_end_date_hijri'=>  $oInput['benefit_end_date_hijri'],
            'termination_date'  =>  $oInput['termination_date'],
            'transaction_date'  =>  $oInput['transaction_date'],
            'termination_date_hijri' =>  $oInput['termination_date_hijri'],
            'transaction_date_hijri'=>  $oInput['transaction_date_hijri'],
            'contract_no'   =>  $oInput['contract_no'],
            'amount'        =>  $oInput['amount'],
            'monthly_pay'   =>  $oInput['monthly_pay'],
            'absence_pay'   =>  $oInput['absence_pay'],
            'late_pay'      =>  $oInput['late_pay'],
            'money_value'   =>  $oInput['money_value'],
            'final_set_flag'=>  $oInput['final_set_flag'],
            'payment_scheme'=>  $oInput['payment_scheme'],
            'no_of_days'    =>  $oInput['no_of_days'],
            'return_towork' =>  $oInput['return_towork'],
            'benefit_remark'=>  $oInput['benefit_remark'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'beneficiary_id'=>  $oInput['beneficiary_id'],
            'company_id'    =>  $oInput['company_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeEarning = EmployeeEarning::with(['companyId','branchId','employeeId','beneficiaryId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Earning"]), $oEmployeeEarning, false);
        
        $this->urlRec(47, 3, $oResponse);
        
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
                $oEmployeeEarning = EmployeeEarning::find($id);
                $oEmployeeEarning->update(['deleted_by'=>Auth::user()->id]);
                if($oEmployeeEarning){
                    $oEmployeeEarning->delete();
                }
            }
        }else{
            $oEmployeeEarning = EmployeeEarning::findOrFail($aIds);
            $oEmployeeEarning->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Earning"]));
        $this->urlRec(47, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEmployeeEarning = EmployeeEarning::onlyTrashed()->with(['companyId','branchId','employeeId','beneficiaryId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Employee Earning"]), $oEmployeeEarning, false);
        $this->urlRec(47, 5, $oResponse); 
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
                
                $oEmployeeEarning = EmployeeEarning::onlyTrashed()->find($id);
                if($oEmployeeEarning){
                    $oEmployeeEarning->restore();
                }
            }
        }else{
            $oEmployeeEarning = EmployeeEarning::onlyTrashed()->findOrFail($aIds);
            $oEmployeeEarning->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Employee Earning"]));
        $this->urlRec(47, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEmployeeEarning = EmployeeEarning::onlyTrashed()->findOrFail($id);
        
        $oEmployeeEarning->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Employee Earning"]));
        $this->urlRec(47, 7, $oResponse);
        return $oResponse;
    }
}
