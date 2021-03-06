<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Http\Requests\Backend\ProductRequest;
use App\Http\Requests\Backend\UnitRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Attribute;
use Illuminate\Database\Eloquent\Model;


class ProductController extends BackendBaseController
{

    protected $panel = 'Product'; //for section/model
    protected $folder = 'backend.product.'; //for view file
    protected $base_route = 'backend.product.';  // for route method
    protected $folder_name = 'product';
    protected $title;
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new Product();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'List';
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
        $data['units'] = Unit::pluck('name','id');
        $data['categories'] = Category::pluck('name','id');
        $data['subcategories'] = SubCategory::pluck('name','id');
        $data['attributes'] = \App\Models\Attribute::pluck('name','id');

        return view($this->__loadDataToView($this->folder . 'create'),compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {

        $request->request->add(['stock' => $request->input('quantity')]);
        $request->request->add(['created_by' => auth()->user()->id]);
        $data['row'] = $this->model->create($request->all());
        if ($data['row']) {

            // for multiple image upload

            $imageFiles = $request->file('product_image');
            $image_title = $request->input('image_title');
            $imageArray['product_id'] = $data['row']->id;
            for ($i = 0; $i < count($imageFiles); $i++){
                $image =$imageFiles[$i];
                $image_name = rand(6785, 9814) . '_' . $image->getClientOriginalName();
                $image->move($this->image_path, $image_name);
                if (count(config('image_dimension.' . $this->folder_name . '.images')) > 0) {
                    foreach (config('image_dimension.' . $this->folder_name . '.images') as $dimension) {
                        // open and resize an image file
                        $img = Image::make($this->image_path . $image_name)->resize($dimension['width'], $dimension['height']);
                        // save the same file as jpg with default quality
                        $img->save($this->image_path . $dimension['width'] . '' . $dimension['height'] . '' . $image_name);
                    }
                }
                $imageArray['image_name'] = $image_name;
                $imageArray['image_title'] = $image_title[$i];
                $imageArray['status']  = 1;
                ProductImage::create($imageArray);
            }
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
    public function update(ProductRequest $request, $id)
    {
        $data['row'] = $this->model->find($id);

        if($request->hasFile('image_file'))
        {
            $image=$this->uploadImage($request,'image_file');
            $request->request->add(['image'=>$image]);
            if ($image){
                $this->deleteImage($data['row']->image);
            }
        }

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
            $this->title='Trash List';
            $data['rows']=$this->model->onlyTrashed()->orderBy('deleted_at','desc')->get();

                return view($this->__loadDataToView($this->folder.'trash'),compact('data'));
        }
     public function restore($id)
     {
         $data['row'] = $this->model->where('id',$id)->withTrashed()->first();
         if($data['row']->restore()){
             request()->session()->flash('success_message', $this->panel . ' restored');
         }
         else{
             request()->session()->flash('error_message', $this->panel . ' restoration failed');
         }
         return redirect()->route($this->base_route.'index');
     }
     public function forceDelete($id)
     {
         $data['row']=$this->model->where('id',$id)->withTrashed()->first();

         if($data['row']->forceDelete()){
             request()->session()->flash('success_message', $this->panel . ' permanently deleted');
         }
         else{
             request()->session()->flash('success_message', $this->panel . ' deletion failed');
         }
         return redirect()->route($this->base_route.'trash');
     }

}
