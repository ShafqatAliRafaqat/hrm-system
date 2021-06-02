<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Sections
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Section::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        
        $oSections = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Sections"]), $oSections, false);
        $this->urlRec(17, 0, $oResponse);
        return $oResponse;
    }

    // Store new Section

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

        $oSection = Section::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oSection= Section::findOrFail($oSection->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Section"]), $oSection, false);

        $this->urlRec(17, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oSection= Section::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Section"]), $oSection, false);

        $this->urlRec(17, 2, $oResponse); 
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
        $oSection = Section::findOrFail($id); 

        $oSections = $oSection->update([
            'en_name'   =>  $oInput['en_name'],
            'ar_name'   =>  $oInput['ar_name'],
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);
        $oSection = Section::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Section"]), $oSection, false);

        $this->urlRec(17, 3, $oResponse);
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
                $oSection = Section::find($id);
                if($oSection){
                    $oSection->delete();
                }
            }
        }else{
            $oSection = Section::findOrFail($aIds);
            $oSection->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Section"]));
        $this->urlRec(17, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oSection = Section::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Section"]), $oSection, false);
        
        $this->urlRec(17, 5, $oResponse);
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
                
                $oSection = Section::onlyTrashed()->find($id);
                if($oSection){
                    $oSection->restore();
                }
            }
        }else{
            $oSection = Section::onlyTrashed()->findOrFail($aIds);
            $oSection->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Section"]));

        $this->urlRec(17, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oSection = Section::onlyTrashed()->findOrFail($id);
        
        $oSection->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Section"]));
        $this->urlRec(17, 7, $oResponse);
        return $oResponse;
    }
}
