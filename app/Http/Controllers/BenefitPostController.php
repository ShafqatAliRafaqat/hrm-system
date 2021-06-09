<?php

namespace App\Http\Controllers;

use App\Models\BenefitPost;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class BenefitPostController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the BenefitPostes
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = BenefitPost::with(['companyId','designationId','beneficiaryId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"amount_from",$oQb);
        $oQb = QB::whereLike($oInput,"amount_to",$oQb);
        $oQb = QB::where($oInput,"status",$oQb);
        $oQb = QB::whereLike($oInput,"branch_id",$oQb);
        $oQb = QB::whereLike($oInput,"designation_id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"beneficiary_id",$oQb);
        
        $oBenefitPostes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Benefit Post"]), $oBenefitPostes, false);
        $this->urlRec(34, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'amount_from'   => 'required|max:5|min:0',
            'amount_to'     => 'required|max:5|min:0',
            'status'        => 'required|max:2|integer',
            'beneficiary_id'=> 'required|exists:beneficiary_types,id',
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'designation_id'=> 'required|exists:designations,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oBenefitPost = BenefitPost::create([
            'amount_from'   =>  $oInput['amount_from'],
            'amount_to'     =>  $oInput['amount_to'],
            'status'        =>  $oInput['status'],
            'beneficiary_id'=>  $oInput['beneficiary_id'],
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'designation_id'=>  $oInput['designation_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oBenefitPost= BenefitPost::with(['companyId','designationId','beneficiaryId','branchId','createdBy','updatedBy'])->findOrFail($oBenefitPost->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Benefit Post"]), $oBenefitPost, false);
        $this->urlRec(34, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oBenefitPost= BenefitPost::with(['companyId','designationId','beneficiaryId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Benefit Post"]), $oBenefitPost, false);
        $this->urlRec(34, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'amount_from'   => 'required|max:5|min:0',
            'amount_to'     => 'required|max:5|min:0',
            'status'        => 'required|max:2|integer',
            'beneficiary_id'=> 'required|exists:beneficiary_types,id',
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'designation_id'=> 'required|exists:designations,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oBenefitPost = BenefitPost::findOrFail($id); 

        $oBenefitPostes = $oBenefitPost->update([
            'amount_from'   =>  $oInput['amount_from'],
            'amount_to'     =>  $oInput['amount_to'],
            'status'        =>  $oInput['status'],
            'beneficiary_id'=>  $oInput['beneficiary_id'],
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'designation_id'=>  $oInput['designation_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oBenefitPost = BenefitPost::with(['companyId','designationId','beneficiaryId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Benefit Post"]), $oBenefitPost, false);
        
        $this->urlRec(34, 3, $oResponse);
        
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
                $oBenefitPost = BenefitPost::find($id);
                if($oBenefitPost){
                    $oBenefitPost->delete();
                }
            }
        }else{
            $oBenefitPost = BenefitPost::findOrFail($aIds);
            $oBenefitPost->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Benefit Post"]));
        $this->urlRec(34, 4, $oResponse);
        return $oResponse;
    }
}
