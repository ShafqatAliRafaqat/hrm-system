<?php

namespace App\Http\Controllers;

use App\Models\PayrollPreference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class PayrollPreferenceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the PayrollPreferences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = PayrollPreference::with(['companyId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"hours_per_month",$oQb);
        $oQb = QB::where($oInput,"days_per_month",$oQb);
        $oQb = QB::where($oInput,"ot",$oQb);
        $oQb = QB::where($oInput,"tardiness_factor",$oQb);
        $oQb = QB::where($oInput,"absent_factor",$oQb);
        $oQb = QB::where($oInput,"calc_outside_payroll",$oQb);
        $oQb = QB::where($oInput,"calc_overtime_payroll",$oQb);
        $oQb = QB::where($oInput,"posttoacct_ot_outside_payroll",$oQb);
        $oQb = QB::where($oInput,"days_only",$oQb);
        $oQb = QB::where($oInput,"full_housing",$oQb);
        
        $oPayrollPreferences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Payroll Preference"]), $oPayrollPreferences, false);
        $this->urlRec(36, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'hours_per_month'=> 'required|integer',
            'days_per_month'    => 'nullable|integer',
            'ot'=> 'nullable|integer',
            'tardiness_factor'=> 'nullable|integer|max:5|min:0',
            'absent_factor'=> 'nullable|integer|max:5|min:0',
            'calc_outside_payroll'=> 'nullable|in:0,1',
            'posttoacct_ot_outside_payroll'=> 'nullable|in:0,1',
            'calc_overtime_payroll'=> 'nullable|in:0,1',
            'days_only'=> 'nullable|in:0,1',
            'full_housing'=> 'nullable|in:0,1',

        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oPayrollPreference = PayrollPreference::create([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'hours_per_month'=>  $oInput['hours_per_month'],
            'days_per_month' =>  $oInput['days_per_month'],
            'ot'             =>  $oInput['ot'],
            'tardiness_factor'=>  $oInput['tardiness_factor'],
            'absent_factor'=>  $oInput['absent_factor'],
            'calc_outside_payroll'=>  $oInput['calc_outside_payroll'],
            'posttoacct_ot_outside_payroll'=>  $oInput['posttoacct_ot_outside_payroll'],
            'calc_overtime_payroll'=>  $oInput['calc_overtime_payroll'],
            'days_only'   =>  $oInput['days_only'],
            'full_housing'   =>  $oInput['full_housing'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oPayrollPreference= PayrollPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($oPayrollPreference->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Payroll Preference"]), $oPayrollPreference, false);
        $this->urlRec(36, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oPayrollPreference= PayrollPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Payroll Preference"]), $oPayrollPreference, false);
        $this->urlRec(36, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'hours_per_month'=> 'required|integer',
            'days_per_month'    => 'nullable|integer',
            'ot'=> 'nullable|integer',
            'tardiness_factor'=> 'nullable|integer|max:5|min:0',
            'absent_factor'=> 'nullable|integer|max:5|min:0',
            'calc_outside_payroll'=> 'nullable|in:0,1',
            'posttoacct_ot_outside_payroll'=> 'nullable|in:0,1',
            'calc_overtime_payroll'=> 'nullable|in:0,1',
            'days_only'=> 'nullable|in:0,1',
            'full_housing'=> 'nullable|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oPayrollPreference = PayrollPreference::findOrFail($id); 

        $oPayrollPreferences = $oPayrollPreference->update([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'hours_per_month'=>  $oInput['hours_per_month'],
            'days_per_month' =>  $oInput['days_per_month'],
            'ot'             =>  $oInput['ot'],
            'tardiness_factor'=>  $oInput['tardiness_factor'],
            'absent_factor'=>  $oInput['absent_factor'],
            'calc_outside_payroll'=>  $oInput['calc_outside_payroll'],
            'posttoacct_ot_outside_payroll'=>  $oInput['posttoacct_ot_outside_payroll'],
            'calc_overtime_payroll'=>  $oInput['calc_overtime_payroll'],
            'days_only'   =>  $oInput['days_only'],
            'full_housing'   =>  $oInput['full_housing'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oPayrollPreference = PayrollPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Payroll Preference"]), $oPayrollPreference, false);
        
        $this->urlRec(36, 3, $oResponse);
        
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
                $oPayrollPreference = PayrollPreference::find($id);
                if($oPayrollPreference){
                    $oPayrollPreference->delete();
                }
            }
        }else{
            $oPayrollPreference = PayrollPreference::findOrFail($aIds);
            $oPayrollPreference->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Payroll Preference"]));
        $this->urlRec(36, 4, $oResponse);
        return $oResponse;
    }
}