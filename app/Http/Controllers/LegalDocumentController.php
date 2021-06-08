<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class LegalDocumentController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the LegalDocuments
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = LegalDocument::with(['companyId','departmentId','placeIssued','branchId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"doc_no",$oQb);
        $oQb = QB::where($oInput,"renew_flag",$oQb);
        $oQb = QB::whereDate($oInput,"date_issued",$oQb);
        $oQb = QB::whereDate($oInput,"expiration_date",$oQb);
        $oQb = QB::whereLike($oInput,"noof_ren",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"department_id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"place_issued",$oQb);
        
        $oLegalDocuments = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Legal Documents"]), $oLegalDocuments, false);
        $this->urlRec(30, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'doc_no'   => 'required|max:50',
            'renew_flag'   => 'required|max:2',
            'date_issued'   => 'required|date',
            'expiration_date'   => 'required|date',
            'noof_ren'   => 'nullable|max:200',
            'place_issued' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'department_id' => 'required|exists:company_departments,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oLegalDocument = LegalDocument::create([
            'doc_no'       =>  $oInput['doc_no'],
            'renew_flag'   =>  $oInput['renew_flag'],
            'date_issued'  =>  $oInput['date_issued'],
            'expiration_date'=>  $oInput['expiration_date'],
            'noof_ren'      =>  $oInput['noof_ren'],
            'place_issued'  =>  $oInput['place_issued'],
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'department_id' =>  $oInput['department_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oLegalDocument= LegalDocument::with(['companyId','departmentId','placeIssued','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($oLegalDocument->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Legal Documents"]), $oLegalDocument, false);
        $this->urlRec(30, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oLegalDocument= LegalDocument::with(['companyId','departmentId','placeIssued','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Legal Documents"]), $oLegalDocument, false);
        $this->urlRec(30, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'doc_no'   => 'required|max:50',
            'renew_flag'   => 'required|max:2',
            'date_issued'   => 'required|date',
            'expiration_date'   => 'required|date',
            'noof_ren'   => 'nullable|max:200',
            'place_issued' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'department_id' => 'required|exists:company_departments,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oLegalDocument = LegalDocument::findOrFail($id); 

        $oLegalDocuments = $oLegalDocument->update([
            'doc_no'       =>  $oInput['doc_no'],
            'renew_flag'   =>  $oInput['renew_flag'],
            'date_issued'  =>  $oInput['date_issued'],
            'expiration_date'=>  $oInput['expiration_date'],
            'noof_ren'      =>  $oInput['noof_ren'],
            'place_issued'  =>  $oInput['place_issued'],
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'department_id' =>  $oInput['department_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oLegalDocument = LegalDocument::with(['companyId','departmentId','placeIssued','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Legal Documents"]), $oLegalDocument, false);
        
        $this->urlRec(30, 3, $oResponse);
        
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
                $oLegalDocument = LegalDocument::find($id);
                $oLegalDocument->update(['deleted_by'=>Auth::user()->id]);
                if($oLegalDocument){
                    $oLegalDocument->delete();
                }
            }
        }else{
            $oLegalDocument = LegalDocument::findOrFail($aIds);
            $oLegalDocument->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Legal Documents"]));
        $this->urlRec(30, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oLegalDocument = LegalDocument::onlyTrashed()->with(['companyId','departmentId','placeIssued','branchId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Legal Documents"]), $oLegalDocument, false);
        $this->urlRec(30, 5, $oResponse); 
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
                
                $oLegalDocument = LegalDocument::onlyTrashed()->find($id);
                if($oLegalDocument){
                    $oLegalDocument->restore();
                }
            }
        }else{
            $oLegalDocument = LegalDocument::onlyTrashed()->findOrFail($aIds);
            $oLegalDocument->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Legal Documents"]));
        $this->urlRec(30, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oLegalDocument = LegalDocument::onlyTrashed()->findOrFail($id);
        
        $oLegalDocument->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Legal Documents"]));
        $this->urlRec(30, 7, $oResponse);
        return $oResponse;
    }
}
