@extends('layouts/contentLayoutMaster')

@section('title', 'Business Details')
@section('page-style')
@endsection

@section('content')

    <section id="accordion-with-business-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="card collapse-icon">
                    <div class="card-header">
                        <h4 class="card-title">Business data</h4>
                    </div>
                    <div class="card-body">
                        <div class="collapse-margin" id="business_data">
                            <div class="card">
                                <div class="card-header" id="headingOne" data-toggle="collapse" role="button"
                                    data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="lead collapse-title"> Business </span>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#business_data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <table class="table table-borderless table-responsive text-left  ">
                                                    <tbody>

                                                        <tr>
                                                            <td> <b>Name</b> </td>
                                                            <td>{{ $business->name }} </td>
                                                        </tr>


                                                        <tr>
                                                            <td><b>Phone</b> </td>
                                                            <td> {{ $business->phone }}</td>
                                                        </tr>


                                                        <tr>
                                                            <td><b>Email</b> </td>
                                                            <td> {{ $business->email }} </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Address</b> </td>
                                                            <td> {{ $business->address }} </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <table class="table table-borderless table-responsive text-left  ">
                                                    <tbody>

                                                        <tr>
                                                            <td> <b>Type</b> </td>
                                                            <td>{{ $business->type }} </td>
                                                        </tr>


                                                        <tr>
                                                            <td><b>Age Of business</b> </td>
                                                            <td> {{ $business->age_of_business }} Yr.</td>
                                                        </tr>


                                                        <tr>
                                                            <td><b>Website</b> </td>
                                                            <td>
                                                                @if (!empty($business->website))
                                                                    <a href="{{ $business->website }}"
                                                                        target="_blank">{{ $business->website }}</a>
                                                                @else
                                                                    <span>N/A</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Status</b> </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-pill @switch($business->status) @case('inactive')
                                                                        badge-warning
                                                                        @break
                                                                    @case('active')
                                                                        badge-success
                                                                        @break
                                                                    @case('blocked')
                                                                        badge-danger
                                                                        @break
                                                                    @default
                                                                        badge-secondary @endswitch ">
                                                                    {{ $business->status }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card">
                                <div class="card-header" id="headingTwo" data-toggle="collapse" role="button"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span class="lead collapse-title">Document </span>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#business_data">
                                    <div class="card-body">
                                        <x-image-uploader name="doc_image" id="doc_image" :preview="$images"
                                            :onlyPreview="true" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-script')
@endsection
