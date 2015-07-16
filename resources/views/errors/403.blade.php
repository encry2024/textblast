@extends('...app')

@section('content')
    <div class="container">
    <br/><br/><br/>
        <div class="col-lg-12">
            <div class="panel panel-default col-lg-12" style="border-top-left-radius: 0px;">
                <h3 style="color: #d9534f;">Oops! You've encountered some error</h3>
                <hr/>
                <label for="" style="color: #d9534f;">Possible reasons:</label>
                <br/><br/>
                <ol style="color: #d9534f;" type="1">
                	<li><label for="" style="color: #d9534f;">You are not Authorized to view this page. Redirect to <a href="{{ route('/home') }}">Mainpage</a></label></li>
                	<li><label for="" style="color: #d9534f;">The site is under development.</label></li>
                </ol>
                <br/>
            </div>
        </div>
    </div>
@endsection