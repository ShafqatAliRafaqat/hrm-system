<?php

namespace App\Http\Controllers;

use App\Models\LeaveSpecificPreference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class LeaveSpecificPreferenceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the LeaveSpecificPreferences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = LeaveSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"forward_vacation_days_balance",$oQb);
        $oQb = QB::where($oInput,"current_days_month",$oQb);
        $oQb = QB::where($oInput,"use_latest_salary_calc",$oQb);
        $oQb = QB::where($oInput,"include_vacation_days",$oQb);
        $oQb = QB::where($oInput,"days_in_year",$oQb);
        $oQb = QB::whereDate($oInput,"fiscal_year_end",$oQb);
        $oQb = QB::where($oInput,"vacation_days_per_contract",$oQb);
        $oQb = QB::where($oInput,"vacation_per_contract",$oQb);
        $oQb = QB::where($oInput,"include_eos",$oQb);
        
        $oLeaveSpecificPreferences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Leave Specific Preference"]), $oLeaveSpecificPreferences, false);
        $this->urlRec(39, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'forward_vacation_days_balance'=> 'required|in:0,1',
            'current_days_month'    => 'nullable|in:0,1',
            'use_latest_salary_calc'=> 'nullable|in:0,1',
            'include_vacation_days'=> 'nullable|in:0,1',
            'days_in_year'=> 'nullable|in:0,1',
            'fiscal_year_end'=> 'required|date',
            'vacation_per_contract'=> 'nullable|integer',
            'vacation_days_per_contract'=> 'nullable|integer',
            'include_eos'=> 'nullable|in:0,1',

        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oLeaveSpecificPreference = LeaveSpecificPreference::create([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'forward_vacation_days_balance'=>  $oInput['forward_vacation_days_balance'],
            'current_days_month'    =>  $oInput['current_days_month'],
            'use_latest_salary_calc'=>  $oInput['use_latest_salary_calc'],
            'include_vacation_days'=>  $oInput['include_vacation_days'],
            'days_in_year'=>  $oInput['days_in_year'],
            'fiscal_year_end'=>  $oInput['fiscal_year_end'],
            'vacation_per_contract'=>  $oInput['vacation_per_contract'],
            'vacation_days_per_contract'=>  $oInput['vacation_days_per_contract'],
            'include_eos'   =>  $oInput['include_eos'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oLeaveSpecificPreference= LeaveSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($oLeaveSpecificPreference->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Leave Specific Preference"]), $oLeaveSpecificPreference, false);
        $this->urlRec(39, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oLeaveSpecificPreference= LeaveSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Leave Specific Preference"]), $oLeaveSpecificPreference, false);
        $this->urlRec(39, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'forward_vacation_days_balance'=> 'required|in:0,1',
            'current_days_month'    => 'nullable|in:0,1',
            'use_latest_salary_calc'=> 'nullable|in:0,1',
            'include_vacation_days'=> 'nullable|in:0,1',
            'days_in_year'=> 'nullable|in:0,1',
            'fiscal_year_end'=> 'required|date',
            'vacation_per_contract'=> 'nullable|integer',
            'vacation_days_per_contract'=> 'nullable|integer',
            'include_eos'=> 'nullable|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oLeaveSpecificPreference = LeaveSpecificPreference::findOrFail($id); 

        $oLeaveSpecificPreferences = $oLeaveSpecificPreference->update([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'forward_vacation_days_balance'=>  $oInput['forward_vacation_days_balance'],
            'current_days_month'    =>  $oInput['current_days_month'],
            'use_latest_salary_calc'=>  $oInput['use_latest_salary_calc'],
            'include_vacation_days'=>  $oInput['include_vacation_days'],
            'days_in_year'=>  $oInput['days_in_year'],
            'fiscal_year_end'=>  $oInput['fiscal_year_end'],
            'vacation_per_contract'=>  $oInput['vacation_per_contract'],
            'vacation_days_per_contract'=>  $oInput['vacation_days_per_contract'],
            'include_eos'   =>  $oInput['include_eos'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oLeaveSpecificPreference = LeaveSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Leave Specific Preference"]), $oLeaveSpecificPreference, false);
        
        $this->urlRec(39, 3, $oResponse);
        
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
                $oLeaveSpecificPreference = LeaveSpecificPreference::find($id);
                if($oLeaveSpecificPreference){
                    $oLeaveSpecificPreference->delete();
                }
            }
        }else{
            $oLeaveSpecificPreference = LeaveSpecificPreference::findOrFail($aIds);
            $oLeaveSpecificPreference->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Leave Specific Preference"]));
        $this->urlRec(39, 4, $oResponse);
        return $oResponse;
    }
}