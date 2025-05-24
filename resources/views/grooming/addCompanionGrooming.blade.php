<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="" id="addGroomingForm" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="m-0 fw-bold text-purple">ADD Grooming</h5>
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
                                        <label for="morning_grooming">Grooming ( Morning )</label>
                                        <input type="text" name="morning_grooming" class="form-control">
                                        <div class="error morning_grooming_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="evening_grooming">Grooming ( Evening )</label>
                                        <input type="text" name="evening_grooming" class="form-control">
                                        <div class="error evening_grooming_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="expected_date">Expected Date</label>
                                        <input type="text" class="form-control" name="expected_date"
                                            id="expected_date">
                                        <div class="error expected_date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="administered_by">Administered By</label>
                                        <input type="text" class="form-control" name="administered_by"
                                            id="administered_by">
                                        <div class="error administered_by_err"></div>
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
                            <input type="submit" value="Submit" name="Submit" class="btn bg-purple px-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $("#addGroomingForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionGroomingProcess') }}",
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
                    loadCompanionGrooming();
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
