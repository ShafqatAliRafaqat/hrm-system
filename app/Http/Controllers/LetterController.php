<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class LetterController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Letters
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Letter::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"serial_id",$oQb);
        $oQb = QB::where($oInput,"doc_type",$oQb);
        $oQb = QB::where($oInput,"request",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_description",$oQb);
        $oQb = QB::whereLike($oInput,"ar_description",$oQb);
        $oQb = QB::whereLike($oInput,"language",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);

        $oLetters = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Letters"]), $oLetters, false);
        $this->urlRec(42, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'serial_id'   => 'nullable|integer',
            'doc_type'   => 'nullable|integer',
            'request'   => 'required|in:0,1',
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'ar_description' => 'nullable|max:500',
            'en_description' => 'nullable|max:500',
            'language' => 'nullable|max:20',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oLetter = Letter::create([
            'serial_id' =>  $oInput['serial_id'],
            'doc_type'  =>  $oInput['doc_type'],
            'request'   =>  $oInput['request'],
            'en_name'   =>  $oInput['en_name'],
            'ar_name'   =>  $oInput['ar_name'],
            'company_id'=>  $oInput['company_id'],
            'branch_id' =>  $oInput['branch_id'],
            'en_description'=>  $oInput['en_description'],
            'ar_description'=>  $oInput['ar_description'],
            'language'  =>  $oInput['language'],
            'created_by'=>  Auth::user()->id,
            'updated_by'=>  Auth::user()->id,
            'created_at'=>  Carbon::now()->toDateTimeString(),
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);

        $oLetter= Letter::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($oLetter->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Letters"]), $oLetter, false);
        $this->urlRec(42, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oLetter= Letter::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Letters"]), $oLetter, false);
        $this->urlRec(42, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'serial_id'   => 'nullable|integer',
            'doc_type'   => 'nullable|integer',
            'request'   => 'required|in:0,1',
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'ar_description' => 'nullable|max:500',
            'en_description' => 'nullable|max:500',
            'language' => 'nullable|max:20',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oLetter = Letter::findOrFail($id); 

        $oLetters = $oLetter->update([
            'serial_id' =>  $oInput['serial_id'],
            'doc_type'  =>  $oInput['doc_type'],
            'request'   =>  $oInput['request'],
            'en_name'   =>  $oInput['en_name'],
            'ar_name'   =>  $oInput['ar_name'],
            'company_id'=>  $oInput['company_id'],
            'branch_id' =>  $oInput['branch_id'],
            'en_description'=>  $oInput['en_description'],
            'ar_description'=>  $oInput['ar_description'],
            'language'  =>  $oInput['language'],
            'updated_by'=>  Auth::user()->id,
            'updated_at'=>  Carbon::now()->toDateTimeString(),
        ]);
        $oLetter = Letter::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Letters"]), $oLetter, false);
        
        $this->urlRec(42, 3, $oResponse);
        
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
                $oLetter = Letter::find($id);
                $oLetter->update(['deleted_by'=>Auth::user()->id]);
                if($oLetter){
                    $oLetter->delete();
                }
            }
        }else{
            $oLetter = Letter::findOrFail($aIds);
            $oLetter->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Letters"]));
        $this->urlRec(42, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oLetter = Letter::onlyTrashed()->with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Letters"]), $oLetter, false);
        $this->urlRec(42, 5, $oResponse); 
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
                
                $oLetter = Letter::onlyTrashed()->find($id);
                if($oLetter){
                    $oLetter->restore();
                }
            }
        }else{
            $oLetter = Letter::onlyTrashed()->findOrFail($aIds);
            $oLetter->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Letters"]));
        $this->urlRec(42, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oLetter = Letter::onlyTrashed()->findOrFail($id);
        
        $oLetter->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Letters"]));
        $this->urlRec(42, 7, $oResponse);
        return $oResponse;
    }
}
