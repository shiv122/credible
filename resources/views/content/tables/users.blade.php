@extends('layouts/contentLayoutMaster')

@section('title', 'Users')
@section('page-style')
@endsection

@section('content')

    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card>
                    {!! $dataTable->table() !!}
                </x-card>
            </div>
        </div>
    </section>
    <x-side-modal title="Add user" id="add-users-modal">
        <x-form id="add-users" method="POST" class="" :route="route('admin.users.store')">
            <div class="col-md-12 col-12 ">
                <x-input name="name" />
            </div>
            <div class="col-md-12 col-12 ">
                <x-input name="email" type="email" />
            </div>
            <div class="col-md-12 col-12 ">
                <x-input name="phone" type="number" />
            </div>
            <div class="col-md-12 col-12 ">
                <x-input :required="false" name="address" type="textarea" />
            </div>
        </x-form>
    </x-side-modal>

@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('.dataTables_wrapper .dt-buttons').append(
                `<button type="button" data-toggle="modal" data-target="#add-users-modal"  class="btn btn-flat-success waves-effect float-md-right">Add</button>`
            );
        });
    </script>
@endsection
