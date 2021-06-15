<?php

namespace App\Http\Controllers;

use App\Models\LetterField;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class LetterFieldFieldController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the LetterFields
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = LetterField::with(['letterId','columnId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"order_by",$oQb);
        $oQb = QB::where($oInput,"both_language",$oQb);
        $oQb = QB::whereLike($oInput,"format",$oQb);
        $oQb = QB::whereLike($oInput,"language",$oQb);
        $oQb = QB::where($oInput,"letter_id",$oQb);
        $oQb = QB::where($oInput,"column_id",$oQb);

        $oLetterFields = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Letter Fields"]), $oLetterFields, false);
        $this->urlRec(43, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'order_by'   => 'nullable|integer',
            'both_language'   => 'nullable|in:0,1',
            'format' => 'nullable|max:500',
            'language' => 'nullable|max:20',
            'letter_id' => 'required|exists:letters,id',
            'column_id' => 'required|exists:column_selects,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oLetterField = LetterField::create([
            'order_by' =>  $oInput['order_by'],
            'both_language'  =>  $oInput['both_language'],
            'letter_id'=>  $oInput['letter_id'],
            'column_id' =>  $oInput['column_id'],
            'format'=>  $oInput['format'],
            'language'  =>  $oInput['language'],
            'created_by'=>  Auth::user()->id,
            'updated_by'=>  Auth::user()->id,
            'created_at'=>  Carbon::now()->toDateTimeString(),
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);

        $oLetterField= LetterField::with(['letterId','columnId','createdBy','updatedBy','deletedBy'])->findOrFail($oLetterField->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Letter Fields"]), $oLetterField, false);
        $this->urlRec(43, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oLetterField= LetterField::with(['letterId','columnId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Letter Fields"]), $oLetterField, false);
        $this->urlRec(43, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'order_by'   => 'nullable|integer',
            'both_language'   => 'nullable|in:0,1',
            'format' => 'nullable|max:500',
            'language' => 'nullable|max:20',
            'letter_id' => 'required|exists:letters,id',
            'column_id' => 'required|exists:column_selects,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oLetterField = LetterField::findOrFail($id); 

        $oLetterFields = $oLetterField->update([
            'order_by' =>  $oInput['order_by'],
            'both_language'  =>  $oInput['both_language'],
            'letter_id'=>  $oInput['letter_id'],
            'column_id' =>  $oInput['column_id'],
            'format'=>  $oInput['format'],
            'language'  =>  $oInput['language'],
            'updated_by'=>  Auth::user()->id,
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);
        $oLetterField = LetterField::with(['letterId','columnId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Letter Fields"]), $oLetterField, false);
        
        $this->urlRec(43, 3, $oResponse);
        
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
                $oLetterField = LetterField::find($id);
                $oLetterField->update(['deleted_by'=>Auth::user()->id]);
                if($oLetterField){
                    $oLetterField->delete();
                }
            }
        }else{
            $oLetterField = LetterField::findOrFail($aIds);
            $oLetterField->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Letter Fields"]));
        $this->urlRec(43, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oLetterField = LetterField::onlyTrashed()->with(['letterId','columnId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Letter Fields"]), $oLetterField, false);
        $this->urlRec(43, 5, $oResponse); 
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
                
                $oLetterField = LetterField::onlyTrashed()->find($id);
                if($oLetterField){
                    $oLetterField->restore();
                }
            }
        }else{
            $oLetterField = LetterField::onlyTrashed()->findOrFail($aIds);
            $oLetterField->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Letter Fields"]));
        $this->urlRec(43, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oLetterField = LetterField::onlyTrashed()->findOrFail($id);
        
        $oLetterField->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Letter Fields"]));
        $this->urlRec(43, 7, $oResponse);
        return $oResponse;
    }
}
