<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.employee')

@section('content')
<style>
    input[type='file'] {
        color: transparent;
    }
</style>
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Transfer Class</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                @if( isset( $transferclass ) )
                <h4 class="card-title">Edit Transfer Class</h4>
                @else
                <h4 class="card-title">Add Transfer Class</h4>
                @endif

                @if( isset( $transferclass ) )
                <form id="" action="{{route('transferclass.update',[$transferclass->id])}}" method="POST"autocomplete="off" data-parsley-validate="">
                {{ csrf_field() }}
                @else
                <form id="example-form" action="{{ route('transferclass.store')}}" method="POST" class="mt-3"autocomplete="off" data-parsley-validate="">
                {{ csrf_field() }}
                @endif


                        <div role="application" class="wizard clearfix" id="steps-uid-0">
                            <div class="content clearfix">

                                <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                    class="body current">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                        <label for="classname">Class name*</label>
                                        <select class="js-example-basic-single" name="classname">
                                            <option></option>
                                            <option {{ ( isset($transferclass->classname) && ( $transferclass->classname
                                                == 'Transfer In' ) ? 'selected' : '' )}} value="Transfer In">Transfer In</option>
                                            <option {{ ( isset($transferclass->classname) && ( $transferclass->classname
                                                == 'Transfer Out' ) ? 'selected' : '')}} value="Transfer Out">Transfer Out</option>
                                        </select>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                        <label for="description">Description*</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                            required="" data-parsley-required-message="Please Enter Description"
                                            name="description">{{ (( isset($transferclass->description) ) ? $transferclass->description: '')}}</textarea>
                                    </div>
                                </section>
                            </div>
                            <div class="row">
                                <div class="col-12 change-btn form-group">
                                    <button type="submit" class="btn btn-primary">save</button>
                                </div>
                            </div>

                        </div>
                    </form>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function () {
        $('input[type="file"]').change(function () {
            if ($(this).val() != "") {
                $(this).css('color', '#333');
            } else {
                $(this).css('color', 'transparent');
            }
        });
    })
</script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            placeholder: "--Select--",
            allowClear: true
        });
    });
</script>
@endsection