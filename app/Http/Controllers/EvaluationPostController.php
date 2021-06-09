<?php

namespace App\Http\Controllers;

use App\Models\EvaluationPost;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationPostController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EvaluationPostes
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EvaluationPost::with(['companyId','designationId','evaluationId','branchId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"max_mark",$oQb);
        $oQb = QB::where($oInput,"status",$oQb);
        $oQb = QB::whereLike($oInput,"branch_id",$oQb);
        $oQb = QB::whereLike($oInput,"designation_id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"evaluation_id",$oQb);
        
        $oEvaluationPostes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Evaluation Post"]), $oEvaluationPostes, false);
        $this->urlRec(33, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'max_mark'   => 'required|max:200',
            'status'        => 'required|max:2|integer',
            'evaluation_id'=> 'required|exists:evaluation_types,id',
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'designation_id'=> 'required|exists:designations,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEvaluationPost = EvaluationPost::create([
            'max_mark'   =>  $oInput['max_mark'],
            'status'        =>  $oInput['status'],
            'evaluation_id'=>  $oInput['evaluation_id'],
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'designation_id'=>  $oInput['designation_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEvaluationPost= EvaluationPost::with(['companyId','designationId','evaluationId','branchId','createdBy','updatedBy'])->findOrFail($oEvaluationPost->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Evaluation Post"]), $oEvaluationPost, false);
        $this->urlRec(33, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEvaluationPost= EvaluationPost::with(['companyId','designationId','evaluationId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Evaluation Post"]), $oEvaluationPost, false);
        $this->urlRec(33, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'max_mark'   => 'required|max:200',
            'status'        => 'required|max:2|integer',
            'evaluation_id'=> 'required|exists:evaluation_types,id',
            'company_id'    => 'required|exists:companies,id',
            'branch_id'     => 'required|exists:company_branches,id',
            'designation_id'=> 'required|exists:designations,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEvaluationPost = EvaluationPost::findOrFail($id); 

        $oEvaluationPostes = $oEvaluationPost->update([
            'max_mark'      =>  $oInput['max_mark'],
            'status'        =>  $oInput['status'],
            'evaluation_id' =>  $oInput['evaluation_id'],
            'company_id'    =>  $oInput['company_id'],
            'branch_id'     =>  $oInput['branch_id'],
            'designation_id'=>  $oInput['designation_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEvaluationPost = EvaluationPost::with(['companyId','designationId','evaluationId','branchId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Evaluation Post"]), $oEvaluationPost, false);
        
        $this->urlRec(33, 3, $oResponse);
        
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
                $oEvaluationPost = EvaluationPost::find($id);
                if($oEvaluationPost){
                    $oEvaluationPost->delete();
                }
            }
        }else{
            $oEvaluationPost = EvaluationPost::findOrFail($aIds);
            $oEvaluationPost->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Evaluation Post"]));
        $this->urlRec(33, 4, $oResponse);
        return $oResponse;
    }
}
