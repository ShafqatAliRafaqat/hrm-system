<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\GregHijriActual;
use Illuminate\Support\Facades\Validator;

class GregHijriActualController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the GregHijriActuals
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = GregHijriActual::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"internal_date",$oQb);
        $oQb = QB::whereDate($oInput,"hijri_date",$oQb);
        $oQb = QB::whereDate($oInput,"greg_date",$oQb);
        
        $oGregHijriActuals = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"GregHijriActuals"]), $oGregHijriActuals, false);
        $this->urlRec(22, 0, $oResponse);
        return $oResponse;
    }

    // Store new GregHijriActual

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'internal_date'   => 'required|max:150',
            'hijri_date'   => 'required|date',
            'greg_date'   => 'required|date',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oGregHijriActual = GregHijriActual::create([
            'internal_date' =>  $oInput['internal_date'],
            'hijri_date'    =>  $oInput['hijri_date'],
            'greg_date'    =>  $oInput['greg_date'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oGregHijriActual= GregHijriActual::findOrFail($oGregHijriActual->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"GregHijriActual"]), $oGregHijriActual, false);

        $this->urlRec(22, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oGregHijriActual= GregHijriActual::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"GregHijriActual"]), $oGregHijriActual, false);

        $this->urlRec(22, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'internal_date'   => 'required|max:150',
            'hijri_date'   => 'required|date',
            'greg_date'   => 'required|date',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oGregHijriActual = GregHijriActual::findOrFail($id); 

        $oGregHijriActuals = $oGregHijriActual->update([
            'internal_date' =>  $oInput['internal_date'],
            'hijri_date'    =>  $oInput['hijri_date'],
            'greg_date'     =>  $oInput['greg_date'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oGregHijriActual = GregHijriActual::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"GregHijriActual"]), $oGregHijriActual, false);

        $this->urlRec(22, 3, $oResponse);
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
                $oGregHijriActual = GregHijriActual::find($id);
                if($oGregHijriActual){
                    $oGregHijriActual->delete();
                }
            }
        }else{
            $oGregHijriActual = GregHijriActual::findOrFail($aIds);
            $oGregHijriActual->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"GregHijriActual"]));
        $this->urlRec(22, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oGregHijriActual = GregHijriActual::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"GregHijriActual"]), $oGregHijriActual, false);
        
        $this->urlRec(22, 5, $oResponse);
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
                
                $oGregHijriActual = GregHijriActual::onlyTrashed()->find($id);
                if($oGregHijriActual){
                    $oGregHijriActual->restore();
                }
            }
        }else{
            $oGregHijriActual = GregHijriActual::onlyTrashed()->findOrFail($aIds);
            $oGregHijriActual->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"GregHijriActual"]));

        $this->urlRec(22, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oGregHijriActual = GregHijriActual::onlyTrashed()->findOrFail($id);
        
        $oGregHijriActual->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"GregHijriActual"]));
        $this->urlRec(22, 7, $oResponse);
        return $oResponse;
    }
}
