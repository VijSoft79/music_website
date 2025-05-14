@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('plugins.DatatablesPlugin', true)

@section('plugins.Modal', true)

@section('title', 'AdminLTE Modal Example with Input Fields')

@section('content_header')
    <h1>Genre Lists</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row my-2">
            <div class="col-10">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @else
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-block btn-outline-primary" data-toggle="modal" data-target="#addGenreModal">Add Genre</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $heads = [
                                'ID',
                                'Name',
                                'Parent Name',
                                'Date Created',
                                // ['label' => 'Date Created', 'width' => 40],
                                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                            ];

                            $config = [
                                'data' => $data,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, null,['orderable' => false]],
                            ];
                        @endphp

                            {{-- Minimal example / fill data using the component slot --}}
                            

                        <x-adminlte-datatable id="table1" :heads="$heads">
                            @foreach ($config['data'] as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{!! $cell !!}</td>
                                    @endforeach  
                                </tr>
                            @endforeach
                         </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- add genre modal --}}
    <div class="modal fade" id="addGenreModal" tabindex="-1" role="dialog" aria-labelledby="addGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGenreModalLabel">Add Genre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addGenreForm" action="{{ route('admin.genre.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">

                            <label for="genreType">Select Genre Type: </label>
                            <select name="genreType" id="genreType" class="form-control" required>
                                <option value="parent" selected>Parent Genre</option>
                                <option value="Other Genre" >Other Genre</option>
                                <option value="child">Child Genre</option>
                            </select>

                            <div id="parentOption" hidden class="mt-2">
                                <label for="parent_id">Parent Genre: </label>
                                @if ($parentGenres)
                                    <select name="parent_id" id="parentId" class="form-control" >
                                        <option value="" selected>Select</option>
                                       
                                        @foreach ($parentGenres as $parentGenre)
                                            <option value="{{ $parentGenre->id }}">{{ $parentGenre->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                        </div>
                       
                        <div class="form-group" id="inputContainer">
                            <label for="genreName" class="col-form-label">Genre Name:</label>
                            <div class="row">
                                <input type="text" class="form-control col-9 ml-2" id="genreName" name="name" >
                                <button class="btn btn-success col-1 ml-1" title="Add more rows" id="addMore" type="button" onclick="addRow()" hidden > <i class="fa-regular fa-square-plus" ></i></button>
                                <button class="btn btn-secondary col-1 ml-1" title="Clear all rows" id="clearInput" type="button" onclick="clearRow()" hidden> <i class="fa-regular fa-square-minus"></i></button>
                            </div>
                          
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearRow()">Close</button>
                        <button type="submit" class="btn btn-primary">Add Genre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
       
    {{-- edit genre modal --}}
    <x-adminlte-modal id="modalMin" title="Edit Genre">
        <form class="form" id="editGenreForm" action="{{ route('admin.genre.update') }}" method="POST">
            @csrf 
            <div class="form-group">
                <label for="edit_parent">Parent Genre: </label>
                <select id="edit_parent" name="edit_parent" class="form-control">
                    <option id="parent" disabled selected>Select</option>
                    @foreach ($parentGenres as $parentGenre)
                        <option value="{{ $parentGenre->id }}">{{ $parentGenre->name }}</option>
                    @endforeach
                </select>   
            </div>
            <div class="form-group">
                <label for="editGenreName" class="col-form-label">Genre Name:</label>
                <input type="text" class="form-control" id="editGenreName" name="editGenreName">
                <input type="hidden" id="editGenreId" name="editGenreId" >
            </div>
           
            <x-slot name="footerSlot">
                <x-adminlte-button id="submitEdit" type="submit" class="btn btn-primary" label="Save" onclick="submitEditForm()"/>
                <x-adminlte-button class="btn-danger" data-dismiss="modal" label="Close"/>
            </x-slot>
            
            
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="mdlDelete" title="Delete Genre">
        <form class="form" id="deleteGenreForm" action="{{ route('admin.genre.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <h1 id="GenName"></h1>
               
               <input type="hidden" id="GenreId" name="Genre">
               <input type="hidden" id="parentIds" name="parents">
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button type="submit" id="delSubmit" theme="danger" data-dismiss="modal" label="Delete" onclick="submitDeleteForm()" />
                <x-adminlte-button class="btn-danger" data-dismiss="modal" label="Close"/>
            </x-slot>
        </form>
    </x-adminlte-modal>

   

    

@stop

@section('js')
    <script>
        //selector for genre type
        const selectGenre = document.getElementById('genreType');
        const selectType = document.getElementById('retType');

        const addRowButton = document.getElementById('addMore');
     
        function submitEditForm() {
            document.getElementById('editGenreForm').submit();
        }
        function submitDeleteForm() {
            document.getElementById('deleteGenreForm').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('[title="Edit"]').forEach(function(button) {
                button.addEventListener('click', function() {
                    var genreId = this.getAttribute('data-genre-id');
                    var genreName = this.getAttribute('data-genre-name');
                    var genreParent = this.getAttribute('data-genre-parent');
                    var genreParentId = this.getAttribute('data-genre-parentId');

                    document.getElementById('editGenreId').value = genreId;
                    document.getElementById('editGenreName').value = genreName;
                    document.getElementById('parent').value = genreParentId;
                    

                    // if (genreParent != "") {
                    //     document.getElementById('parent').textContent = genreParent;
                    //     document.getElementById('edit_parent').disabled = false; 
                    // } else {
                    //     document.getElementById('parent').textContent = 'Parent Genre'; 
                    //     document.getElementById('edit_parent').disabled = true;
                    // }
                });
            });
            

            document.querySelectorAll('[title="Delete"]').forEach(function(button) {
                button.addEventListener('click', function() {
                    var genreId = this.getAttribute('data-genre-id');
                    var genreName = this.getAttribute('data-genre-name');
                    var genreParentId = this.getAttribute('data-genre-parentId');
                    var genreParentName = this.getAttribute('data-genre-parent');
                    const checkButton = document.getElementById('delSubmit');

                    document.getElementById('GenreId').value = genreId;
                    document.getElementById('GenName').textContent = genreName;
                    document.getElementById('parentIds').value = genreParentId;

                    checkButton.addEventListener('click', function() {
                        
                        if (genreParentName === "Other Genre") {
                            const userConfirmed = confirm('This is a parent genre the child will also be deleted do you want to proceed?');
                            if (!userConfirmed) {
                                location.reload();
                            }

                        }else{
                            const userConfirmed1 = confirm('Are you sure you want to delete this Genre?');
                            if (!userConfirmed1) {
                                location.reload();
                            }

                        }

                    });
                            
                });

            });


            // document.querySelectorAll('[type="submit"]').forEach(function(button){
            //     button.addEventListener('click', function(){
                    
            //        var edit = document.getElementById('editGenreForm');
            //        var delete = document.getElementById('deleteGenreForm');
            //        if (edit) {
            //         edit.submit();
                    
            //        }else{
            //         delete.submit();
            //        }
            //     })
                
            // })

            
            
        });

        //add row
        let counter = 0;
        function addRow(){
            counter ++;
            const newInput = document.createElement('input');

            newInput.type = 'text';
            newInput.className = 'form-control mt-2 additionalRow'; 
            newInput.name = 'addition' + counter;

            document.getElementById('inputContainer').appendChild(newInput);

        }
        
        //clear row
         function clearRow(){
            const additionalRows = document.querySelectorAll('.additionalRow');

            additionalRows.forEach(row => row.remove());
        }

        //select parent
        selectGenre.addEventListener('change', function(){
            if (selectGenre.value == 'child') {

                document.getElementById('parentOption').hidden = false;
                document.getElementById('addMore').hidden = false;
                document.getElementById('clearInput').hidden = false;
                
                
            }
            else{

                document.getElementById('parentOption', 'addMore').hidden = true;
                document.getElementById('addMore').hidden = true;
                document.getElementById('clearInput').hidden = true;
                document.getElementById('genreName').value = '';
                document.getElementById('parentOption').value = '';
                document.getElementById('parentId').value = '';
                
                clearRow();
                
            }
        })

        
        
    </script>
@stop
