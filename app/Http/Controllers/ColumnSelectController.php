<?php

namespace App\Http\Controllers;

use App\Models\ColumnSelect;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class ColumnSelectController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the ColumnSelects
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = ColumnSelect::with(['createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"group_by",$oQb);
        $oQb = QB::whereLike($oInput,"order_by",$oQb);
        $oQb = QB::whereLike($oInput,"language_order_by",$oQb);
        $oQb = QB::whereLike($oInput,"both_language",$oQb);
        $oQb = QB::whereLike($oInput,"en_description",$oQb);
        $oQb = QB::whereLike($oInput,"ar_description",$oQb);
        $oQb = QB::whereLike($oInput,"type",$oQb);
        
        $oColumnSelects = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Column Select"]), $oColumnSelects, false);
        $this->urlRec(41, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'group_by'   => 'required|integer',
            'order_by'   => 'required|integer',
            'language_order_by'   => 'nullable|integer',
            'both_language'   => 'nullable|max:200',
            'en_description'=> 'nullable|max:500',
            'ar_description'=> 'nullable|max:500',
            'type'=> 'nullable|max:20',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oColumnSelect = ColumnSelect::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'group_by'  =>  $oInput['group_by'],
            'order_by'    =>  $oInput['order_by'],
            'language_order_by'     =>  $oInput['language_order_by'],
            'both_language'     =>  $oInput['both_language'],
            'en_description'     =>  $oInput['en_description'],
            'ar_description'     =>  $oInput['ar_description'],
            'type'  =>  $oInput['type'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oColumnSelect= ColumnSelect::with(['createdBy','updatedBy','deletedBy'])->findOrFail($oColumnSelect->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Column Select"]), $oColumnSelect, false);
        $this->urlRec(41, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oColumnSelect= ColumnSelect::with(['createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Column Select"]), $oColumnSelect, false);
        $this->urlRec(41, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'group_by'   => 'required|integer',
            'order_by'   => 'required|integer',
            'language_order_by'   => 'nullable|integer',
            'both_language'   => 'nullable|max:200',
            'en_description'=> 'nullable|max:500',
            'ar_description'=> 'nullable|max:500',
            'type'=> 'nullable|max:20',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oColumnSelect = ColumnSelect::findOrFail($id); 

        $oColumnSelects = $oColumnSelect->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'group_by'  =>  $oInput['group_by'],
            'order_by'    =>  $oInput['order_by'],
            'language_order_by'     =>  $oInput['language_order_by'],
            'both_language'     =>  $oInput['both_language'],
            'en_description'     =>  $oInput['en_description'],
            'ar_description'     =>  $oInput['ar_description'],
            'type'  =>  $oInput['type'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oColumnSelect = ColumnSelect::with(['createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Column Select"]), $oColumnSelect, false);
        
        $this->urlRec(41, 3, $oResponse);
        
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
                $oColumnSelect = ColumnSelect::find($id);
                $oColumnSelect->update(['deleted_by'=>Auth::user()->id]);
                if($oColumnSelect){
                    $oColumnSelect->delete();
                }
            }
        }else{
            $oColumnSelect = ColumnSelect::findOrFail($aIds);
            $oColumnSelect->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Column Select"]));
        $this->urlRec(41, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oColumnSelect = ColumnSelect::onlyTrashed()->with(['createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Column Select"]), $oColumnSelect, false);
        $this->urlRec(41, 5, $oResponse); 
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
                
                $oColumnSelect = ColumnSelect::onlyTrashed()->find($id);
                if($oColumnSelect){
                    $oColumnSelect->restore();
                }
            }
        }else{
            $oColumnSelect = ColumnSelect::onlyTrashed()->findOrFail($aIds);
            $oColumnSelect->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Column Select"]));
        $this->urlRec(41, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oColumnSelect = ColumnSelect::onlyTrashed()->findOrFail($id);
        
        $oColumnSelect->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Column Select"]));
        $this->urlRec(41, 7, $oResponse);
        return $oResponse;
    }
}
