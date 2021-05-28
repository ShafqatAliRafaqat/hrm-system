<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Roles
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Role::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"name",$oQb);
        
        $oRoles = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Roles"]), $oRoles, false);
        $this->urlRec(3, 0, $oResponse);
        return $oResponse;
    }

    // Store new Role

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'name'   => 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oRole = Role::create([
            'name'          =>  $oInput['name'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oRole= Role::with(['createdBy','updatedBy','deletedBy'])->findOrFail($oRole->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Role"]), $oRole, false);

        $this->urlRec(3, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oRole= Role::with(['createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Role"]), $oRole, false);

        $this->urlRec(3, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'name'   => 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oRole = Role::findOrFail($id); 

        $oRoles = $oRole->update([
            'name'          =>  $oInput['name'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oRole = Role::with(['createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Role"]), $oRole, false);

        $this->urlRec(3, 3, $oResponse);
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
                $oRole = Role::find($id);
                if($oRole){
                    $oRole->update(['deleted_by'=>Auth::user()->id]);
                    $oRole->delete();
                }
            }
        }else{
            $oRole = Role::findOrFail($aIds);
            $oRole->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Role"]));
        $this->urlRec(3, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oRole = Role::onlyTrashed()->with(['createdBy','updatedBy','deletedBy'])->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Role"]), $oRole, false);
        
        $this->urlRec(3, 5, $oResponse);
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
                
                $oRole = Role::onlyTrashed()->find($id);
                if($oRole){
                    $oRole->restore();
                }
            }
        }else{
            $oRole = Role::onlyTrashed()->findOrFail($aIds);
            $oRole->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Role"]));

        $this->urlRec(3, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oRole = Role::onlyTrashed()->findOrFail($id);
        
        $oRole->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Role"]));
        $this->urlRec(3, 7, $oResponse);
        return $oResponse;
    }
}
