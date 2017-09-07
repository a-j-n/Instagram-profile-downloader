@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Find user</div>

                    <div class="panel-body">
                        <form action="{{route('user-page')}}" method="get">
                            <div class="form-group">
                                <label>Profile link or username</label>
                                <input class="form-control username " name="username"
                                       placeholder="instagram username or profile url ex:_a_jamal ">
                            </div>
                            <button class="btn send btn-success pull-right">Display profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
