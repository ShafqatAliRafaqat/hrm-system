<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Educations
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Education::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"educ_remark",$oQb);
        $oQb = QB::where($oInput,"is_sponsored",$oQb);
        
        $oEducations = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Educations"]), $oEducations, false);
        $this->urlRec(8, 0, $oResponse);
        return $oResponse;
    }

    // Store new Education

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'educ_remark'=> 'required|max:50',
            'is_sponsored' => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEducation = Education::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'educ_remark'   =>  $oInput['educ_remark'],
            'is_sponsored'  =>  $oInput['is_sponsored'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEducation= Education::findOrFail($oEducation->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Education"]), $oEducation, false);

        $this->urlRec(8, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oEducation= Education::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Education"]), $oEducation, false);

        $this->urlRec(8, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'educ_remark'=> 'required|max:50',
            'is_sponsored' => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oEducation = Education::findOrFail($id); 

        $oEducations = $oEducation->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'educ_remark'   =>  $oInput['educ_remark'],
            'is_sponsored'  =>  $oInput['is_sponsored'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEducation = Education::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Education"]), $oEducation, false);

        $this->urlRec(8, 3, $oResponse);
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
                $oEducation = Education::find($id);
                if($oEducation){
                    $oEducation->delete();
                }
            }
        }else{
            $oEducation = Education::findOrFail($aIds);
            $oEducation->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Education"]));
        $this->urlRec(8, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEducation = Education::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Education"]), $oEducation, false);
        
        $this->urlRec(8, 5, $oResponse);
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
                
                $oEducation = Education::onlyTrashed()->find($id);
                if($oEducation){
                    $oEducation->restore();
                }
            }
        }else{
            $oEducation = Education::onlyTrashed()->findOrFail($aIds);
            $oEducation->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Education"]));

        $this->urlRec(8, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEducation = Education::onlyTrashed()->findOrFail($id);
        
        $oEducation->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Education"]));
        $this->urlRec(8, 7, $oResponse);
        return $oResponse;
    }
}
