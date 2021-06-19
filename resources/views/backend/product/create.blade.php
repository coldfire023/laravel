@extends('backend.layouts.master')

@section('title',$title)
@section('main-content')

    {!! Form::open(['route' => $base_route.'store','method'=>'post','files'=>true])
!!}


        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#basic" data-toggle="tab">Basic Form</a></li>
                <li class="nav-item"><a class="nav-link" href="#meta" data-toggle="tab">Meta</a></li>
                <li class="nav-item"><a class="nav-link" href="#images" data-toggle="tab">Images</a></li>
                <li class="nav-item"><a class="nav-link" href="#attributes" data-toggle="tab">Attributes</a></li>

            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="basic">

                    @include($folder.'includes.basic')

                </div>
                <!-- Basic Form -->
                <div class="tab-pane" id="meta">

                    @include($folder.'includes.meta')

                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="images">

                    @include($folder.'includes.images')
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="attributes">
                    @include($folder.'includes.attributes')
                </div>

            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->


    <!-- /.card-body -->
    <div class="card-footer">
        {!! Form::submit('Save ' . $panel,['class'=>'btn btn-info'])  !!}
    </div>
    {!! Form::close() !!}

@endsection
@section('js')
    @include('backend.product.includes.add_row_script')
@endsection
