<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Modification;
use Illuminate\Support\Facades\Validator;

class ModificationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Modifications
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Modification::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"flag",$oQb);
        
        $oModifications = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Modifications"]), $oModifications, false);
        $this->urlRec(16, 0, $oResponse);
        return $oResponse;
    }

    // Store new Modification

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'flag'      => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oModification = Modification::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'flag'          =>  $oInput['flag'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oModification= Modification::findOrFail($oModification->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Modification"]), $oModification, false);

        $this->urlRec(16, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oModification= Modification::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Modification"]), $oModification, false);

        $this->urlRec(16, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'flag'      => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oModification = Modification::findOrFail($id); 

        $oModifications = $oModification->update([
            'en_name'   =>  $oInput['en_name'],
            'ar_name'   =>  $oInput['ar_name'],
            'flag'      =>  $oInput['flag'],
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);
        $oModification = Modification::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Modification"]), $oModification, false);

        $this->urlRec(16, 3, $oResponse);
        return $oResponse;
    }

    // Soft Delete city 

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
                $oModification = Modification::find($id);
                if($oModification){
                    $oModification->delete();
                }
            }
        }else{
            $oModification = Modification::findOrFail($aIds);
            $oModification->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Modification"]));
        $this->urlRec(16, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oModification = Modification::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Modification"]), $oModification, false);
        
        $this->urlRec(16, 5, $oResponse);
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
                
                $oModification = Modification::onlyTrashed()->find($id);
                if($oModification){
                    $oModification->restore();
                }
            }
        }else{
            $oModification = Modification::onlyTrashed()->findOrFail($aIds);
            $oModification->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Modification"]));

        $this->urlRec(16, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oModification = Modification::onlyTrashed()->findOrFail($id);
        
        $oModification->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Modification"]));
        $this->urlRec(16, 7, $oResponse);
        return $oResponse;
    }
}
