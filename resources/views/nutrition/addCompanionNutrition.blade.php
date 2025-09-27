<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card m-0">
                    <form action="" method="post" id="addCompaionNutritionForm">
                        @csrf
                        <div class="card-header bg-light">
                            <h5 class="m-0 text-warning fw-bold">ADD NUTRITION ( {{ $companionID }} )</h5>
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
                                        <label for="food">Food</label>
                                        <select name="food" id="food" class="form-control form-select">
                                            <option value="">Select Food</option>
                                            <option value="Feed">Feed</option>
                                            <option value="Nera">Nera</option>
                                            <option value="Lussan">Lussan</option>
                                            <option value="Javi">Javi</option>
                                            <option value="Gur">Gur</option>
                                            <option value="Chana">Chana</option>
                                            <option value="Halwa">Halwa</option>
                                            <option value="Oil">Oil</option>
                                            <option value="Meetha Soda">Meetha Soda</option>
                                        </select>
                                        <div class="error food_err"></div>
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
                                                        <option value="Grams">Grams</option>
                                                        <option value="Kg">Kg</option>
                                                        <option value="L">L</option>
                                                        <option value="ml">ml</option>
                                                        <option value="Count">Count</option>
                                                    </select>
                                                </span>
                                            </div>
                                            <input type="text"
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode === 46 && this.value.indexOf('.') === -1)"
                                                name="quantity" id="quantity" class="form-control">
                                        </div>
                                        <!-- /.input group -->
                                        <div class="error quantity_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="time_first_feed">Time For First Feed</label>
                                        <input type="time" class="form-control" name="time_first_feed"
                                            id="time_first_feed">
                                        <div class="error time_first_feed_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="time_second_feed">Time For Second Feed</label>
                                        <input type="time" class="form-control" name="time_second_feed"
                                            id="time_second_feed">
                                        <div class="error time_second_feed_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="expected_date">Expected Date</label>
                                        <input type="text" class="form-control datepicker" name="expected_date"
                                            id="expected_date"  autocomplete="off">
                                        <div class="error expected_date_err"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="administered_by">Administered by</label>
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
                            <input type="submit" value="Submit" name="Submit" class="btn btn-warning px-4">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Submit form for adding category
    $("#addCompaionNutritionForm").submit(function(e) {
        e.preventDefault();
        clearError();

        let form = this;
        let data = new FormData(form);

        $('input[type="submit"]').prop('disabled', true);
        $('.preloader').height("100vh");
        $('.preloader img').show();

        $.post({
            url: "{{ route('addCompanionNutritionProcess') }}",
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
                    loadCompanionNutrition();
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


    function loadNutrition() {
        $.ajax({
            type: "GET",
            url: '{{ route("nutritions.getJSON")}}',
            success: function(data) {
                // console.log(data);
                var food = $('#food');
                food.html('');
                food.append("<option value=''>Select Nutrition</option>")
                data.forEach(function(nutrition, index) {
                    var row = `<option value="${nutrition.id}">${nutrition.name}</option>`;
                    food.append(row);
                });
            }
        });
    }

    loadNutrition();


</script>
