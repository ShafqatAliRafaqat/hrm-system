<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEvaluation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeEvaluationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeEvaluations
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeEvaluation::with(['companyId','branchId','employeeId','evaluatorId','evaluationTypeId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"date_from",$oQb);
        $oQb = QB::whereDate($oInput,"date_to",$oQb);
        $oQb = QB::whereDate($oInput,"date_from_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_to_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"evaluation_date",$oQb);
        $oQb = QB::whereDate($oInput,"evaluation_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"contract_no",$oQb);
        $oQb = QB::whereLike($oInput,"remarks",$oQb);
        $oQb = QB::whereLike($oInput,"achievements",$oQb);
        $oQb = QB::whereLike($oInput,"recommendations",$oQb);
        $oQb = QB::whereLike($oInput,"employee_notes",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"evaluator_id",$oQb);
        $oQb = QB::where($oInput,"evaluation_type_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeEvaluations = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Evaluation"]), $oEmployeeEvaluations, false);
        $this->urlRec(49, 0, $oResponse);
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
            'evaluation_date'   => 'nullable|date',
            'evaluation_date_hijri'=> 'nullable|date',
            'contract_no' => 'nullable|integer',
            'remarks' => 'nullable|max:200',
            'achievements' => 'nullable|max:200',
            'recommendations' => 'nullable|max:200',
            'employee_notes' => 'nullable|max:200',
            'evaluator_id' => 'required|exists:employees,id',
            'evaluation_type_id' => 'required|exists:evaluation_types,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeEvaluation = EmployeeEvaluation::create([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'evaluation_date'  =>  $oInput['evaluation_date'],
            'evaluation_date_hijri' =>  $oInput['evaluation_date_hijri'],
            'contract_no'   =>  $oInput['contract_no'],
            'remarks'       =>  $oInput['remarks'],
            'achievements'  =>  $oInput['achievements'],
            'recommendations' =>  $oInput['recommendations'],
            'employee_notes'=>  $oInput['employee_notes'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'evaluator_id'=>  $oInput['evaluator_id'],
            'evaluation_type_id'=>  $oInput['evaluation_type_id'],
            'company_id'    =>  $oInput['company_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeEvaluation= EmployeeEvaluation::with(['companyId','branchId','employeeId','evaluatorId','evaluationTypeId','createdBy','updatedBy'])->findOrFail($oEmployeeEvaluation->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Evaluation"]), $oEmployeeEvaluation, false);
        $this->urlRec(49, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeEvaluation= EmployeeEvaluation::with(['companyId','branchId','employeeId','evaluatorId','evaluationTypeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Evaluation"]), $oEmployeeEvaluation, false);
        $this->urlRec(49, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'date_from'   => 'nullable|date',
            'date_to'   => 'nullable|date',
            'date_from_hijri'   => 'nullable|date',
            'date_to_hijri'   => 'nullable|date',
            'evaluation_date'   => 'nullable|date',
            'evaluation_date_hijri'=> 'nullable|date',
            'contract_no' => 'nullable|integer',
            'remarks' => 'nullable|max:200',
            'achievements' => 'nullable|max:200',
            'recommendations' => 'nullable|max:200',
            'employee_notes' => 'nullable|max:200',
            'evaluator_id' => 'required|exists:employees,id',
            'evaluation_type_id' => 'required|exists:evaluation_types,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeEvaluation = EmployeeEvaluation::findOrFail($id); 

        $oEmployeeEvaluations = $oEmployeeEvaluation->update([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'evaluation_date'  =>  $oInput['evaluation_date'],
            'evaluation_date_hijri' =>  $oInput['evaluation_date_hijri'],
            'contract_no'   =>  $oInput['contract_no'],
            'remarks'       =>  $oInput['remarks'],
            'achievements'  =>  $oInput['achievements'],
            'recommendations' =>  $oInput['recommendations'],
            'employee_notes'=>  $oInput['employee_notes'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'evaluator_id'=>  $oInput['evaluator_id'],
            'evaluation_type_id'=>  $oInput['evaluation_type_id'],
            'company_id'    =>  $oInput['company_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeEvaluation = EmployeeEvaluation::with(['companyId','branchId','employeeId','evaluatorId','evaluationTypeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Evaluation"]), $oEmployeeEvaluation, false);
        
        $this->urlRec(49, 3, $oResponse);
        
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
                $oEmployeeEvaluation = EmployeeEvaluation::find($id);
                if($oEmployeeEvaluation){
                    $oEmployeeEvaluation->delete();
                }
            }
        }else{
            $oEmployeeEvaluation = EmployeeEvaluation::findOrFail($aIds);
            $oEmployeeEvaluation->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Evaluation"]));
        $this->urlRec(49, 4, $oResponse);
        return $oResponse;
    }
}