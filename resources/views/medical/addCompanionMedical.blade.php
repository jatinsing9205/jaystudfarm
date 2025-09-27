<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="addCompaionMedicalForm">
                    @csrf
                    <div class="card mb-0">
                        <div class="card-header bg-light">
                            <h5 class="m-0 fw-bold text-success">ADD Medical ( {{ $companionID }} )</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="date">Date of Treatment</label>
                                        <input type="date" class="form-control" name="date" id="date">
                                        <div class="error date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="treated_for">Treated for</label>
                                        <select name="treated_for" id="treated_for" class="form-control form-select">
                                            <option value="">Select Medical Issue</option>
                                            <option value="deworming">Deworming</option>
                                            <option value="Vacination">Vacination</option>
                                            <option value="tetnus">Tetanus</option>
                                            <option value="pregnancy">Pregnancy</option>
                                            <option value="chronic">Chronic</option>
                                            <option value="laminitus">Laminitis</option>
                                            <option value="hoove_ring">Hoof Ring</option>
                                            <option value="body_injury">Body Injury</option>
                                            <option value="sara">Sara</option>
                                            <option value="rodococus">Rodococcus</option>
                                            <option value="running_nose_cold">Running Nose and Cold</option>
                                        </select>
                                        <div class="error treated_for_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="medication_given">Medication Given</label>
                                        <input type="text" class="form-control" name="medication_given"
                                            id="medication_given">
                                        <div class="error medication_given_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="next_follow_up_remark">Next follow up treatment (Remarks)</label>
                                        <input type="text" class="form-control" name="next_follow_up_remark"
                                            id="next_follow_up_remark">
                                        <div class="error next_follow_up_remark_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="next_date_of_follow_up_treatment">Date of Follow Up
                                            Treatment</label>
                                        <input type="text" class="form-control datepicker"
                                            name="next_date_of_follow_up_treatment"
                                            id="next_date_of_follow_up_treatment" autocomplete="off">
                                        <div class="error next_date_of_follow_up_treatment_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="doctor_remark">Doctor's Remark</label>
                                        <input type="text" class="form-control" name="doctor_remark"
                                            id="doctor_remark">
                                        <div class="error doctor_remark_err"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top py-1 px-2 text-end">
                            <input type="hidden" name="companion_id" value="{{ $companionID }}">
                            <input type="submit" value="Submit" name="Submit" class="btn btn-success px-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Submit form for adding category
    $("#addCompaionMedicalForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionMedicalProcess') }}",
            data: data,
            processData: false,
            contentType: false,
            success(res) {
                $('.preloader').height(0);
                $('.preloader img').hide();

                Swal.fire({
                    icon: res.status,
                    title: res.message
                });

                if (res.status === 'success') {
                    form.reset();
                    loadCompanionMedical();
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


    function loadMedical() {
        $.ajax({
            type: "GET",
            url: '{{ route('medicals.getJSON') }}',
            success: function(data) {
                // console.log(data);
                var food = $('#treated_for');
                food.html('');
                food.append("<option value=''>Select Medical</option>")
                data.forEach(function(medical, index) {
                    var row = `<option value="${medical.id}">${medical.name}</option>`;
                    food.append(row);
                });
            }
        });
    }
    loadMedical();
</script>
