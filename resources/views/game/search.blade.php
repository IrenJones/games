@extends('layouts.app')

@section('content')
<div class='container'>
    <div style='width: 100%;text-align: center'>
        Choose what you want !
    </div>
    <div class='row'>
        @if ($errors->any)
        <ul class='alert-warning'>
            @foreach ($errors->all() as $error)
            <li> Something went wrong, invalid parameter. Try again.</li>
            @endforeach
        </ul>
        @endif
        {!! Form::open(['route' => 'create']) !!}
        <div>
            {!! Form::label('Status:') !!}
            {!! Form::select('status', ['0' => 'public', '1' => 'private'], null, ['class' => 'form-control']) !!}
        </div>
    
        <div>
            {!! Form::label('Type:') !!}
            {!! Form::select('type', $gameTypes, null, ['class' => 'form-control']) !!}
        </div>
        
        <br>
            {!! Form::submit('Start', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}    
        
    </div>
</div>
@endsection
