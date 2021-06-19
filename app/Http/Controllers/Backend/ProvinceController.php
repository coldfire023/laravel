<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UnitRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProvinceController extends BackendBaseController
{

    protected $panel = 'Province'; //for section/model
    protected $folder = 'backend.province.'; //for view file
    protected $base_route = 'backend.province.';  // for route method
    protected $title;
    protected $model;

    function __construct()
    {
        $this->model = new Province();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Province';
        $data['rows'] = $this->model->all();
        return view($this->__loadDataToView($this->folder . 'index'), compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $this->title = 'Create';
        return view($this->__loadDataToView($this->folder . 'create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UnitRequest $request)
    {
        $request->request->add(['created_by' => auth()->user()->id]);
        $data['row'] = $this->model->create($request->all());
        if ($data['row']) {
            $request->session()->flash('success_message', $this->panel . ' created successfully');
        } else {
            $request->session()->flash('error_message', $this->panel . 'creation failed');

        }
        return redirect()->route($this->base_route . 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['row'] = $this->model->find($id);
        if (!$data['row']) {
            request()->session()->flash('error_message', $this->panel . 'record not found');
        }
        $this->title = 'Edit';
        return view($this->__loadDataToView($this->folder . 'Edit'), compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UnitRequest $request, $id)
    {
        $data['row'] = $this->model->find($id);
        $request->request->add(['updated_by' => auth()->user()->id]);
        if ($data['row']->update($request->all())) {
            $request->session()->flash('success_message', $this->panel . ' updated');
        } else {
            $request->session()->flash('error_message', $this->panel . 'creation failed');

        }
        return redirect()->route($this->base_route . 'index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $data['row'] = $this->model->find($id);
        if ($data['row']->delete()) {
            request()->session()->flash('success_message', $this->panel . ' deleteded');
        } else {
            request()->session()->flash('error_message', $this->panel . 'deletionw failed');

        }
        return redirect()->route($this->base_route . 'index');
    }

    public function trash()
    {
        $this->title = 'Trash List';
        $data['rows'] = $this->model->onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view($this->__loadDataToView($this->folder . 'trash'), compact('data'));
    }

    public function restore($id)
    {
        $data['row'] = $this->model->where('id', $id)->withTrashed()->first();
        if ($data['row']->restore()) {
            request()->session()->flash('success_message', $this->panel . ' restored');
        } else {
            request()->session()->flash('error_message', $this->panel . ' restoration failed');
        }
        return redirect()->route($this->base_route . 'index');
    }

    public function forceDelete($id)
    {
        $data['row'] = $this->model->where('id', $id)->withTrashed()->first();

        if ($data['row']->forceDelete()) {
            request()->session()->flash('success_message', $this->panel . ' permanently deleted');
        } else {
            request()->session()->flash('success_message', $this->panel . ' deletion failed');
        }
        return redirect()->route($this->base_route . 'trash');
    }

    public function getDistrictByProvinceId(Request $request)
    {
        $province = Province::find($request->input('province_id'));
        $html = "<option value=''>Select District</option>";
        foreach ($province->districts as $district) {
            $html .= "<option value='$district->id'>$district->name</option>";
        }
        return $html;

    }

}
