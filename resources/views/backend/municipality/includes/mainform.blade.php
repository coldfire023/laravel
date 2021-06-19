<div class="form-group">
    {!! Form::label('province_id', 'Province',) !!}
    {!! Form::select('province_id', $data['provinces'],null,['class'=>'form-control','placeholder'=>'please select province']);
 !!}
    @error('province_id')
    <span class="text text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('district_id', 'District',) !!}
    {!! Form::select('district_id', $data['districts'],null,['class'=>'form-control','placeholder'=>'please select district']);
 !!}
    @error('district_id')
    <span class="text text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('name','Name') !!}
    {!! Form::text('name',null,['class'=>'form-control']) !!}
    @error('name')
    <span class="text text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
    {!! Form::radio('status',1)!!}Active
    {!! Form::radio('status',0,true)!!}De Active
</div>
