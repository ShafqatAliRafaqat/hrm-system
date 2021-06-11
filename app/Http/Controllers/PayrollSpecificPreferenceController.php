<?php

namespace App\Http\Controllers;

use App\Models\PayrollSpecificPreference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class PayrollSpecificPreferenceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the PayrollSpecificPreferences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = PayrollSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"sub_ledger_id",$oQb);
        $oQb = QB::where($oInput,"monthly_pay",$oQb);
        $oQb = QB::where($oInput,"post_to_account",$oQb);
        $oQb = QB::where($oInput,"return_date",$oQb);
        $oQb = QB::where($oInput,"calculate_extraleave",$oQb);
        $oQb = QB::where($oInput,"use_twoglacct_inbenefits",$oQb);
        $oQb = QB::where($oInput,"map_to_acctg_branch",$oQb);
        $oQb = QB::where($oInput,"payroll_rounding",$oQb);
        $oQb = QB::where($oInput,"attendance_mc",$oQb);
        $oQb = QB::where($oInput,"costcenter_based_attendance",$oQb);
        $oQb = QB::where($oInput,"entry_overtime",$oQb);
        $oQb = QB::where($oInput,"split_payroll",$oQb);
        $oQb = QB::where($oInput,"auto_gosi_calculate",$oQb);
        $oQb = QB::whereLike($oInput,"gosi_alert_days",$oQb);
        
        $oPayrollSpecificPreferences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Payroll Specific Preference"]), $oPayrollSpecificPreferences, false);
        $this->urlRec(38, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'sub_ledger_id'=> 'required|in:0,1',
            'monthly_pay'    => 'nullable|in:0,1',
            'post_to_account'=> 'nullable|in:0,1',
            'return_date'=> 'nullable|in:0,1',
            'calculate_extraleave'=> 'nullable|in:0,1',
            'use_twoglacct_inbenefits'=> 'nullable|in:0,1',
            'payroll_rounding'=> 'nullable|in:0,1',
            'map_to_acctg_branch'=> 'nullable|in:0,1',
            'attendance_mc'=> 'nullable|in:0,1',
            'costcenter_based_attendance'=> 'nullable|in:0,1',
            'entry_overtime'=> 'nullable|in:0,1',
            'split_payroll'=> 'nullable|in:0,1',
            'auto_gosi_calculate'=> 'nullable|in:0,1',
            'gosi_alert_days'=> 'nullable|max:50',

        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oPayrollSpecificPreference = PayrollSpecificPreference::create([
            'company_id'          =>  $oInput['company_id'],
            'branch_id'           =>  $oInput['branch_id'],
            'sub_ledger_id'       =>  $oInput['sub_ledger_id'],
            'monthly_pay'         =>  $oInput['monthly_pay'],
            'post_to_account'     =>  $oInput['post_to_account'],
            'return_date'         =>  $oInput['return_date'],
            'calculate_extraleave'=>  $oInput['calculate_extraleave'],
            'use_twoglacct_inbenefits'=>  $oInput['use_twoglacct_inbenefits'],
            'payroll_rounding'   =>  $oInput['payroll_rounding'],
            'map_to_acctg_branch'=>  $oInput['map_to_acctg_branch'],
            'attendance_mc'      =>  $oInput['attendance_mc'],
            'costcenter_based_attendance'   =>  $oInput['costcenter_based_attendance'],
            'entry_overtime'     =>  $oInput['entry_overtime'],
            'split_payroll'      =>  $oInput['split_payroll'],
            'auto_gosi_calculate'=>  $oInput['auto_gosi_calculate'],
            'gosi_alert_days'   =>  $oInput['gosi_alert_days'],
            'created_by'        =>  Auth::user()->id,
            'updated_by'        =>  Auth::user()->id,
            'created_at'        =>  Carbon::now()->toDateTimeString(),
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);

        $oPayrollSpecificPreference= PayrollSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($oPayrollSpecificPreference->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Payroll Specific Preference"]), $oPayrollSpecificPreference, false);
        $this->urlRec(38, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oPayrollSpecificPreference= PayrollSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Payroll Specific Preference"]), $oPayrollSpecificPreference, false);
        $this->urlRec(38, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'sub_ledger_id'=> 'required|in:0,1',
            'monthly_pay'    => 'nullable|in:0,1',
            'post_to_account'=> 'nullable|in:0,1',
            'return_date'=> 'nullable|in:0,1',
            'calculate_extraleave'=> 'nullable|in:0,1',
            'use_twoglacct_inbenefits'=> 'nullable|in:0,1',
            'payroll_rounding'=> 'nullable|in:0,1',
            'map_to_acctg_branch'=> 'nullable|in:0,1',
            'attendance_mc'=> 'nullable|in:0,1',
            'costcenter_based_attendance'=> 'nullable|in:0,1',
            'entry_overtime'=> 'nullable|in:0,1',
            'split_payroll'=> 'nullable|in:0,1',
            'auto_gosi_calculate'=> 'nullable|in:0,1',
            'gosi_alert_days'=> 'nullable|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oPayrollSpecificPreference = PayrollSpecificPreference::findOrFail($id); 

        $oPayrollSpecificPreferences = $oPayrollSpecificPreference->update([
            'company_id'          =>  $oInput['company_id'],
            'branch_id'           =>  $oInput['branch_id'],
            'sub_ledger_id'       =>  $oInput['sub_ledger_id'],
            'monthly_pay'         =>  $oInput['monthly_pay'],
            'post_to_account'     =>  $oInput['post_to_account'],
            'return_date'         =>  $oInput['return_date'],
            'calculate_extraleave'=>  $oInput['calculate_extraleave'],
            'use_twoglacct_inbenefits'=>  $oInput['use_twoglacct_inbenefits'],
            'payroll_rounding'   =>  $oInput['payroll_rounding'],
            'map_to_acctg_branch'=>  $oInput['map_to_acctg_branch'],
            'attendance_mc'      =>  $oInput['attendance_mc'],
            'costcenter_based_attendance'   =>  $oInput['costcenter_based_attendance'],
            'entry_overtime'     =>  $oInput['entry_overtime'],
            'split_payroll'      =>  $oInput['split_payroll'],
            'auto_gosi_calculate'=>  $oInput['auto_gosi_calculate'],
            'gosi_alert_days'   =>  $oInput['gosi_alert_days'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oPayrollSpecificPreference = PayrollSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Payroll Specific Preference"]), $oPayrollSpecificPreference, false);
        
        $this->urlRec(38, 3, $oResponse);
        
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
                $oPayrollSpecificPreference = PayrollSpecificPreference::find($id);
                if($oPayrollSpecificPreference){
                    $oPayrollSpecificPreference->delete();
                }
            }
        }else{
            $oPayrollSpecificPreference = PayrollSpecificPreference::findOrFail($aIds);
            $oPayrollSpecificPreference->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Payroll Specific Preference"]));
        $this->urlRec(38, 4, $oResponse);
        return $oResponse;
    }
}
