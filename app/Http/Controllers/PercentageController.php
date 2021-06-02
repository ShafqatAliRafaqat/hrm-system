<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Percentage;
use Illuminate\Support\Facades\Validator;

class PercentageController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Percentages
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Percentage::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"value",$oQb);
        $oQb = QB::where($oInput,"to",$oQb);
        $oQb = QB::where($oInput,"from",$oQb);
        
        $oPercentages = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Percentages"]), $oPercentages, false);
        $this->urlRec(19, 0, $oResponse);
        return $oResponse;
    }

    // Store new Percentage

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'value'         => 'required|in:0,1',
            'to'            => 'required|in:0,1',
            'from'          => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oPercentage = Percentage::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'value'         =>  $oInput['value'],
            'to'            =>  $oInput['to'],
            'from'          =>  $oInput['from'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oPercentage= Percentage::findOrFail($oPercentage->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Percentage"]), $oPercentage, false);

        $this->urlRec(19, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oPercentage= Percentage::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Percentage"]), $oPercentage, false);

        $this->urlRec(19, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'value'         => 'required|in:0,1',
            'to'            => 'required|in:0,1',
            'from'          => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oPercentage = Percentage::findOrFail($id); 

        $oPercentages = $oPercentage->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'value'         =>  $oInput['value'],
            'to'            =>  $oInput['to'],
            'from'          =>  $oInput['from'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oPercentage = Percentage::find($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Percentage"]), $oPercentage, false);

        $this->urlRec(19, 3, $oResponse);
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
                $oPercentage = Percentage::find($id);
                if($oPercentage){
                    $oPercentage->delete();
                }
            }
        }else{
            $oPercentage = Percentage::findOrFail($aIds);
            $oPercentage->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Percentage"]));
        $this->urlRec(19, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oPercentage = Percentage::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Percentage"]), $oPercentage, false);
        
        $this->urlRec(19, 5, $oResponse);
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
                
                $oPercentage = Percentage::onlyTrashed()->find($id);
                if($oPercentage){
                    $oPercentage->restore();
                }
            }
        }else{
            $oPercentage = Percentage::onlyTrashed()->findOrFail($aIds);
            $oPercentage->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Percentage"]));

        $this->urlRec(19, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oPercentage = Percentage::onlyTrashed()->findOrFail($id);
        
        $oPercentage->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Percentage"]));
        $this->urlRec(19, 7, $oResponse);
        return $oResponse;
    }
}
