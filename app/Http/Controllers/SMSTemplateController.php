<?php

namespace App\Http\Controllers;

use App\Models\SMSTemplate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class SMSTemplateController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the SMSTemplates
   
    public function index(Request $auto)
    {
        $oInput = $auto->all();

        $oQb = SMSTemplate::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"status",$oQb);
        $oQb = QB::where($oInput,"type",$oQb);
        $oQb = QB::where($oInput,"auto",$oQb);
        $oQb = QB::where($oInput,"both",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_description",$oQb);
        $oQb = QB::whereLike($oInput,"ar_description",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);

        $oSMSTemplates = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"SMSTemplates"]), $oSMSTemplates, false);
        $this->urlRec(44, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $auto)
    {
        $oInput = $auto->all();

        $oValidator = Validator::make($oInput,[
            'status'   => 'nullable|integer',
            'type'   => 'nullable|integer',
            'auto'   => 'required|in:0,1',
            'both'   => 'required|in:0,1',
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'ar_description' => 'nullable|max:500',
            'en_description' => 'nullable|max:500',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oSMSTemplate = SMSTemplate::create([
            'status' =>  $oInput['status'],
            'type'  =>  $oInput['type'],
            'auto'   =>  $oInput['auto'],
            'en_name'   =>  $oInput['en_name'],
            'ar_name'   =>  $oInput['ar_name'],
            'company_id'=>  $oInput['company_id'],
            'branch_id' =>  $oInput['branch_id'],
            'en_description'=>  $oInput['en_description'],
            'ar_description'=>  $oInput['ar_description'],
            'both'  =>  $oInput['both'],
            'created_by'=>  Auth::user()->id,
            'updated_by'=>  Auth::user()->id,
            'created_at'=>  Carbon::now()->toDateTimeString(),
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);

        $oSMSTemplate= SMSTemplate::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($oSMSTemplate->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"SMSTemplates"]), $oSMSTemplate, false);
        $this->urlRec(44, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oSMSTemplate= SMSTemplate::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"SMSTemplates"]), $oSMSTemplate, false);
        $this->urlRec(44, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $auto, $id)
    {
        $oInput = $auto->all();

        $oValidator = Validator::make($oInput,[
            'status'   => 'nullable|integer',
            'type'   => 'nullable|integer',
            'auto'   => 'required|in:0,1',
            'both'   => 'required|in:0,1',
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'ar_description' => 'nullable|max:500',
            'en_description' => 'nullable|max:500',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oSMSTemplate = SMSTemplate::findOrFail($id); 

        $oSMSTemplates = $oSMSTemplate->update([
            'status' =>  $oInput['status'],
            'type'  =>  $oInput['type'],
            'auto'   =>  $oInput['auto'],
            'en_name'   =>  $oInput['en_name'],
            'ar_name'   =>  $oInput['ar_name'],
            'company_id'=>  $oInput['company_id'],
            'branch_id' =>  $oInput['branch_id'],
            'en_description'=>  $oInput['en_description'],
            'ar_description'=>  $oInput['ar_description'],
            'both'  =>  $oInput['both'],
            'updated_by'=>  Auth::user()->id,
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);
        $oSMSTemplate = SMSTemplate::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"SMSTemplates"]), $oSMSTemplate, false);
        
        $this->urlRec(44, 3, $oResponse);
        
        return $oResponse;
    }

    // Soft Delete country 

    public function destroy(Request $auto)
    {
        $oInput = $auto->all();
        $oValidator = Validator::make($oInput,[
            'ids'        => 'required',
        ]);
        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $aIds = $auto->ids;
        if(is_array($aIds)){
            foreach($aIds as $id){
                $oSMSTemplate = SMSTemplate::find($id);
                $oSMSTemplate->update(['deleted_by'=>Auth::user()->id]);
                if($oSMSTemplate){
                    $oSMSTemplate->delete();
                }
            }
        }else{
            $oSMSTemplate = SMSTemplate::findOrFail($aIds);
            $oSMSTemplate->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"SMSTemplates"]));
        $this->urlRec(44, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oSMSTemplate = SMSTemplate::onlyTrashed()->with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"SMSTemplates"]), $oSMSTemplate, false);
        $this->urlRec(44, 5, $oResponse); 
        return $oResponse;
    }
    // Restore any deleted data
    public function restore(Request $auto)
    {
        $oInput = $auto->all();
        $oValidator = Validator::make($oInput,[
            'ids'        => 'required',
        ]);
        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $aIds = $auto->ids;
        if(is_array($aIds)){
            foreach($aIds as $id){
                
                $oSMSTemplate = SMSTemplate::onlyTrashed()->find($id);
                if($oSMSTemplate){
                    $oSMSTemplate->restore();
                }
            }
        }else{
            $oSMSTemplate = SMSTemplate::onlyTrashed()->findOrFail($aIds);
            $oSMSTemplate->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"SMSTemplates"]));
        $this->urlRec(44, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oSMSTemplate = SMSTemplate::onlyTrashed()->findOrFail($id);
        
        $oSMSTemplate->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"SMSTemplates"]));
        $this->urlRec(44, 7, $oResponse);
        return $oResponse;
    }
}
