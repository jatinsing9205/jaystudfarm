<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="" id="addCompaionSupplementForm" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-light fw-bold">
                            <h5 class="m-0 text-orange fw-bold">ADD Supplements</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">Feeding Date</label>
                                        <input type="date" class="form-control" name="date" id="date">
                                        <div class="error date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="supplement">Supplement</label>
                                        <select class="form-control form-select" name="supplement" id="supplement">
                                            <option value="">Select Supplements</option>
                                            {{-- <option value="Mega Oil / Equigold H">Mega Oil / Equigold H</option>
                                            <option value="Mega Oil">Mega Oil</option>
                                            <option value="Alsi Taramira Oil">Alsi Taramira Oil</option>
                                            <option value="Live 52">Live 52</option>
                                            <option value="Bioteen">Bioteen</option>
                                            <option value="Himalaya Patisa">Himalaya Patisa</option>
                                            <option value="Sharkafol">Sharkafol</option>
                                            <option value="My Foul Grow">My Foul Grow</option>
                                            <option value="Alphapet">Alphapet</option>
                                            <option value="Kali Ziri">Kali Ziri</option>
                                            <option value="Vigest for Growing Animal">Vigest for Growing Animal</option> --}}
                                        </select>
                                        <div class="error supplement_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-0">
                                                    <select name="measure_unit" id="measure_unit"
                                                        class="form-control form-control-sm bg-transparent border-0 form-select">
                                                        <option value="Gram">Gram</option>
                                                        <option value="Kilo Gram">Kilo Gram</option>
                                                        <option value="Litre">Litre</option>
                                                        <option value="Mili Litre">Mili Litre</option>
                                                        <option value="Count">Count</option>
                                                    </select>
                                                </span>
                                            </div>
                                            <input type="text"
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode === 46 && this.value.indexOf('.') === -1)"
                                                name="quantity" id="quantity" class="form-control">
                                        </div>
                                        <div class="quantity_err error"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="time">Time Given</label>
                                        <input type="time" class="form-control" name="time" id="time">
                                        <div class="error time_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="expected_date">Expected Date</label>
                                        <input type="text" class="form-control datepicker" name="expected_date"
                                            id="expected_date" autocomplete="off">
                                        <div class="error expected_date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="administered_by">Administered by</label>
                                        <input type="text" class="form-control" name="administered_by"
                                            id="administered_by">
                                        <div class="error administered_by"></div>
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
                            <input type="submit" value="Submit" name="Submit" class="btn bg-orange px-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Submit form for adding category
    $("#addCompaionSupplementForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionSupplementProcess') }}",
            data: data,
            processData: false,
            contentType: false,
            success(res) {
                console.log(res)
                $('.preloader').height(0);
                $('.preloader img').hide();

                Swal.fire({
                    icon: res.status,
                    title: res.message
                });

                if (res.status === 'success') {
                    form.reset();
                    loadCompanionSupplement();
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

    function loadSupplements() {
        $.ajax({
            type: "GET",
            url: "{{ Route('getAllSupplements') }}",
            success: function(data) {
                console.log(data);
                var supplementInput = $('#supplement');
                supplementInput.html('')
                supplementInput.append('<option value="">Select Supplement</option>')
                data.forEach(function(supplement, index) {
                    var row = `<option value="${supplement.id}">${supplement.name}</option>`;

                    supplementInput.append(row);
                });
            }
        });
    }
    loadSupplements();


</script>
