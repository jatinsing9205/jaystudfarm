<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="" id="addCompanionPregnancyForm" method="post">
                    @csrf
                    <div class="card m-0">
                        <div class="card-header bg-light">
                            <h5 class="m-0 fw-bold text-maroon">ADD PREGNANCY ( {{ $companionID }} )</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" name="date" id="date">
                                        <div class="error date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="heat">Heat</label>
                                        <select class="form-control form-select" name="heat" id="heat">
                                            <option value="">Select Heat</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <div class="error heat_err"></div>
                                    </div>
                                </div>


                                <div class="col-md-3" id="miss_heat_div">
                                    <div class="form-group">
                                        <label for="miss_heat">Miss Heat</label>
                                        <select class="form-control form-select" name="miss_heat" id="miss_heat">
                                            <option value="">Select Miss Heat</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <div class="error miss_heat_err"></div>
                                    </div>
                                </div>


                                <div class="col-md-3" id="mating_div">
                                    <div class="form-group">
                                        <label for="mating">Mating</label>
                                        <select class="form-control form-select" name="mating" id="mating">
                                            <option value="">Select Mating</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <div class="error mating_err"></div>
                                    </div>
                                </div>


                                <div class="col-md-3" id="mating_date_div">
                                    <div class="form-group">
                                        <label for="mating_date">Mating Date</label>
                                        <input type="date" class="form-control" name="mating_date" id="mating_date">
                                        <div class="error mating_date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="companion_used_div">
                                    <div class="form-group">
                                        <label for="companion_used">Companion Used</label>
                                        <input class="form-control" name="companion_used" id="companion_used">
                                        <div class="error companion_used_err"></div>
                                    </div>
                                </div>

                                <div class="col-md-3" id="expected_heat_div">
                                    <div class="form-group">
                                        <label for="next_expected_date">Next Expected Date</label>
                                        <input type="text" class="form-control" name="next_expected_date"
                                            id="next_expected_date">
                                        <div class="error next_expected_date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="text" class="form-control" name="remark" id="remark">
                                        <div class="error remark_err"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top py-1 px-2 text-end">
                            <input type="hidden" name="companion_id" value="{{ $companionID }}">
                            <input type="submit" value="Submit" name="Submit" class="btn bg-maroon px-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Submit form for adding category
    $("#addCompanionPregnancyForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionPregnancyProcess') }}",
            data: data,
            processData: false,
            contentType: false,
            success(res) {
                console.log(res);
                $('.preloader').height(0);
                $('.preloader img').hide();

                Swal.fire({
                    icon: res.status,
                    title: res.message
                });

                if (res.status === 'success') {
                    form.reset();
                    loadCompanionPregnancy();
                    loadCompanionLog();
                    $("#popupModal .modal-body").empty();
                    $("#popupModal").modal("hide");
                } else {
                    printError(res.error);
                }

                $('input[type="submit"]').prop("disabled", false);
            },
            error(err) {
                $('.preloader').height(0);
                $('.preloader img').hide();
                console.log(err.responseJSON);
                $('input[type="submit"]').prop("disabled", false);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#expected_heat_div").hide();
        $("#mating_date_div").hide();
        $("#mating_div").hide();
        $("#miss_heat_div").hide();
        $("#companion_used_div").hide();

        $(document).on("change", "#heat", function() {
            var heat = $(this).val();
            if (heat == "Yes") {
                $("#miss_heat_div").show();
                $("#mating_div, #mating_date_div, #companion_used_div, #expected_heat_div").hide();

                // Clear fields when hidden
                $("#mating").val("");
                $("#mating_date").val("");
                $("#companion_used").val("");
                $("#next_expected_date").val("");
            } else if (heat == "No") {
                $("#miss_heat_div, #mating_div, #mating_date_div, #companion_used_div").hide();
                $("#expected_heat_div").show();

                // Clear all dependent fields
                $("#miss_heat").val("");
                $("#mating").val("");
                $("#mating_date").val("");
                $("#companion_used").val("");
                $("#next_expected_date").val("");
            } else {
                $("#miss_heat_div, #mating_div, #mating_date_div, #companion_used_div, #expected_heat_div").hide();

                $("#miss_heat").val("");
                $("#mating").val("");
                $("#mating_date").val("");
                $("#companion_used").val("");
                $("#next_expected_date").val("");
            }
        });

        $(document).on("change", "#miss_heat", function() { 
            var missHeat = $(this).val();
            if (missHeat == "No") {
                $("#mating_div").show();
                $("#expected_heat_div, #mating_date_div, #companion_used_div").hide();

                $("#mating_date").val("");
                $("#companion_used").val("");
                $("#next_expected_date").val("");
            } else {
                $("#expected_heat_div").show();
                $("#mating_div, #mating_date_div, #companion_used_div").hide();

                $("#mating").val("");
                $("#mating_date").val("");
                $("#companion_used").val("");
            }
        });

        $(document).on("change", "#mating", function() {
            var mating = $(this).val();
            if (mating == "No") {
                $("#expected_heat_div").show();
                $("#mating_date_div, #companion_used_div").hide();

                $("#mating_date").val("");
                $("#companion_used").val("");
            } else {
                $("#mating_date_div").show();
                $("#companion_used_div").show();
                $("#expected_heat_div").hide();

                $("#next_expected_date").val("");
            }
        });
    });
</script>
