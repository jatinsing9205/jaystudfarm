<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="addCompanionBodyweightForm">
                    @csrf
                    <div class="card mb-0">
                        <div class="card-header bg-light">
                            <h5 class="m-0 fw-bold text-gray">ADD BODY WEIGHT ( {{ $companionID }} )</h5>
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
                                        <label for="weight">Weight (In Kg)</label>
                                        <input type="number" name="weight" id="weight" class="form-control"
                                            step="0.5" min="0">
                                        <div class="error weight_err"></div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="checked_by">Checked By</label>
                                        <input type="text" class="form-control" name="checked_by" id="checked_by">
                                        <div class="error checked_by_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="expected_date">Expected Date</label>
                                        <input type="text" class="form-control" name="expected_date"
                                            id="expected_date" autocomplete="off">
                                        <div class="error expected_date_err"></div>
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
                            <input type="submit" value="Submit" name="Submit" class="btn bg-gray px-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $("#addCompanionBodyweightForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionBodyweightProcess') }}",
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
                    loadCompanionBodyweight();
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
