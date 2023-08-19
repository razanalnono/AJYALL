<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Imports\StudentsImport;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\MockObject\Api;

class GroupController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          if ($request->headers->get('Authorization')) {
          $groups = GroupResource::collection(Group::get());
            return $this->apiResponse($groups, 200);
        }else{
        $groups = Group::paginate(15);


        $has_more_page = $groups->hasMorePages();
        $data['has_more_page'] = $has_more_page;

        $current_page = $groups->currentPage();
        $data['current_page'] = $current_page;

        $paginator = $groups->currentPage();

        if ($groups->hasMorePages()) {

            $data['next'] = $paginator + 1;
        }
        if ($current_page > 1) {
            $data['previous'] = $paginator - 1;
        }
        
        $groupss = GroupResource::collection($groups);
        $data['groups'] = $groupss;

        return $this->apiResponse($data, 'Done', 200);
    }
    }

    public function store(GroupRequest $request)
    {

        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $group = new Group();
        $group->title = $request->input("title");
        $group->description = $request->input("description");
        $group->budget = $request->input("budget");
        $group->hour_count = $request->input("hour_count");
        $group->participants_count = $request->input("participants_count");
        $group->status = $request->input("status");
        $group->start_date = $request->input("start_date");
        $group->end_date = $request->input("end_date");
        $group->category_id = $request->input("category_id");
        $group->project_id = $request->input("project_id");
        if(isset($data["image_path"])){
            $group->image = $data["image_path"];
        }
        $group->save();
        if($group){
            return $this->apiResponse(new GroupResource($group),"The group saved!",201);
        }
            return $this->apiResponse(null,"The group not saved!",404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $this->apiResponse($group, 'Done', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, Group $group)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }


        if(isset($data["image_path"])){
            $group->image = $data["image_path"];
        }
        $group->update($request->all());
        if($group){
            return $this->apiResponse(new GroupResource($group),"The group updated!",201);
        }
            return $this->apiResponse(null,"The group not updated!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return $this->apiResponse($group,"The group deleted sucessfuly!",200);
    }

    public function import(Request $request)
    {
        Excel::import(new StudentsImport($request), $request->file('students'));

        return response()->json([
            'message' => 'ok'
        ]);
    }
}
