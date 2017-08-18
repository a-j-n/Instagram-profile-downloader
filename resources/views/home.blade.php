@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Find user</div>

                    <div class="panel-body">
                        <div class="form-group">
                            <input class="form-control username "  name="username"
                                   placeholder="instagram user ex:_a_jamal">
                        </div>
                        <button class="btn send btn-success pull-right">Display profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
