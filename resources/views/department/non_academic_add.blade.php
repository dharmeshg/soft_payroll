        <div class="container-fluid academic_main">
            <div class="card">
                <div class="card-body wizard-content">
                    @if (isset($Department))
                        <h4 class="card-title">Edit Department (Non Academic)</h4>
                    @else
                        <h4 class="card-title">Add Department (Academic)</h4>
                    @endif

                    @if (isset($Department))
                        <form id="" action="{{ route('department.update', [$Department->id]) }}" method="POST"
                            class="mt-3" data-parsley-validate="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        @else
                            <form id="example-form" action="{{ route('department.store') }}" method="POST"
                                class="mt-3" autocomplete="off" data-parsley-validate=""
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                    @endif

                    <div role="application" class="wizard clearfix" id="steps-uid-0">
                        <div class="content clearfix">

                            <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1"
                                class="body current">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="name">Department Name*</label>
                                    <input id="departmentname" name="departmentname" type="text"
                                        class="required form-control" required
                                        data-parsley-required-message="Please Enter Department Name"
                                        value="{{ isset($Department->departmentname) ? $Department->departmentname : '' }}" />
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="description">Description*</label>
                                    <textarea class="form-control" id="departmentdescription" name="departmentdescription" rows="3" required=""
                                        data-parsley-required-message="Please Enter Description">{{ isset($Department->departmentdescription) ? $Department->departmentdescription : '' }}</textarea>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 form-group">
                                    <label for="directorate">School/Directorate</label>
                                    <select class="js-directorate" required=""
                                        data-parsley-required-message="Please Select School" name="directorate"
                                        id="directorate-dropdown">
                                        <option></option>
                                        @foreach ($faculty as $faculties)
                                            <option
                                                {{ isset($Department->faculty_id) && $Department->faculty_id == $faculties->id ? 'selected' : '' }}
                                                value="{{ $faculties->id }}">{{ $faculties->facultyname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div
                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 department-image form-group">
                                    <!--  <label for="imageupload">Image Upload*</label> -->
                                    <label for="inputTag">Choose image</label>
                                    <input type="file" name="image" required="" class="fullwidth inputTag"
                                        id="inputTag">
                                    @error('image')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label>&nbsp;</label>
                                    @if (isset($Department->image) && $Department->image != '' && $Department->image != null)
                                        <img id="image_preview"
                                            src="{{ asset('public/images') }}/{{ $Department->image }}"
                                            alt="Kin Image" class="img-fluid" />
                                    @else
                                    @endif
                                </div>
                        </div>
                        </section>
                    </div>
                    <div class="row">
                        <div class="col-12 change-btn">
                            <button type="submit" class="btn btn-primary">save</button>
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>

        </div>
        </div>
