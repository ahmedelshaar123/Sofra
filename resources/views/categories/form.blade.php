<div class="form-group">
    <label for="title">Title</label>
    {!! Form::text('title', null, [
        'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>
{!! Form::close() !!}