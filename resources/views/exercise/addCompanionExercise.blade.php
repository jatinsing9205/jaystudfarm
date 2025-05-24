<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="addCompaionExerciseForm">
                    @csrf
                    <div class="card mb-0">
                        <div class="card-header bg-light">
                            <h5 class="m-0 fw-bold text-primary">ADD EXERCISE</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" name="date" id="date">
                                        <div class="error date_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="exercise">Type of Exercise</label>
                                        <select name="exercise" id="exercise" class="form-control form-select">
                                            <option value="">Select Exercise</option>
                                        </select>
                                        <div class="error exercise_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="time_spent">Time Spent</label>
                                        <input type="text" class="form-control" name="time_spent" id="time_spent">
                                        <div class="error time_spent_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="given_by">Given By</label>
                                        <input type="text" class="form-control" name="given_by" id="given_by">
                                        <div class="error given_by_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="monitored_by">Monitored By</label>
                                        <input type="text" class="form-control" name="monitored_by"
                                            id="monitored_by">
                                            <div class="error monitored_by_err"></div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="expected_date">Expected Date</label>
                                        <input type="text" class="form-control" name="expected_date"
                                            id="expected_date">
                                            <div class="error expected_date_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="text" class="form-control" name="remark" id="remark">
                                        <div class="error remark_err"></div>
                                    </div>
                                    {{-- <input type="hidden" name="companion_id" value="{{ $companionID }}"> --}}
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
    $("#addCompaionExerciseForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionExerciseProcess') }}",
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
                    loadCompanionExercise();
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

    function loadExercises() {
        $.ajax({
            type: "GET",
            url: "{{ Route('getAllExercises') }}",
            success: function(data) {

                var input = $('select#exercise');
                data.forEach(function(supplement, index) {
                    var row = `<option value="${supplement.id}">${supplement.name}</option>`;
                    input.append(row);
                });
            }
        });
    }

    loadExercises();
</script>
