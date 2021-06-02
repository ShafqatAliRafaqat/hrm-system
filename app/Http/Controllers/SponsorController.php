<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Validator;

class SponsorController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Sponsors
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Sponsor::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"sponsor",$oQb);
        $oQb = QB::whereLike($oInput,"en_contact_person",$oQb);
        $oQb = QB::where($oInput,"ar_contact_person",$oQb);
        $oQb = QB::where($oInput,"address",$oQb);
        $oQb = QB::where($oInput,"telephone",$oQb);
        $oQb = QB::where($oInput,"is_active",$oQb);
        
        $oSponsors = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Sponsors"]), $oSponsors, false);
        $this->urlRec(13, 0, $oResponse);
        return $oResponse;
    }

    // Store new Sponsor

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'sponsor'   => 'required|max:50',
            'en_contact_person'=> 'required|max:50',
            'ar_contact_person'=> 'required|max:50',
            'address'  => 'required|max:250',
            'telephone'  => 'required|max:250',
            'is_active'=> 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oSponsor = Sponsor::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'sponsor'       =>  $oInput['sponsor'],
            'en_contact_person' =>  $oInput['en_contact_person'],
            'ar_contact_person' =>  $oInput['ar_contact_person'],
            'telephone'     =>  $oInput['telephone'],
            'address'     =>  $oInput['address'],
            'is_active'     =>  $oInput['is_active'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oSponsor= Sponsor::findOrFail($oSponsor->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Sponsor"]), $oSponsor, false);

        $this->urlRec(13, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oSponsor= Sponsor::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Sponsor"]), $oSponsor, false);

        $this->urlRec(13, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'sponsor'   => 'required|max:50',
            'en_contact_person'=> 'required|max:50',
            'ar_contact_person'=> 'required|max:50',
            'address'  => 'required|max:250',
            'telephone'  => 'required|max:250',
            'is_active'=> 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oSponsor = Sponsor::findOrFail($id); 

        $oSponsors = $oSponsor->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'sponsor'       =>  $oInput['sponsor'],
            'en_contact_person' =>  $oInput['en_contact_person'],
            'ar_contact_person' =>  $oInput['ar_contact_person'],
            'telephone'     =>  $oInput['telephone'],
            'address'       =>  $oInput['address'],
            'is_active'     =>  $oInput['is_active'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oSponsor = Sponsor::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Sponsor"]), $oSponsor, false);

        $this->urlRec(13, 3, $oResponse);
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
                $oSponsor = Sponsor::find($id);
                if($oSponsor){
                    $oSponsor->delete();
                }
            }
        }else{
            $oSponsor = Sponsor::findOrFail($aIds);
            $oSponsor->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Sponsor"]));
        $this->urlRec(13, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oSponsor = Sponsor::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Sponsor"]), $oSponsor, false);
        
        $this->urlRec(13, 5, $oResponse);
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
                
                $oSponsor = Sponsor::onlyTrashed()->find($id);
                if($oSponsor){
                    $oSponsor->restore();
                }
            }
        }else{
            $oSponsor = Sponsor::onlyTrashed()->findOrFail($aIds);
            $oSponsor->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Sponsor"]));

        $this->urlRec(13, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oSponsor = Sponsor::onlyTrashed()->findOrFail($id);
        
        $oSponsor->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Sponsor"]));
        $this->urlRec(13, 7, $oResponse);
        return $oResponse;
    }
}
