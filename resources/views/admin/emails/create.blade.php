@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Email</h1>
@stop

@section('content')
    <div class="container-fluid">
        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Email</h3>
                    </div>

                    <form method="post" action="{{ route('admin.email.save') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input name="title" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Purpose</label>
                                <select class="form-control" name="email_type">
                                    <option value="registration notif">Admin registration notification</option>
                                    <option value="registration notif to curator">Email to curator when they register</option>

                                    <option value="email to admin for invitation approval">Email to curator when they register</option>
                                    <option value="email to admin for music payment success">Email to admin for music payment success</option>
                                    <option value="email to admin for music submission">Email to admin for music submission</option>
                                    <option value="email to admin for completed work submission">Email to admin for completed work</option>
                                    <option value="email to admin for re-approval of invitation">Email to admin for invitation re-approval</option>
                                    <option value="email to admin for payout">Email to admin for payout request</option>
                                    <option value="email to admin when musician register">email to admin when musician register</option>

                                    <option value="email to artist for registration">Email to artist registration</option>

                                    <option value="email to musician for curators invitation">Email to musician for curators invitation</option>
                                    <option value="email to musician for music approval/payment">Email to musician for music approval/payment</option>
                                    <option value="email to musician for registration">Email to musician for registration</option>
                                    <option value="email to musician for paid invitation">Email to musician when invitation is paid</option>
                                    <option value="email to musician for work is completion">Email to musician when work is done</option>
                                    <option value="email to musician when song is free">Email to musician when song is free</option>
                                    <option value="email to musician when profile complete">Email to musician when profile complete</option>
                                    

                                    <option value="email to curator when work is approved">Email to curator when work is approved</option>
                                    <option value="email to curator when payout successful">Email to curator when payout successful</option>
                                    <option value="email to curator for Invitation">Email to curator for Invitation</option>
                                    <option value="email to curator when payout request">Email to curator for payout request</option>
                                    <option value="email to curator when work approved">Email to curator when work approved</option>
                                    <option value="email to curator when account approved">Email to curator when account approved</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email to</label>
                                <select class="form-control" name="email_to">
                                    <option value="">select</option>
                                    <option value="curator">curator</option>
                                    <option value="musician">musician</option>
                                    <option value="admin">admin</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" class="form-control" rows="3" placeholder="Enter email content..."></textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@stop
