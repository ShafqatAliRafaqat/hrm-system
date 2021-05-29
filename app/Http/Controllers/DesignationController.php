<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Designations
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Designation::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"level",$oQb);
        $oQb = QB::where($oInput,"is_active",$oQb);
        
        $oDesignations = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Designations"]), $oDesignations, false);
        $this->urlRec(6, 0, $oResponse);
        return $oResponse;
    }

    // Store new Designation

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'level'     => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oDesignation = Designation::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'level'         =>  $oInput['level'],
            'is_active'     =>  $oInput['is_active'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oDesignation= Designation::findOrFail($oDesignation->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Designation"]), $oDesignation, false);

        $this->urlRec(6, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oDesignation= Designation::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Designation"]), $oDesignation, false);

        $this->urlRec(6, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'level'     => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oDesignation = Designation::findOrFail($id); 

        $oDesignations = $oDesignation->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'level'         =>  $oInput['level'],
            'is_active'     =>  $oInput['is_active'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oDesignation = Designation::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Designation"]), $oDesignation, false);

        $this->urlRec(6, 3, $oResponse);
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
                $oDesignation = Designation::find($id);
                if($oDesignation){
                    $oDesignation->delete();
                }
            }
        }else{
            $oDesignation = Designation::findOrFail($aIds);
            $oDesignation->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Designation"]));
        $this->urlRec(6, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oDesignation = Designation::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Designation"]), $oDesignation, false);
        
        $this->urlRec(6, 5, $oResponse);
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
                
                $oDesignation = Designation::onlyTrashed()->find($id);
                if($oDesignation){
                    $oDesignation->restore();
                }
            }
        }else{
            $oDesignation = Designation::onlyTrashed()->findOrFail($aIds);
            $oDesignation->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Designation"]));

        $this->urlRec(6, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oDesignation = Designation::onlyTrashed()->findOrFail($id);
        
        $oDesignation->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Designation"]));
        $this->urlRec(6, 7, $oResponse);
        return $oResponse;
    }
}