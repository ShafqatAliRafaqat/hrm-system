<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\HijriDate;
use Illuminate\Support\Facades\Validator;

class HijriDateController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the HijriDates
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = HijriDate::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"total_days",$oQb);
        $oQb = QB::whereLike($oInput,"days_in_month",$oQb);
        $oQb = QB::whereLike($oInput,"hijri_year",$oQb);
        
        $oHijriDates = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Hijri Dates"]), $oHijriDates, false);
        $this->urlRec(23, 0, $oResponse);
        return $oResponse;
    }

    // Store new HijriDate

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'total_days'   => 'required|max:150',
            'days_in_month'   => 'required|max:150',
            'hijri_year'   => 'required|max:150',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oHijriDate = HijriDate::create([
            'total_days'    =>  $oInput['total_days'],
            'days_in_month' =>  $oInput['days_in_month'],
            'hijri_year'    =>  $oInput['hijri_year'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oHijriDate= HijriDate::findOrFail($oHijriDate->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"HijriDate"]), $oHijriDate, false);

        $this->urlRec(23, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oHijriDate= HijriDate::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"HijriDate"]), $oHijriDate, false);

        $this->urlRec(23, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'total_days'   => 'required|max:150',
            'days_in_month'   => 'required|max:150',
            'hijri_year'   => 'required|max:150',

        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oHijriDate = HijriDate::findOrFail($id); 

        $oHijriDates = $oHijriDate->update([
            'total_days'    =>  $oInput['total_days'],
            'days_in_month' =>  $oInput['days_in_month'],
            'hijri_year'    =>  $oInput['hijri_year'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oHijriDate = HijriDate::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"HijriDate"]), $oHijriDate, false);

        $this->urlRec(23, 3, $oResponse);
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
                $oHijriDate = HijriDate::find($id);
                if($oHijriDate){
                    $oHijriDate->delete();
                }
            }
        }else{
            $oHijriDate = HijriDate::findOrFail($aIds);
            $oHijriDate->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"HijriDate"]));
        $this->urlRec(23, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oHijriDate = HijriDate::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"HijriDate"]), $oHijriDate, false);
        
        $this->urlRec(23, 5, $oResponse);
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
                
                $oHijriDate = HijriDate::onlyTrashed()->find($id);
                if($oHijriDate){
                    $oHijriDate->restore();
                }
            }
        }else{
            $oHijriDate = HijriDate::onlyTrashed()->findOrFail($aIds);
            $oHijriDate->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"HijriDate"]));

        $this->urlRec(23, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oHijriDate = HijriDate::onlyTrashed()->findOrFail($id);
        
        $oHijriDate->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"HijriDate"]));
        $this->urlRec(23, 7, $oResponse);
        return $oResponse;
    }
}
