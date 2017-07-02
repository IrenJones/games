@extends('layouts.app')
@section('content')
<!-- POPUP -->
<div class="cover">
    <div class="cover-content">
        <hr align="center" width="90%">
        <label class="winner"></label>
        <br>
        <a type="button" class="close-win-window"><span style="color: #f0ad4e;" class="glyphicon glyphicon-fire fire"></span></a>
        <hr align="center" width="90%">
    </div>
    <div class="list-content">
        Yoy! <br>You can change your pawn to something more cool :
        <hr align="center" width="90%" style="margin-bottom: 5px;color: darkgray">
        <div class="alert alert-warning warn-alert" role="alert">
            <button type="button" class="close alert-button"><span aria-hidden="true">&times;</span></button>
            You should choose something!
        </div>
        <div align="left" class="col-xs-5 col-xs-offset-1">
            <div class="checkbox">
                <label>
                    <input class="custom" id="bishop" type="checkbox" value="">
                    bishop
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input class="custom" id="knight" type="checkbox" value="">
                    knight
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input class="custom" id="queen" type="checkbox" value="">
                    queen
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input class="custom" id="rook" type="checkbox" value="">
                     rook
                </label>
            </div>
        </div>
        <div class="col-xs-6" style="position: absolute;top: 40%; left: 40%;">
            <img src="/img/stars.png" width="70%">
        </div>
        <div class="accept-figure"><button class="accept btn btn-default">change</button></div>
    </div>
</div>
<!-- end POPUP-->
<div class="container main">
    <div class="row">
        <div class="col-xs-12 header">
        </div>
    </div>
    <div class="row content">
        <input type="hidden" class="game-info" data-game="{!! $gameId !!}" data-turn="{!! $turnNumber !!}">
        <div class="col-md-7 col-xs-12 board" data-user="{!! $userId !!}" data-player-white="{!! $playerWhiteId !!}" data-player-black="{!! $playerBlackId !!}" data-player-login-white="{!! $userWhite !!}" data-player-login-black="{!! $userBlack !!}">
            <div class="row user1">
                <div class="col-xs-offset-1 user col-md-3 col-xs-4">
                    <img id="user1-img" height="70%" src="/img/white.png"> <i id="user1" data-color="white"></i>
                </div>
                <div align="right" class="hit-white col-md-7 col-xs-6"></div>
            </div>
            <div class="row">
                <div class="col-xs-1">
                </div>
                <div class="col-xs-1 cell-parent cell-corner">
                    <div class="cell-side-left"></div>
                </div>
                <div class="col-xs-1 cell-bottom" id="letter1">A</div>
                <div class="col-xs-1 cell-bottom" id="letter2">B</div>
                <div class="col-xs-1 cell-bottom" id="letter3">C</div>
                <div class="col-xs-1 cell-bottom" id="letter4">D</div>
                <div class="col-xs-1 cell-bottom" id="letter5">E</div>
                <div class="col-xs-1 cell-bottom" id="letter6">F</div>
                <div class="col-xs-1 cell-bottom" id="letter7">G</div>
                <div class="col-xs-1 cell-bottom" id="letter8">H</div>
                <div class="col-xs-1 cell-parent cell-corner">
                    <div class="cell-side-right"></div>
                </div>
            </div>
            
            
            <!-- Start of Board is here! -->
            @for ($i = 1; $i < 9; $i++)
            <div class="row">
                <div class="col-xs-1 col-xs-offset-1 cell cell-parent">
                    <div class="cell-side-left">{{9-$i}}</div>
                </div>
                @for ($j = 1; $j < 9; $j++)
                    @if (($i+$j)%2 === 0)
                    <!-- Draw light or dark color -->
                        <div class="col-xs-1 cell light" data-id="{{$i*10+$j}}" data-revert-id="{{(9-$i)*10+(9 -$j)}}" style="height: 73px;">
                    @else 
                        <div class="col-xs-1 cell dark" data-id="{{$i*10+$j}}" data-revert-id="{{(9-$i)*10+(9-$j)}}" style="height: 73px;"> 
                    @endif
                    <!-- Start of Logic is here! -->
                    @if(!is_null($secondPlayerInGame))
                        @foreach($boards as $board)
                            @if ($i*10+$j == $board['position'])
                                <div id="{{$board['id']}}" class="figure {{$board['color']}}">
                                <img class="img-content" src="/figure/{{$board['type']."-".$board['color']}}.png" data-type="{{$board['type']}}">
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <!-- End of Logic is here! -->
                    </div>
                @endfor
                    <div class="col-xs-1 cell cell-parent">
                        <div class="cell-side-right">{{9-$i}}</div>     
                    </div>
            </div>
            @endfor
            <!-- End of Board is here! -->
            <div class="row">
                <div class="col-xs-1 col-xs-offset-1 cell-parent cell-corner">
                    <div class="cell-side-left"></div>
                </div>
                <div class="col-xs-1 cell-up">A</div>
                <div class="col-xs-1 cell-up">B</div>
                <div class="col-xs-1 cell-up">C</div>
                <div class="col-xs-1 cell-up">D</div>
                <div class="col-xs-1 cell-up">E</div>
                <div class="col-xs-1 cell-up">F</div>
                <div class="col-xs-1 cell-up">G</div>
                <div class="col-xs-1 cell-up">H</div>
                <div class="col-xs-1 cell-parent cell-corner">
                    <div class="cell-side-right"></div>
                </div>
            </div>
            <div class="user2 row">
                <div class="col-md-7 col-xs-6 col-xs-offset-1 hit-black col-md-offset-1"></div>
                <div align="right" class="col-md-3 col-xs-4 user">
                    <i id="user2" data-color="black"></i> <img id="user2-img" height="70%" src="/img/black.png">
                </div>
            </div>
        </div>
        <div style="font-size: 24pt" class="col-md-5 col-xs-12 bar">
            <div class="row">
                <div class="col-xs-12 side-header">

                </div>
                <div class=" col-xs-12 side-bar">
                    <div class="row info-board">
                        <div class="col-xs-12 info-header">
                                Info Board
                        </div>
                        <div class="col-xs-6 status center">
                            <b class="state">BLACK IN GAME</b>
                        </div>
                        <div class="col-xs-6 last">
                            <label class="current-step"></label>
                        </div>
                        <div class="col-xs-12 log center">
                            <i class="history"></i>
                        </div>
                    </div>
                    <br>
                    <button style="font-size: 26pt;margin-bottom: 10px" class="col-xs-offset-9 giveUp btn btn-danger">
                        give up
                    </button>
                </div>
                <br>
            </div>
        </div>
        </div>
    <div class="footer">

    </div>
</div>
@endsection

@section('status')
<div style="visibility: hidden" class="stateGame" value="live"></div>
@endsection

@section('scripts')
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script src="/js/reconnecting-websocket.min.js"></script>
<script data-main="/js/main.js" src="/js/require.min.js"></script>
@endsection
