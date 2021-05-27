<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Cities
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = City::with(['countryId']);
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"region",$oQb);
        $oQb = QB::where($oInput,"ticket_value",$oQb);
        $oQb = QB::where($oInput,"country_id",$oQb);
        
        $oCities = $oQb->get();
        
        $oResponse = responseBuilder()->success(__('message.city.list'), $oCities, false);
        $this->urlRec(2, 0, $oResponse);
        return $oResponse;
    }

    // Store new city

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'region'    => 'required',
            'ticket_value'=> 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCity = City::create([
            'en_name'  =>  $oInput['en_name'],
            'ar_name'  =>  $oInput['ar_name'],
            'region'  =>  $oInput['region'],
            'ticket_value'  =>  $oInput['ticket_value'],
            'country_id'  =>  $oInput['country_id'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCity= City::with(['countryId'])->findOrFail($oCity->id);

        $oResponse = responseBuilder()->success(__('message.city.create'), $oCity, false);
        $this->urlRec(2, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oCity= City::with(['countryId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.city.detail'), $oCity, false);
        $this->urlRec(2, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'region'    => 'required',
            'ticket_value'=> 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oCity = City::findOrFail($id); 

        $oCitys = $oCity->update([
            'en_name'  =>  $oInput['en_name'],
            'ar_name'  =>  $oInput['ar_name'],
            'region'  =>  $oInput['region'],
            'ticket_value'  =>  $oInput['ticket_value'],
            'country_id'  =>  $oInput['country_id'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCity = City::with(['countryId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.city.update'), $oCity, false);
        $this->urlRec(2, 3, $oResponse);
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
                $oCity = City::find($id);
                if($oCity){
                    $oCity->delete();
                }
            }
        }else{
            $oCity = City::findOrFail($aIds);
            $oCity->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.city.delete'));
        $this->urlRec(2, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deletedCity()
    {
        $oCity = City::onlyTrashed()->with(['countryId'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.city.deletedList'), $oCity, false);
        $this->urlRec(2, 5, $oResponse);
        return $oResponse;
    }
    // Restore any deleted data
    public function restoreCity(Request $request)
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
                
                $oCity = City::onlyTrashed()->with(['countryId'])->find($id);
                if($oCity){
                    $oCity->restore();
                }
            }
        }else{
            $oCity = City::onlyTrashed()->with(['countryId'])->findOrFail($aIds);
            $oCity->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.city.restore'));
        $this->urlRec(2, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function deleteCity($id)
    {
        $oCity = City::onlyTrashed()->with(['countryId'])->findOrFail($id);
        
        $oCity->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.city.permanentDelete'));
        $this->urlRec(2, 7, $oResponse);
        return $oResponse;
    }
}
