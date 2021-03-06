<div class="form-group">
    {!! Form::label('meta_title', 'Meta Title', ['class' => 'control-label']) !!}
    {!! Form::text('meta_title',null,['class'=>'form-control']) !!}
    @error('meta_title')
    {{$message}}
    @enderror
</div>
<div class="form-group">
    {!! Form::label('meta_keyword', 'Meta Keyword', ['class' => 'control-label']) !!}
    {!! Form::text('meta_keyword',null,['class'=>'form-control']) !!}
    @error('meta_keyword')
    {{$message}}
    @enderror
</div>
<div class="form-group">
    {!! Form::label('meta_description', 'Meta Description', ['class' => 'control-label']) !!}
    {!! Form::textarea('meta_description',null,['class'=>'form-control','rows'=>3]) !!}
    @error('meta_description')
    {{$message}}
    @enderror
</div>
