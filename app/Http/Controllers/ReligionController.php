<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Religion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReligionController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Religions
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Religion::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);        
        $oReligions = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Religions"]), $oReligions, false);
        $this->urlRec(4, 0, $oResponse);
        return $oResponse;
    }

    // Store new Religion

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oReligion = Religion::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oReligion= Religion::findOrFail($oReligion->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Religion"]), $oReligion, false);

        $this->urlRec(4, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oReligion= Religion::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Religion"]), $oReligion, false);

        $this->urlRec(4, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oReligion = Religion::findOrFail($id); 

        $oReligions = $oReligion->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oReligion = Religion::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Religion"]), $oReligion, false);

        $this->urlRec(4, 3, $oResponse);
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
                $oReligion = Religion::find($id);
                if($oReligion){
                    $oReligion->delete();
                }
            }
        }else{
            $oReligion = Religion::findOrFail($aIds);
            $oReligion->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Religion"]));
        $this->urlRec(4, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oReligion = Religion::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Religion"]), $oReligion, false);
        
        $this->urlRec(4, 5, $oResponse);
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
                
                $oReligion = Religion::onlyTrashed()->find($id);
                if($oReligion){
                    $oReligion->restore();
                }
            }
        }else{
            $oReligion = Religion::onlyTrashed()->findOrFail($aIds);
            $oReligion->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Religion"]));

        $this->urlRec(4, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oReligion = Religion::onlyTrashed()->findOrFail($id);
        
        $oReligion->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Religion"]));
        $this->urlRec(4, 7, $oResponse);
        return $oResponse;
    }
}
