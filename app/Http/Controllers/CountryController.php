<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Cities
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Country::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_nationality",$oQb);
        $oQb = QB::whereLike($oInput,"ar_nationality",$oQb);
        $oQb = QB::whereLike($oInput,"code",$oQb);
        $oQb = QB::whereLike($oInput,"numcode",$oQb);
        $oQb = QB::whereLike($oInput,"phonecode",$oQb);
        
        $oCountries = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.country.list'), $oCountries, false);
        $this->urlRec(1, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'en_nationality'   => 'required|max:50',
            'ar_nationality'   => 'required|max:50',
            'code'   => 'required|max:3|unique:countries',
            'phonecode'=> 'required|max:3',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        } 
        $oCountry = Country::create([
            'en_name'           =>  $oInput['en_name'],
            'ar_name'           =>  $oInput['ar_name'],
            'en_nationality'    =>  $oInput['en_nationality'],
            'ar_nationality'    =>  $oInput['ar_nationality'],
            'code'              =>  $oInput['code'],
            'phonecode'         =>  $oInput['phonecode'],
            'created_at'        =>  Carbon::now()->toDateTimeString(),
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCountry= Country::with(['city'])->findOrFail($oCountry->id);

        $oResponse = responseBuilder()->success(__('message.country.create'), $oCountry, false);
        $this->urlRec(1, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCountry= Country::with(['city'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.country.detail'), $oCountry, false);
        $this->urlRec(1, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'en_nationality'   => 'required|max:50',
            'ar_nationality'   => 'required|max:50',
            'code'   => 'required|max:3|unique:countries,code,'.$id,
            'phonecode'=> 'required|max:3',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCountry = Country::findOrFail($id); 

        $oCountrys = $oCountry->update([
            'en_name'           =>  $oInput['en_name'],
            'ar_name'           =>  $oInput['ar_name'],
            'en_nationality'    =>  $oInput['en_nationality'],
            'ar_nationality'    =>  $oInput['ar_nationality'],
            'code'              =>  $oInput['code'],
            'phonecode'         =>  $oInput['phonecode'],
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCountry = Country::with(['city'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.country.update'), $oCountry, false);
        
        $this->urlRec(1, 3, $oResponse);
        
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
                $oCountry = Country::find($id);
                if($oCountry){
                    $oCountry->delete();
                }
            }
        }else{
            $oCountry = Country::findOrFail($aIds);
            $oCountry->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.country.delete'));
        $this->urlRec(1, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCountry = Country::onlyTrashed()->with(['city'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.country.deletedList'), $oCountry, false);
        $this->urlRec(1, 5, $oResponse); 
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
                
                $oCountry = Country::onlyTrashed()->with(['city'])->find($id);
                if($oCountry){
                    $oCountry->restore();
                }
            }
        }else{
            $oCountry = Country::onlyTrashed()->with(['city'])->findOrFail($aIds);
            $oCountry->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.country.restore'));
        $this->urlRec(1, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCountry = Country::onlyTrashed()->with(['city'])->findOrFail($id);
        
        $oCountry->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.country.permanentDelete'));
        $this->urlRec(1, 7, $oResponse);
        return $oResponse;
    }
    // All County List
    public function allCountries()
    {
        $oCountry = Country::all();
        
        $oResponse = responseBuilder()->success(__('List of All Countries'), $oCountry, false);
        $this->urlRec(1, 8, $oResponse); 
        return $oResponse;
    }
}
