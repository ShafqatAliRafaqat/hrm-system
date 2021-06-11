<?php

namespace App\Http\Controllers;

use App\Models\TerminationSpecificPreference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class TerminationSpecificPreferenceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the TerminationSpecificPreferences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = TerminationSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::whereLike($oInput,"end_service_benefit",$oQb);
        $oQb = QB::where($oInput,"resignation_notice",$oQb);
        $oQb = QB::where($oInput,"termination_notice",$oQb);
        $oQb = QB::where($oInput,"include_eos",$oQb);
         
        $oTerminationSpecificPreferences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Termination Specific Preference"]), $oTerminationSpecificPreferences, false);
        $this->urlRec(40, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'end_service_benefit'=> 'required|max:100',
            'resignation_notice'    => 'nullable|integer',
            'termination_notice'=> 'nullable|integer',
            'include_eos'=> 'nullable|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oTerminationSpecificPreference = TerminationSpecificPreference::create([
            'company_id'         =>  $oInput['company_id'],
            'branch_id'          =>  $oInput['branch_id'],
            'end_service_benefit'=>  $oInput['end_service_benefit'],
            'resignation_notice'=>  $oInput['resignation_notice'],
            'termination_notice'=>  $oInput['termination_notice'],
            'include_eos'       =>  $oInput['include_eos'],
            'created_by'        =>  Auth::user()->id,
            'updated_by'        =>  Auth::user()->id,
            'created_at'        =>  Carbon::now()->toDateTimeString(),
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);

        $oTerminationSpecificPreference= TerminationSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($oTerminationSpecificPreference->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Termination Specific Preference"]), $oTerminationSpecificPreference, false);
        $this->urlRec(40, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oTerminationSpecificPreference= TerminationSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Termination Specific Preference"]), $oTerminationSpecificPreference, false);
        $this->urlRec(40, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'end_service_benefit'=> 'required|max:100',
            'resignation_notice'    => 'nullable|integer',
            'termination_notice'=> 'nullable|integer',
            'include_eos'=> 'nullable|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oTerminationSpecificPreference = TerminationSpecificPreference::findOrFail($id); 

        $oTerminationSpecificPreferences = $oTerminationSpecificPreference->update([
            'company_id'          =>  $oInput['company_id'],
            'branch_id'           =>  $oInput['branch_id'],
            'end_service_benefit' =>  $oInput['end_service_benefit'],
            'resignation_notice'  =>  $oInput['resignation_notice'],
            'termination_notice'  =>  $oInput['termination_notice'],
            'include_eos'         =>  $oInput['include_eos'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oTerminationSpecificPreference = TerminationSpecificPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Termination Specific Preference"]), $oTerminationSpecificPreference, false);
        
        $this->urlRec(40, 3, $oResponse);
        
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
                $oTerminationSpecificPreference = TerminationSpecificPreference::find($id);
                if($oTerminationSpecificPreference){
                    $oTerminationSpecificPreference->delete();
                }
            }
        }else{
            $oTerminationSpecificPreference = TerminationSpecificPreference::findOrFail($aIds);
            $oTerminationSpecificPreference->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Termination Specific Preference"]));
        $this->urlRec(40, 4, $oResponse);
        return $oResponse;
    }
}
