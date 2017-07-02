@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    
                    You are logged in!
                    
                    @if (session('message'))
                    <div class='alert alert-info'>
                    {{ session('message') }}
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<!--<script src="/js/reconnecting-websocket.min.js"></script>-->
<!--<script data-main="/js/main.js" src="/js/require.min.js"></script>-->
@endsection
