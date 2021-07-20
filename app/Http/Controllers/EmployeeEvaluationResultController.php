<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEvaluationResult;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeEvaluationResultController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeEvaluationResults
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeEvaluationResult::with(['companyId','branchId','employeeId','employeeEvaluationId','evaluationTypeId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"date_from",$oQb);
        $oQb = QB::whereDate($oInput,"date_to",$oQb);
        $oQb = QB::whereDate($oInput,"date_from_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_to_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"rate_value",$oQb);
        $oQb = QB::whereLike($oInput,"max_mark",$oQb);
        $oQb = QB::whereLike($oInput,"grade",$oQb);
        $oQb = QB::whereLike($oInput,"percentage",$oQb);
        $oQb = QB::whereLike($oInput,"score",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"employee_evaluation_id",$oQb);
        $oQb = QB::where($oInput,"evaluation_type_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeEvaluationResults = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Evaluation Result"]), $oEmployeeEvaluationResults, false);
        $this->urlRec(50, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'date_from'   => 'nullable|date',
            'date_to'   => 'nullable|date',
            'date_from_hijri'   => 'nullable|date',
            'date_to_hijri'   => 'nullable|date',
            'rate_value' => 'nullable|max:20',
            'max_mark' => 'nullable|max:20',
            'grade' => 'nullable|max:20',
            'percentage' => 'nullable|max:20',
            'score' => 'nullable|max:20',
            'employee_evaluation_id' => 'required|exists:employee_evaluations,id',
            'evaluation_type_id' => 'required|exists:evaluation_types,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeEvaluationResult = EmployeeEvaluationResult::create([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'rate_value'   =>  $oInput['rate_value'],
            'max_mark'       =>  $oInput['max_mark'],
            'grade'  =>  $oInput['grade'],
            'percentage' =>  $oInput['percentage'],
            'score'=>  $oInput['score'],
            'score'=>  $oInput['score'],
            'branch_id'     =>  $oInput['branch_id'],
            'evaluation_ids' =>  isset($oInput['evaluation_ids'])? json_encode($oInput['evaluation_ids']):'',
            'employee_evaluation_id'=>  $oInput['employee_evaluation_id'],
            'evaluation_type_id'=>  $oInput['evaluation_type_id'],
            'company_id'    =>  $oInput['company_id'],
            'employee_id'    =>  $oInput['employee_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeEvaluationResult= EmployeeEvaluationResult::with(['companyId','branchId','employeeId','employeeEvaluationId','evaluationTypeId','createdBy','updatedBy'])->findOrFail($oEmployeeEvaluationResult->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Evaluation"]), $oEmployeeEvaluationResult, false);
        $this->urlRec(50, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeEvaluationResult= EmployeeEvaluationResult::with(['companyId','branchId','employeeId','employeeEvaluationId','evaluationTypeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Evaluation"]), $oEmployeeEvaluationResult, false);
        $this->urlRec(50, 2, $oResponse);
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
                $oEmployeeEvaluationResult = EmployeeEvaluationResult::find($id);
                if($oEmployeeEvaluationResult){
                    $oEmployeeEvaluationResult->delete();
                }
            }
        }else{
            $oEmployeeEvaluationResult = EmployeeEvaluationResult::findOrFail($aIds);
            $oEmployeeEvaluationResult->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Evaluation"]));
        $this->urlRec(50, 3, $oResponse);
        return $oResponse;
    }
}
