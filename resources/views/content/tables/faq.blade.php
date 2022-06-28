@extends('layouts/contentLayoutMaster')

@section('title', 'Faq')
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
    <x-side-modal title="Add faq" id="add-faqs-modal">
        <x-form id="add-faqs" method="POST" class="" :route="route('admin.extra.faq.store')">
            <div class="col-md-12 col-12 ">
                <x-input name="question" />
            </div>
            <div class="col-md-12 col-12 ">
                <x-input :required="false" name="answer" type="textarea" />
            </div>
        </x-form>
    </x-side-modal>

@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('.dataTables_wrapper .dt-buttons').append(
                `<button type="button" data-toggle="modal" data-target="#add-faqs-modal"  class="btn btn-flat-success waves-effect float-md-right">Add</button>`
            );
        });
    </script>
@endsection
