//Load Companion Logs
function loadCompanionLog() {
    $.ajax({
        type: "GET",
        url: companionLog,
        success: function (data) {
            // console.log(data);
            var table = $('#companionLog');
            var tableBody = table.find('tbody').html('');
            table.DataTable().clear().destroy();
            data.forEach(function (log, index) {
                var formattedDate = moment(log.created_at).format(
                    "DD-MM-YYYY | HH:mm:ss");
                var row = `
            <tr>
                <td>${index + 1}</td> 
                <!--<td>${log.id}</td>-->
                <td>${log.action}</td>
                <td>${log.created_by}</td>
                <td>${formattedDate}</td>
            </tr>
        `;
                tableBody.append(row);
            });

            table.DataTable({
                responsive: true
            });
        }
    });
}
loadCompanionLog();




//Add Nutrition Button Click
$(document).on("click", "#addNutritionsBtn", function (e) {
    e.preventDefault();
    $.ajax({
        url: addNutritionUrl,
        type: "GET",
        success: function (data) {
            $("#popupModal .modal-body").html(data);
            $("#popupModal").modal("show")
            $('#expected_date').datepicker({
                format: 'dd-mm-yyyy',
                multidate: true,
                todayHighlight: true
            });
        },
        error: function () {
            console.log("We could not found anything");
        }
    })
})
function loadCompanionNutrition() {
    $.ajax({
        type: "GET",
        url: getCompanionNutrition,
        success: function (data) {
            console.log(data);
            var table = $('#companionNutritionTable');
            var tableBody = table.find('tbody').html('');
            table.DataTable().clear().destroy();
            var dataa = data.nutritions
            dataa.forEach(function (nutrition, index) {
                var row = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${nutrition.date ?? ""}</td>
                        <td>${nutrition.nutrition ?? ""}</td>
                        <td>${nutrition.quantity} ${nutrition.unit}</td>
                        <td>${nutrition.first_feed_timing ?? ""}</td>
                        <td>${nutrition.second_feed_timing ?? ""}</td>
                        <td>${nutrition.expected_date ?? ""}</td>
                        <td>${nutrition.administered_by ?? ""}</td>
                    </tr>
                `;
                tableBody.append(row);
            });

            table.DataTable({
                responsive: true
            });
        }
    });
}
loadCompanionNutrition();




// Add Supplements
$(document).on("click", "#Supplements-tab", function (e) {
    loadCompanionSupplement()
})
function loadCompanionSupplement() {

    var loader = $('.preloader');
    var loaderIMG = $('.preloader img');
    loader.height("100vh");
    loaderIMG.show()

    $.ajax({
        type: "GET",
        url: getCompanionSupplement,
        success: function (data) {
            loader.height("0vh");
            loaderIMG.hide()

            console.log(data);

            var table = $('#companionSupplementTable');
            var tableBody = table.find('tbody').html('');
            table.DataTable().clear().destroy();
            var dataa = data.supplements

            dataa.forEach(function (supplement, index) {
                var row = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${supplement.date}</td>
                        <td>${supplement.supplement_name}</td>
                        <td>${supplement.quantity} ${supplement.unit}</td>
                        <td>${supplement.time ?? ""}</td>
                        <td>${supplement.expected_date ?? ""}</td>
                        <td>${supplement.administered_by ?? ""}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
            table.DataTable({
                responsive: true
            });
        }
    });
}
$(document).on("click", "#addSupplementsBtn", function (e) {
    e.preventDefault();
    $.ajax({
        url: addCompanionSupplementView,
        type: "GET",
        success: function (data) {
            $("#popupModal .modal-body").html(data);
            $("#popupModal").modal("show")
            $('#expected_date').datepicker({
                format: 'dd-mm-yyyy',
                multidate: true,
                todayHighlight: true
            });
        },
        error: function () {
            console.log("We could not found anything");
        }
    })
})




//Add Medical
$(document).on("click", "#addMedicalBtn", function (e) {
    e.preventDefault();
    $.ajax({
        url: addCompanionMedicalView,
        type: "GET",
        success: function (data) {
            $("#popupModal .modal-body").html(data);
            $("#popupModal").modal("show")
            $('#next_date_of_follow_up_treatment').datepicker({
                format: 'dd-mm-yyyy',
                multidate: true,
                todayHighlight: true
            });
        },
        error: function () {
            console.log("We could not found anything");
        }
    })
})
$(document).on("click", "#Medical-tab", function (e) {
    loadCompanionMedical()
})
function loadCompanionMedical() {

    var loader = $('.preloader');
    var loaderIMG = $('.preloader img');
    loader.height("100vh");
    loaderIMG.show()

    $.ajax({
        type: "GET",
        url: getCompanionMedical,
        success: function (data) {
            loader.height("0vh");
            loaderIMG.hide()

            console.log(data);

            var table = $('#companionMedicalTable');
            var tableBody = table.find('tbody').html('');
            table.DataTable().clear().destroy();
            var dataa = data.medicals

            dataa.forEach(function (medical, index) {
                var row = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${medical.medical}</td>
                        <td>${medical.date}</td>
                        <td>${medical.medication_given}</td>
                        <td>${medical.next_followup_remark}</td>
                        <td>${medical.next_followup_date}</td>
                        <td>${medical.doctor_remark ?? ""}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
            table.DataTable({
                responsive: true
            });
        }
    });
}



//Add Exercise
$(document).on("click", "#addExerciseBtn", function (e) {
    e.preventDefault();
    $.ajax({
        url: addCompanionExerciseView,
        type: "GET",
        success: function (data) {
            $("#popupModal .modal-body").html(data);
            $("#popupModal").modal("show")
            $('#expected_date').datepicker({
                format: 'dd-mm-yyyy',
                multidate: true,
                todayHighlight: true
            });
        },
        error: function () {
            console.log("We could not found anything");
        }
    })
})
$(document).on("click", "#Exercise-tab", function (e) {
    loadCompanionExercise()
})
function loadCompanionExercise() {

    var loader = $('.preloader');
    var loaderIMG = $('.preloader img');
    loader.height("100vh");
    loaderIMG.show()

    $.ajax({
        type: "GET",
        url: getCompanionExercise,
        success: function (data) {
            loader.height("0vh");
            loaderIMG.hide()

            console.log(data);

            var table = $('#companionExerciseTable');
            var tableBody = table.find('tbody').html('');
            table.DataTable().clear().destroy();
            var dataa = data.exercise

            dataa.forEach(function (exercise, index) {
                var row = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${exercise.date ?? ""}</td>
                        <td>${exercise.exercise_name ?? ""}</td>
                        <td>${exercise.given_by ?? ""}</td>
                        <td>${exercise.time_spent ?? ""}</td>
                        <td>${exercise.monitored_by ?? ""}</td>
                        <td>${exercise.expected_date ?? ""}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
            table.DataTable({
                responsive: true
            });
        }
    });
}



//Add Grooming
$(document).on("click", "#addGroomingBtn", function (e) {
    e.preventDefault();
    $.ajax({
        url: addCompanionGroomingView,
        type: "GET",
        success: function (data) {
            $("#popupModal .modal-body").html(data);
            $("#popupModal").modal("show")
            $('#expected_date').datepicker({
                format: 'dd-mm-yyyy',
                multidate: true,
                todayHighlight: true
            });
        },
        error: function () {
            console.log("We could not found anything");
        }
    })
})
$(document).on("click", "#Grooming-tab", function (e) {
    loadCompanionGrooming()
})
function loadCompanionGrooming() {

    var loader = $('.preloader');
    var loaderIMG = $('.preloader img');
    loader.height("100vh");
    loaderIMG.show()

    $.ajax({
        type: "GET",
        url: getCompanionGrooming,
        success: function (data) {
            loader.height("0vh");
            loaderIMG.hide()

            console.log(data);

            var table = $('#companionGroomingTable');
            var tableBody = table.find('tbody').html('');
            table.DataTable().clear().destroy();
            var dataa = data.Grooming

            dataa.forEach(function (grooming, index) {
                var row = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${grooming.date ?? ""}</td>
                        <td>${grooming.morning_grooming ?? ""}</td>
                        <td>${grooming.evening_grooming ?? ""}</td>
                        <td>${grooming.administered_by ?? ""}</td>
                        <td>${grooming.expected_date ?? ""}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
            table.DataTable({
                responsive: true
            });
        }
    });
}