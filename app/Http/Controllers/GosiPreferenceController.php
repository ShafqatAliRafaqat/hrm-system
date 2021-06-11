<?php

namespace App\Http\Controllers;

use App\Models\GosiPreference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class GosiPreferenceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the GosiPreferences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = GosiPreference::with(['companyId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"gosi_non_saudi",$oQb);
        $oQb = QB::where($oInput,"gosi_saudi",$oQb);
        $oQb = QB::where($oInput,"gosi_saudi_company",$oQb);
        $oQb = QB::where($oInput,"gosi_non_saudi_company",$oQb);
        $oQb = QB::where($oInput,"gosi_payroll_flag",$oQb);
        $oQb = QB::whereDate($oInput,"date",$oQb);
        
        $oGosiPreferences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Gosi Preference"]), $oGosiPreferences, false);
        $this->urlRec(35, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'gosi_non_saudi'=> 'required|max:5|min:0',
            'gosi_saudi'    => 'nullable|max:5|min:0',
            'gosi_saudi_company'=> 'nullable|max:5|min:0',
            'gosi_non_saudi_company'=> 'nullable|max:5|min:0',
            'gosi_payroll_flag'=> 'nullable|in:0,1',
            'date'=> 'nullable|date',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oGosiPreference = GosiPreference::create([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'gosi_non_saudi'=>  $oInput['gosi_non_saudi'],
            'gosi_saudi'    =>  $oInput['gosi_saudi'],
            'gosi_saudi_company'=>  $oInput['gosi_saudi_company'],
            'gosi_non_saudi_company'=>  $oInput['gosi_non_saudi_company'],
            'gosi_payroll_flag'=>  $oInput['gosi_payroll_flag'],
            'date'          =>  $oInput['date'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oGosiPreference= GosiPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($oGosiPreference->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Gosi Preference"]), $oGosiPreference, false);
        $this->urlRec(35, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oGosiPreference= GosiPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Gosi Preference"]), $oGosiPreference, false);
        $this->urlRec(35, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'gosi_non_saudi'=> 'required|max:5|min:0',
            'gosi_saudi'    => 'nullable|max:5|min:0',
            'gosi_saudi_company'=> 'nullable|max:5|min:0',
            'gosi_non_saudi_company'=> 'nullable|max:5|min:0',
            'gosi_payroll_flag'=> 'nullable|in:0,1',
            'date'=> 'nullable|date',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oGosiPreference = GosiPreference::findOrFail($id); 

        $oGosiPreferences = $oGosiPreference->update([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'gosi_non_saudi'=>  $oInput['gosi_non_saudi'],
            'gosi_saudi'    =>  $oInput['gosi_saudi'],
            'gosi_saudi_company'=>  $oInput['gosi_saudi_company'],
            'gosi_non_saudi_company'=>  $oInput['gosi_non_saudi_company'],
            'gosi_payroll_flag' =>  $oInput['gosi_payroll_flag'],
            'date'              =>  $oInput['date'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oGosiPreference = GosiPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Gosi Preference"]), $oGosiPreference, false);
        
        $this->urlRec(35, 3, $oResponse);
        
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
                $oGosiPreference = GosiPreference::find($id);
                if($oGosiPreference){
                    $oGosiPreference->delete();
                }
            }
        }else{
            $oGosiPreference = GosiPreference::findOrFail($aIds);
            $oGosiPreference->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Gosi Preference"]));
        $this->urlRec(35, 4, $oResponse);
        return $oResponse;
    }
}