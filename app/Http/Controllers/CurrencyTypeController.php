<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\CurrencyType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CurrencyTypeController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CurrencyTypes
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CurrencyType::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"exchange_rate",$oQb);
        
        $oCurrencyTypes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"CurrencyTypes"]), $oCurrencyTypes, false);
        $this->urlRec(5, 0, $oResponse);
        return $oResponse;
    }

    // Store new CurrencyType

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'exchange_rate'=> 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCurrencyType = CurrencyType::create([
            'en_name'          =>  $oInput['en_name'],
            'ar_name'          =>  $oInput['ar_name'],
            'exchange_rate'    =>  $oInput['exchange_rate'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCurrencyType= CurrencyType::findOrFail($oCurrencyType->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"CurrencyType"]), $oCurrencyType, false);

        $this->urlRec(5, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oCurrencyType= CurrencyType::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"CurrencyType"]), $oCurrencyType, false);

        $this->urlRec(5, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'exchange_rate'=> 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oCurrencyType = CurrencyType::findOrFail($id); 

        $oCurrencyTypes = $oCurrencyType->update([
            'en_name'          =>  $oInput['en_name'],
            'ar_name'          =>  $oInput['ar_name'],
            'exchange_rate'    =>  $oInput['exchange_rate'],
            'updated_at'       =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCurrencyType = CurrencyType::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"CurrencyType"]), $oCurrencyType, false);

        $this->urlRec(5, 3, $oResponse);
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
                $oCurrencyType = CurrencyType::find($id);
                if($oCurrencyType){
                    $oCurrencyType->delete();
                }
            }
        }else{
            $oCurrencyType = CurrencyType::findOrFail($aIds);
            $oCurrencyType->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"CurrencyType"]));
        $this->urlRec(5, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCurrencyType = CurrencyType::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"CurrencyType"]), $oCurrencyType, false);
        
        $this->urlRec(5, 5, $oResponse);
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
                
                $oCurrencyType = CurrencyType::onlyTrashed()->find($id);
                if($oCurrencyType){
                    $oCurrencyType->restore();
                }
            }
        }else{
            $oCurrencyType = CurrencyType::onlyTrashed()->findOrFail($aIds);
            $oCurrencyType->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"CurrencyType"]));

        $this->urlRec(5, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCurrencyType = CurrencyType::onlyTrashed()->findOrFail($id);
        
        $oCurrencyType->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"CurrencyType"]));
        $this->urlRec(5, 7, $oResponse);
        return $oResponse;
    }
}
