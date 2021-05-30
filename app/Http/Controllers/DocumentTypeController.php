<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\DocumentType as Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocumentTypeController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Documents
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Document::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereDate($oInput,"exp_date",$oQb);
        $oQb = QB::where($oInput,"hijriflag",$oQb);
        $oQb = QB::where($oInput,"renew_flag",$oQb);
        $oQb = QB::where($oInput,"co_flag",$oQb);
        $oQb = QB::where($oInput,"substitution",$oQb);
        
        $oDocuments = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Documents"]), $oDocuments, false);
        $this->urlRec(9, 0, $oResponse);
        return $oResponse;
    }

    // Store new Document

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'date'      => 'required|date',
            'hijriflag'=> 'required|in:0,1',
            'co_flag'  => 'required|in:0,1',
            'substitution'=> 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oDocument = Document::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'date'          =>  $oInput['date'],
            'hijriflag'     =>  $oInput['hijriflag'],
            'co_flag'       =>  $oInput['co_flag'],
            'substitution'  =>  $oInput['substitution'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oDocument= Document::findOrFail($oDocument->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Document"]), $oDocument, false);

        $this->urlRec(9, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oDocument= Document::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Document"]), $oDocument, false);

        $this->urlRec(9, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'date'      => 'required|date',
            'hijriflag' => 'required|in:0,1',
            'co_flag'   => 'required|in:0,1',
            'substitution'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oDocument = Document::findOrFail($id); 

        $oDocuments = $oDocument->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'date'          =>  $oInput['date'],
            'hijriflag'     =>  $oInput['hijriflag'],
            'co_flag'       =>  $oInput['co_flag'],
            'substitution'  =>  $oInput['substitution'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oDocument = Document::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Document"]), $oDocument, false);

        $this->urlRec(9, 3, $oResponse);
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
                $oDocument = Document::find($id);
                if($oDocument){
                    $oDocument->delete();
                }
            }
        }else{
            $oDocument = Document::findOrFail($aIds);
            $oDocument->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Document"]));
        $this->urlRec(9, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oDocument = Document::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Document"]), $oDocument, false);
        
        $this->urlRec(9, 5, $oResponse);
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
                
                $oDocument = Document::onlyTrashed()->find($id);
                if($oDocument){
                    $oDocument->restore();
                }
            }
        }else{
            $oDocument = Document::onlyTrashed()->findOrFail($aIds);
            $oDocument->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Document"]));

        $this->urlRec(9, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oDocument = Document::onlyTrashed()->findOrFail($id);
        
        $oDocument->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Document"]));
        $this->urlRec(9, 7, $oResponse);
        return $oResponse;
    }
}
