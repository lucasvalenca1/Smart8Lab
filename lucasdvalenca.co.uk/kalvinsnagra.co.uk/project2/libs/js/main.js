$(window).on('load', function() {
    if ($('#preloader').length) {
        $('#preloader').delay(200).fadeOut('slow', function() {
            $(this).remove();
        });
    }
});


$(document).ready(function() {



    /*--------------------------------------------------OTHER SECTION-------------------------------------------------*/

    // HIDES FILTER BUTTON ON DEPARTMENTS/ LOCATIONS TAB

    $('#myTab').on('shown.bs.tab', function(e) {

        if ($(e.target).is('#departmentsBtn, #locationsBtn')) {

            $('#filterBtn').hide();

        } else {

            $('#filterBtn').show();

        }
    });


    /*--------------------------------------------------OTHER SECTION-------------------------------------------------*/


    /*--------------------------------------------------PERSONNEL SECTION-------------------------------------------------*/


    //refresh personnel table
    function refreshPersonnelTable() {
        $.ajax({
            url: "libs/php/getAll.php",
            type: 'GET',
            dataType: 'json',
            success: function(result) {

                console.log(JSON.stringify(result));

                if (result.status.name == "ok") {

                    $("#personnelResults").empty();

                    //appends rows once instead of one at a time
                    var rows = "";

                    result.data.forEach(function(iterator) {

                        rows += `
                        <tr>

                            <td class="align-middle text-nowrap">${iterator.lastName}, ${iterator.firstName}</td>

                            <td class="align-middle text-nowrap d-none d-md-table-cell">${iterator.jobTitle}</td>

                            <td class="align-middle text-nowrap d-none d-md-table-cell personnelDepartmentCol">${iterator.department}</td>

                            <td class="align-middle text-nowrap d-none d-md-table-cell personnelLocationCol">${iterator.location}</td>

                            <td class="align-middle text-nowrap d-none d-md-table-cell">${iterator.email}</td>

                            <td class="text-end text-nowrap">

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPersonnelModal" data-id="${iterator.id}">
                                    <i class="fa-solid fa-pencil fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-sm deletePersonnelBtn" data-id="${iterator.id}">
                                    <i class="fa-solid fa-trash fa-fw"></i>
                                </button>

                            </td>

                        </tr>`;
                    });

                    $("#personnelResults").append(rows);

                    deletePersonnelFunction();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            }
        });
    }



    function deletePersonnelFunction() {

        $(".deletePersonnelBtn").off().click(function() {

            var personnelID = $(this).attr("data-id");

            $.ajax({
                url: "libs/php/getPersonnelByID.php",
                type: 'GET',
                dataType: 'json',
                data: {
                    id: personnelID
                },

                success: function(result) {

                    console.log(JSON.stringify(result));

                    if (result.status.name === "ok") {

                        var personnel = result.data.personnel[0];

                        var name = personnel.firstName + " " + personnel.lastName;

                        $("#deletePersonnelName").text(name);

                        $('#deletePersonnelModal').modal('show');

                        $("#deletePersonnelBtn").off().click(function() {
                            $.ajax({
                                url: "libs/php/deletePersonnelByID.php",
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id: personnelID
                                },

                                success: function(result) {

                                    if (result.status.code == 200) {

                                        console.log("Personnel deleted successfully.");

                                        refreshPersonnelTable();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("AJAX Error:", errorThrown);
                                }
                            });
                        });
                    } else {
                        alert("Failed to get personnel details.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Failed to get personnel details.");
                }
            });
        });

    }

    //refreshes personnel tab
    $("#personnelBtn").click(function() {

        $("#searchInp").val('');

        //refreshes the filter button selects
        defaultSelectedDepartment = 'All';
        defaultSelectedLocation = 'All';

        refreshPersonnelTable();
    });


    refreshPersonnelTable();



    $("#editPersonnelModal").on("show.bs.modal", function(e) {

        $.ajax({
            url: "libs/php/getPersonnelByID.php",
            type: "POST",
            dataType: "json",
            data: {
                id: $(e.relatedTarget).attr("data-id")
            },

            success: function(result) {

                var resultCode = result.status.code;

                if (resultCode == 200) {
                    // Update the hidden input with the employee id so that
                    // it can be referenced when the form is submitted

                    $("#editPersonnelEmployeeID").val(result.data.personnel[0].id);

                    $("#editPersonnelFirstName").val(result.data.personnel[0].firstName);

                    $("#editPersonnelLastName").val(result.data.personnel[0].lastName);

                    $("#editPersonnelJobTitle").val(result.data.personnel[0].jobTitle);

                    $("#editPersonnelEmailAddress").val(result.data.personnel[0].email);

                    $("#editPersonnelDepartment").html("");

                    $.each(result.data.department, function() {

                        $("#editPersonnelDepartment").append(

                            $("<option>", {
                                value: this.id,
                                text: this.name
                            })
                        );
                    });

                    $("#editPersonnelDepartment").val(result.data.personnel[0].departmentID);

                } else {

                    $("#editPersonnelModal .modal-title").replaceWith(

                        "Error retrieving data"
                    );
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $("#editPersonnelModal .modal-title").replaceWith(
                    "Error retrieving data"
                );
            }
        });
    });




    $('#editPersonnelForm').on('submit', function(e) {

        e.preventDefault();


        var personnelData = {

            id: $('#editPersonnelEmployeeID').val(),

            firstName: $('#editPersonnelFirstName').val(),

            lastName: $('#editPersonnelLastName').val(),

            jobTitle: $('#editPersonnelJobTitle').val(),

            email: $('#editPersonnelEmailAddress').val(),

            departmentID: $('#editPersonnelDepartment').val()

        };

        $.ajax({
            url: 'libs/php/updatePersonnelByID.php',
            type: 'POST',
            dataType: 'json',
            data: personnelData,
            success: function(result) {

                console.log(result);

                if (result.status.code === '200') {

                    console.log('Personnel updated successfully.');

                    $('#editPersonnelModal').modal('hide');

                    refreshPersonnelTable();

                } else {

                    console.error('Error updating personnel:', result.status.description);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error('AJAX Error:', errorThrown);
            }
        });
    });





    // ADD PERSONNEL BUTTON

    $("#addPersonnelModal").on('show.bs.modal', function(e) {
        // Reset the form when the modal is shown
        $('#addPersonnelForm')[0].reset();

        refreshPersonnelDepartments();
    });


    $("#addBtn").click(function() {
        if ($("#personnelBtn").hasClass("active")) {

            $("#addPersonnelModal").modal("show");
        }
    });


    $('#addPersonnelForm').on('submit', function(e) {
        e.preventDefault();


        var personnelData = {

            firstName: $('#addPersonnelFirstName').val(),

            lastName: $('#addPersonnelLastName').val(),

            jobTitle: $('#addPersonnelJobTitle').val(),

            email: $('#addPersonnelEmailAddress').val(),

            departmentID: $('#addPersonnelDepartment').val()

        };


        $.ajax({
            url: 'libs/php/insertPersonnel.php',
            type: 'POST',
            dataType: 'json',
            data: personnelData,
            success: function(result) {


                console.log(result);

                if (result.status.code === '200') {

                    console.log('Personnel added successfully.');

                    $("#addPersonnelModal").modal("hide");

                    refreshPersonnelTable();

                    refreshPersonnelDepartments();

                } else {

                    console.error('Error adding personnel:', result.status.description);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error('AJAX Error:', errorThrown);
            }
        });
    });


    function refreshPersonnelDepartments() {
        $.ajax({
            url: "libs/php/getAllDepartments.php",
            type: 'GET',
            dataType: 'json',

            success: function(result) {

                console.log(JSON.stringify(result));

                if (result.status.name == "ok") {

                    $("#addPersonnelDepartment").empty();

                    result.data.forEach(function(iterator) {
                        $("#addPersonnelDepartment").append(`<option value="${iterator.id}">${iterator.name}</option>`)
                    });
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.log(jqXHR);
            }
        });
    }












    var defaultSelectedDepartment = 'All';
    var defaultSelectedLocation = 'All';

    // PERSONNEL FILTER BUTTON
    $('#filterBtn').click(function() {
        if ($("#personnelBtn").hasClass("active")) {
            $("#filterPersonnelModal").modal('show');
        }
    });

    $("#filterPersonnelModal").on('show.bs.modal', function(e) {

        // Storing the current selected values in the following code below.
        var previousSelectedDepartment = defaultSelectedDepartment;
        var previousSelectedLocation = defaultSelectedLocation;

        $('#filterPersonnelByDepartment').empty().append('<option value="All">All</option>');

        $('#filterPersonnelByLocation').empty().append('<option value="All">All</option>');


        $.ajax({
            url: 'libs/php/filterDepartmentsAndLocations.php',
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                if (result.status.code === '200') {
                    var departments = result.data.departments;
                    var locations = result.data.locations;

                    departments.forEach(function(department) {
                        $('#filterPersonnelByDepartment').append($('<option>', {
                            value: department.id,
                            text: department.name
                        }));
                    });

                    locations.forEach(function(location) {
                        $('#filterPersonnelByLocation').append($('<option>', {
                            value: location.id,
                            text: location.name
                        }));
                    });

                    // Setting the previously selected values back
                    $('#filterPersonnelByDepartment').val(previousSelectedDepartment);
                    $('#filterPersonnelByLocation').val(previousSelectedLocation);

                } else {
                    console.error('Error getting departments and locations:', result.status.description);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', errorThrown);
            }
        });
    });


    $('#filterPersonnelByDepartment').on('change', function() {
        defaultSelectedDepartment = $(this).val();
        // Resets location to default value of 'All' when department changes
        defaultSelectedLocation = 'All';
        $('#filterPersonnelByLocation').val('All');
    });


    $('#filterPersonnelByLocation').on('change', function() {
        defaultSelectedLocation = $(this).val();
        // Resets department to default value of 'All' when location changes
        defaultSelectedDepartment = 'All';
        $('#filterPersonnelByDepartment').val('All');
    });


    $('#filterPersonnelByDepartment').on('change', function() {

        var query = $(this).find(":selected").text();

        filterTableByDepartment(query);

        if (query !== 'All') {
            $('#filterPersonnelByLocation option[value="All"]').remove();
        }
    });

    $('#filterPersonnelByLocation').on('change', function() {

        var query = $(this).find(":selected").text();

        filterTableByLocation(query);

        if (query !== 'All') {
            $('#filterPersonnelByDepartment option[value="All"]').remove();
        }
    });

    // GET DEPARTMENT TEXT
    function filterTableByDepartment(query) {
        $.each($('#personnelResults').find('tr'), function() {
            var words = $(this).find('.personnelDepartmentCol').text();
            if (query === 'All' || words.indexOf(query) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // GET FILTER TEXT
    function filterTableByLocation(query) {
        $.each($('#personnelResults').find('tr'), function() {
            var words = $(this).find('.personnelLocationCol').text();
            if (query === 'All' || words.indexOf(query) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $("#filterPersonnelByDepartment").change(function() {
        if (this.value > 0) {
            $("#filterPersonnelByLocation").val(0);
        }

        if ($('#filterPersonnelByLocation option[value="0"]').length === 0) {

            $('#filterPersonnelByLocation').prepend('<option value="0">All</option>');
        }
    });

    $("#filterPersonnelByLocation").change(function() {
        if (this.value > 0) {
            $("#filterPersonnelByDepartment").val(0);
        }

        if ($('#filterPersonnelByDepartment option[value="0"]').length === 0) {

            $('#filterPersonnelByDepartment').prepend('<option value="0">All</option>');
        }
    });







    // REFRESH PERSONNEL BUTTON

    $("#refreshBtn").click(function() {

        if ($("#personnelBtn").hasClass("active")) {

            $("#searchInp").val('');

            //refreshes the filter button selects
            defaultSelectedDepartment = 'All';
            defaultSelectedLocation = 'All';

            refreshPersonnelTable();
        }
    });







    /*----------------------------------------END OF PERSONNEL SECTION---------------------------------------------*/


    /*--------------------------------------------------DEPARTMENT SECTION----------------------------------------------*/

    //refresh departments table
    function refreshDepartmentTable() {
        $.ajax({
            url: "libs/php/getAllDepartmentsAndLocations.php",
            type: 'GET',
            dataType: 'json',
            success: function(result) {

                console.log(JSON.stringify(result));

                if (result.status.name == "ok") {

                    $("#departmentResults").empty();

                    var rows = "";

                    result.data.forEach(function(iterator) {

                        rows += `
                        <tr>

                            <td class="align-middle text-nowrap department">${iterator.department}</td>

                            <td class="align-middle text-nowrap d-none d-md-table-cell">${iterator.location}</td>

                            <td class="align-middle text-end text-nowrap">

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editDepartmentModal" data-id="${iterator.id}" data-name="${iterator.department}">
                                    <i class="fa-solid fa-pencil fa-fw"></i>
                                </button>

                                <button type="button" class="btn btn-primary btn-sm deleteDepartmentBtn" data-id="${iterator.id}" data-name="${iterator.department}">
                                    <i class="fa-solid fa-trash fa-fw"></i>
                                </button>

                            </td>

                        </tr>`;
                    });

                    $("#departmentResults").append(rows);

                    deleteDepartmentFunction();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            }
        });

    }



    function deleteDepartmentFunction() {

        $(".deleteDepartmentBtn").off().click(function() {

            var departmentID = $(this).attr("data-id");

            var departmentName = $(this).attr("data-name");

            $.ajax({
                url: "libs/php/checkDepartment.php",
                type: "POST",
                dataType: "json",
                data: {
                    id: departmentID
                },

                success: function(result) {

                    if (result.status.code == 200) {

                        if (result.data[0].personnelCount == 0) {
                            $("#deleteDepartmentModal").modal("show");
                            $("#deleteDepartmentName").text(departmentName);

                        } else {

                            $("#departmentName").text(departmentName);
                            $("#personnelEmployees").text(result.data[0].personnelCount);
                            $("#cantDeleteDepartmentModal").modal("show");
                        }

                        $("#deleteDepartmentBtn").off().click(function() {

                            $.ajax({
                                url: "libs/php/deleteDepartmentByID.php",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    id: departmentID
                                },

                                success: function(result) {

                                    if (result.status.code == 200) {

                                        console.log("Department deleted successfully.");

                                        refreshDepartmentTable();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("AJAX Error:", errorThrown);
                                }
                            });
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", errorThrown);
                }
            });
        });
    }

    //refreshes departments tab
    $("#departmentsBtn").click(function() {

        $("#searchInp").val('');

        refreshDepartmentTable();
    });


    refreshDepartmentTable();



    $("#editDepartmentModal").on("show.bs.modal", function(e) {

        $.ajax({
            url: "libs/php/getDepartmentByID.php",
            type: "GET",
            dataType: "json",
            data: {
                id: $(e.relatedTarget).attr("data-id")
            },
            success: function(result) {

                var resultCode = result.status.code;

                if (resultCode == 200) {

                    $("#editDepartmentID").val(result.data.department[0].id);

                    $("#editDepartmentName").val(result.data.department[0].name);

                    $("#editDepartmentLocation").html("");

                    $.each(result.data.locations, function() {

                        $("#editDepartmentLocation").append(
                            $("<option>", {
                                value: this.id,
                                text: this.name
                            })
                        );
                    });

                    $("#editDepartmentLocation").val(result.data.department[0].locationID);

                } else {

                    $("#editDepartmentModal .modal-title").text("Error retrieving data");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $("#editDepartmentModal .modal-title").text("Error retrieving data");
            }
        });
    });



    $('#editDepartmentForm').on('submit', function(e) {
        e.preventDefault();

        var departmentData = {

            id: $('#editDepartmentID').val(),

            name: $('#editDepartmentName').val(),

            locationID: $('#editDepartmentLocation').val()

        };


        $.ajax({
            url: 'libs/php/updateDepartmentByID.php',
            type: 'POST',
            dataType: 'json',
            data: departmentData,
            success: function(result) {

                console.log(result);

                if (result.status.code === '200') {

                    console.log('Department updated successfully.');

                    $('#editDepartmentModal').modal('hide');

                    refreshDepartmentTable();

                } else {

                    console.error('Error updating department:', result.status.description);
                }
            },

            error: function(jqXHR, textStatus, errorThrown) {

                console.error('AJAX Error:', errorThrown);
            }
        });
    });


    $("#addDepartmentModal").on('show.bs.modal', function(e) {

        $('#addDepartmentForm')[0].reset();

        refreshDepartmentLocations();

    });


    $("#addBtn").click(function() {
        if ($("#departmentsBtn").hasClass("active")) {

            $("#addDepartmentModal").modal("show");
        }
    });

    $('#addDepartmentForm').on('submit', function(e) {
        e.preventDefault();

        var departmentData = {
            name: $('#addDepartmentName').val(),
            locationID: $('#addDepartmentLocation').val()
        };

        $.ajax({
            url: 'libs/php/insertDepartment.php',
            type: 'POST',
            dataType: 'json',
            data: departmentData,

            success: function(result) {

                console.log(result);

                if (result.status.code === '200') {

                    console.log('Department added successfully.');

                    $("#addDepartmentModal").modal("hide");

                    refreshDepartmentTable();

                    refreshDepartmentLocations();

                } else {
                    console.error('Error adding department:', result.status.description);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', errorThrown);
            }
        });
    });



    function refreshDepartmentLocations() {

        $.ajax({
            url: "libs/php/getAllLocations.php",
            type: 'GET',
            dataType: 'json',
            success: function(result) {

                console.log(JSON.stringify(result));

                if (result.status.name == "ok") {

                    $("#addDepartmentLocation").empty();

                    result.data.forEach(function(iterator) {
                        $("#addDepartmentLocation").append(`<option value="${iterator.id}">${iterator.name}</option>`);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            }
        });
    }



    // REFRESH DEPARTMENTS BUTTON

    $("#refreshBtn").click(function() {
        if ($("#departmentsBtn").hasClass("active")) {
            $("#searchInp").val('');
            refreshDepartmentTable();
        }
    });






    /*--------------------------------------------END OF DEPARTMENT SECTION----------------------------------------------*/


    /*--------------------------------------------LOCATION SECTION----------------------------------------------*/


    //refresh location table
    function refreshLocationTable() {
        $.ajax({
            url: "libs/php/getAllLocations.php",
            type: 'GET',
            dataType: 'json',
            success: function(result) {

                console.log(JSON.stringify(result));

                if (result.status.name == "ok") {

                    $("#locationResults").empty();

                    var rows = "";

                    result.data.forEach(function(iterator) {

                        rows += `

                        <tr>

                            <td class="align-middle text-nowrap">${iterator.name}</td>

                            <td class="align-middle text-end text-nowrap">

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editLocationModal" data-id="${iterator.id}" data-name="${iterator.name}">
                                    <i class="fa-solid fa-pencil fa-fw"></i>
                                </button>

                                <button type="button" class="btn btn-primary btn-sm deleteLocationBtn" data-id="${iterator.id}" data-name="${iterator.name}">
                                    <i class="fa-solid fa-trash fa-fw"></i>
                                </button>

                            </td>

                        </tr>`;
                    });


                    $("#locationResults").append(rows);

                    deleteLocationFunction();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', errorThrown);
            }
        });
    }



    function deleteLocationFunction() {

        $(".deleteLocationBtn").off().click(function() {

            var locationID = $(this).attr("data-id");
            var locationName = $(this).attr("data-name");

            $.ajax({
                url: "libs/php/checkLocation.php",
                type: "POST",
                dataType: "json",
                data: {
                    id: locationID
                },

                success: function(result) {

                    if (result.status.code == 200) {

                        if (result.data[0].departmentCount == 0) {
                            $("#deleteLocationModal").modal("show");
                            $("#deleteLocationName").text(locationName);

                        } else {

                            $("#locationName").text(locationName);
                            $("#departmentDepartments").text(result.data[0].departmentCount);
                            $("#cantDeleteLocationModal").modal("show");
                        }

                        $("#deleteLocationBtn").off().click(function() {

                            $.ajax({
                                url: "libs/php/deleteLocationByID.php",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    id: locationID
                                },

                                success: function(result) {
                                    if (result.status.code == 200) {
                                        console.log("Location deleted successfully.");
                                        refreshLocationTable();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("AJAX Error:", errorThrown);
                                }
                            });
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", errorThrown);
                }
            });
        });
    }

    //refreshes location tab
    $("#locationsBtn").click(function() {

        $("#searchInp").val('');

        refreshLocationTable();
    });


    refreshLocationTable();



    $("#editLocationModal").on("show.bs.modal", function(e) {

        $.ajax({
            url: "libs/php/getLocationByID.php",
            type: "GET",
            dataType: "json",
            data: {
                id: $(e.relatedTarget).attr("data-id")
            },
            success: function(result) {

                var resultCode = result.status.code;

                if (resultCode == 200) {

                    $("#editLocationID").val(result.data[0].id);

                    $("#editLocationName").val(result.data[0].name);

                } else {

                    $("#editLocationModal .modal-title").text("Error retrieving data");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $("#editLocationModal .modal-title").text("Error retrieving data");
            }
        });
    });





    $('#editLocationForm').on('submit', function(e) {

        e.preventDefault();

        var locationData = {

            id: $('#editLocationID').val(),

            name: $('#editLocationName').val()

        };

        $.ajax({
            url: 'libs/php/updateLocationByID.php',
            type: 'POST',
            dataType: 'json',
            data: locationData,
            success: function(result) {


                console.log(result);

                if (result.status.code === '200') {

                    console.log('Location updated successfully.');

                    $('#editLocationModal').modal('hide');

                    refreshLocationTable();

                } else {

                    console.error('Error updating location:', result.status.description);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error('AJAX Error:', errorThrown);
            }
        });
    });







    $("#addBtn").click(function() {
        if ($("#locationsBtn").hasClass("active")) {
            // resets the form so previous data is not there when you add another location.
            $('#addLocationForm')[0].reset();
            $("#addLocationModal").modal("show");
        }
    });


    $('#addLocationForm').on('submit', function(e) {

        e.preventDefault();

        var locationData = {

            name: $('#addLocation').val()

        };


        $.ajax({
            url: 'libs/php/insertLocation.php',
            type: 'POST',
            dataType: 'json',
            data: locationData,
            success: function(result) {


                console.log(result);

                if (result.status.code === '200') {

                    console.log('Location added successfully.');

                    $("#addLocationModal").modal("hide");

                    refreshLocationTable();

                } else {

                    console.error('Error adding location:', result.status.description);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error('AJAX Error:', errorThrown);
            }
        });
    });



    // REFRESH LOCATIONS BUTTON

    $("#refreshBtn").click(function() {
        if ($("#locationsBtn").hasClass("active")) {
            $("#searchInp").val('');
            refreshLocationTable();

        }
    });



    /*--------------------------------------------END OF LOCATION SECTION----------------------------------------------*/

    /*-------------------------------------------------- OTHER ---------------------------------------------------*/

    // SEARCH BAR CODE
    $("#searchInp").on("keyup", function(e) {
        e.preventDefault();

        var letters = $(this).val().toLowerCase();

        $.ajax({
            url: 'libs/php/SearchAll.php',
            type: 'GET',
            dataType: 'json',
            data: {
                txt: letters
            },
            success: function(result) {

                if (result.status.code === '200') {

                    $('tr').hide().filter(function() {

                        var words = $(this).find('td').text().toLowerCase();

                        return words.indexOf(letters) !== -1;

                    }).show();

                } else {

                    console.log('No results found or error occurred.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error('AJAX error:', textStatus, errorThrown);
            }
        });
    });

    /*-------------------------------------------------- OTHER ---------------------------------------------------*/




});