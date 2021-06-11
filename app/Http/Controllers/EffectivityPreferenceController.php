<?php

namespace App\Http\Controllers;

use App\Models\EffectivityPreference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EffectivityPreferenceController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EffectivityPreferences
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EffectivityPreference::with(['companyId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::whereDate($oInput,"start_date",$oQb);
        $oQb = QB::where($oInput,"accumulated",$oQb);
        $oQb = QB::where($oInput,"fix_asset",$oQb);
        $oQb = QB::where($oInput,"update_ticket_benefit",$oQb);
        
        $oEffectivityPreferences = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Effectivity Preference"]), $oEffectivityPreferences, false);
        $this->urlRec(37, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'   => 'required|exists:companies,id',
            'branch_id'   => 'required|exists:company_branches,id',
            'start_date'   => 'required|date',
            'accumulated'   => 'nullable|in:0,1',
            'fix_asset'   => 'nullable|in:0,1',
            'update_ticket_benefit'   => 'nullable|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEffectivityPreference = EffectivityPreference::create([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'start_date'    =>  $oInput['start_date'],
            'accumulated'   =>  $oInput['accumulated'],
            'fix_asset'     =>  $oInput['fix_asset'],
            'update_ticket_benefit' =>  $oInput['update_ticket_benefit'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEffectivityPreference= EffectivityPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($oEffectivityPreference->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Effectivity Preference"]), $oEffectivityPreference, false);
        $this->urlRec(37, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEffectivityPreference= EffectivityPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Effectivity Preference"]), $oEffectivityPreference, false);
        $this->urlRec(37, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'company_id'   => 'required|exists:companies,id',
            'branch_id'   => 'required|exists:company_branches,id',
            'start_date'   => 'required|date',
            'accumulated'   => 'nullable|in:0,1',
            'fix_asset'   => 'nullable|in:0,1',
            'update_ticket_benefit'   => 'nullable|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEffectivityPreference = EffectivityPreference::findOrFail($id); 

        $oEffectivityPreferences = $oEffectivityPreference->update([
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'start_date'    =>  $oInput['start_date'],
            'accumulated'   =>  $oInput['accumulated'],
            'fix_asset'     =>  $oInput['fix_asset'],
            'update_ticket_benefit' =>  $oInput['update_ticket_benefit'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEffectivityPreference = EffectivityPreference::with(['companyId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Effectivity Preference"]), $oEffectivityPreference, false);
        
        $this->urlRec(37, 3, $oResponse);
        
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
                $oEffectivityPreference = EffectivityPreference::find($id);
                if($oEffectivityPreference){
                    $oEffectivityPreference->delete();
                }
            }
        }else{
            $oEffectivityPreference = EffectivityPreference::findOrFail($aIds);
            $oEffectivityPreference->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Effectivity Preference"]));
        $this->urlRec(37, 4, $oResponse);
        return $oResponse;
    }
}