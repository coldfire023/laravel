<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends BackendBaseController
{

    protected $panel = 'Dashboard'; //for section/model
    protected $folder = 'backend.dashboard.'; //for view file
    protected $base_route = 'backend.dashboard.';  // for route method
    protected $folder_name = 'dashboard';
    protected $title;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'List';
        return view($this->__loadDataToView($this->folder . 'index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
}
