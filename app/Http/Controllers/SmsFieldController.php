<?php

namespace App\Http\Controllers;

use App\Models\SmsField;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class SmsFieldController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the SmsFields
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = SmsField::with(['smsId','columnId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"order_by",$oQb);
        $oQb = QB::where($oInput,"both_language",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"sms_id",$oQb);
        $oQb = QB::where($oInput,"column_id",$oQb);

        $oSmsFields = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"SMS Fields"]), $oSmsFields, false);
        $this->urlRec(45, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'order_by'   => 'nullable|integer',
            'both_language'   => 'nullable|in:0,1',
            'en_name' => 'nullable|max:50',
            'ar_name' => 'nullable|max:50',
            'sms_id' => 'required|exists:sms_templates,id',
            'column_id' => 'required|exists:column_selects,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oSmsField = SmsField::create([
            'order_by' =>  $oInput['order_by'],
            'both_language'  =>  $oInput['both_language'],
            'sms_id'=>  $oInput['sms_id'],
            'column_id' =>  $oInput['column_id'],
            'en_name'=>  $oInput['en_name'],
            'en_name'  =>  $oInput['en_name'],
            'created_by'=>  Auth::user()->id,
            'updated_by'=>  Auth::user()->id,
            'created_at'=>  Carbon::now()->toDateTimeString(),
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);

        $oSmsField= SmsField::with(['smsId','columnId','createdBy','updatedBy','deletedBy'])->findOrFail($oSmsField->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"SMS Fields"]), $oSmsField, false);
        $this->urlRec(45, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oSmsField= SmsField::with(['smsId','columnId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"SMS Fields"]), $oSmsField, false);
        $this->urlRec(45, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'order_by'   => 'nullable|integer',
            'both_language'   => 'nullable|in:0,1',
            'en_name' => 'nullable|max:50',
            'en_name' => 'nullable|max:50',
            'sms_id' => 'required|exists:sms_templates,id',
            'column_id' => 'required|exists:column_selects,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oSmsField = SmsField::findOrFail($id); 

        $oSmsFields = $oSmsField->update([
            'order_by' =>  $oInput['order_by'],
            'both_language'  =>  $oInput['both_language'],
            'sms_id'=>  $oInput['sms_id'],
            'column_id' =>  $oInput['column_id'],
            'en_name'=>  $oInput['en_name'],
            'en_name'  =>  $oInput['en_name'],
            'updated_by'=>  Auth::user()->id,
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);
        $oSmsField = SmsField::with(['smsId','columnId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"SMS Fields"]), $oSmsField, false);
        
        $this->urlRec(45, 3, $oResponse);
        
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
                $oSmsField = SmsField::find($id);
                $oSmsField->update(['deleted_by'=>Auth::user()->id]);
                if($oSmsField){
                    $oSmsField->delete();
                }
            }
        }else{
            $oSmsField = SmsField::findOrFail($aIds);
            $oSmsField->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"SMS Fields"]));
        $this->urlRec(45, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oSmsField = SmsField::onlyTrashed()->with(['smsId','columnId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"SMS Fields"]), $oSmsField, false);
        $this->urlRec(45, 5, $oResponse); 
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
                
                $oSmsField = SmsField::onlyTrashed()->find($id);
                if($oSmsField){
                    $oSmsField->restore();
                }
            }
        }else{
            $oSmsField = SmsField::onlyTrashed()->findOrFail($aIds);
            $oSmsField->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"SMS Fields"]));
        $this->urlRec(45, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oSmsField = SmsField::onlyTrashed()->findOrFail($id);
        
        $oSmsField->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"SMS Fields"]));
        $this->urlRec(45, 7, $oResponse);
        return $oResponse;
    }
}
