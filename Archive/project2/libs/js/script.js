$(document).ready( () => {
  getEmployees()
  getDepartments()
  getLocations()
});

const employeeTable = $('#employee-table');
const departmentTable = $('#department-table');
const locationTable = $('#location-table');
const searchBar = $('#search-bar')

const getEmployees = () => {
    $.ajax({
      url: "libs/php/getEmployees.php",
      type: "POST",
      dataType: "json",
      success: result => {
        if (result.status.name == "ok") {

          const employees = result.data
          const employeeList = document.getElementById('employee-list')
          const employeeFragment = new DocumentFragment()

          employees.map(employee => {
            let id = 'e' + employee.id;
        
            let tr = document.createElement('tr');
            tr.id = id;
        
            let name = document.createElement('td');
            name.innerHTML = `${employee.lastName}, ${employee.firstName}`;
            name.classList = 'name align-middle';
        
            let role = document.createElement('td');
            role.innerHTML = employee.jobTitle;
            role.classList = 'role align-middle d-none d-md-table-cell';
        
            let email = document.createElement('td');
            email.innerHTML = employee.email;
            email.classList = 'email align-middle d-none d-lg-table-cell';
        
            let department = document.createElement('td');
            department.innerHTML = employee.department;
            department.classList = 'department align-middle d-none d-md-table-cell';
            department.setAttribute('data-departmend-id', employee.departmentID)
        
            let location = document.createElement('td');
            location.innerHTML = employee.location;
            location.classList = 'location align-middle d-none d-lg-table-cell';
        
            let updateButtonCell = document.createElement('td');
            updateButtonCell.classList = 'align-middle row-button';
            let updateButton = document.createElement('button');
            updateButton.classList = 'update-employee-button btn btn-info text-white';
            updateButtonCell.append(updateButton);
            let updateButtonIcon = document.createElement('i');
            updateButtonIcon.classList = 'fa-solid fa-user-pen';
            updateButton.append(updateButtonIcon);
        
            let deleteButtonCell = document.createElement('td');
            deleteButtonCell.classList = 'align-middle row-button';
            let deleteButton = document.createElement('button');
            deleteButton.classList = 'delete-employee-button btn btn-danger';
            deleteButtonCell.append(deleteButton)
            let deleteButtonIcon = document.createElement('i');
            deleteButtonIcon.classList = 'fa-solid fa-user-slash';
            deleteButton.append(deleteButtonIcon);
        
            tr.append(name, role, email, department, location, updateButtonCell, deleteButtonCell)
        
            employeeFragment.append(tr)
          })
          employeeList.replaceChildren(employeeFragment);
          $('.update-employee-button').on('click', () => {openUpdateEmployeeModal()});
          $('.delete-employee-button').on('click', () => {openDeleteEmployeeModal()});
          $('#search-bar').val('');
          $(".fade-me").addClass("d-none");
        }
      },
      error: (errorThrown) => {
        console.log(errorThrown);
      },
    });
  };

const showEmployees = () => {
  getEmployees();
  employeeTable.removeClass('d-none')
  departmentTable.addClass('d-none')
  locationTable.addClass('d-none')
  searchBar.removeClass('d-none')
}

const getDepartments = () => {
  $.ajax({
    url: "libs/php/getDepartments.php",
    type: "POST",
    dataType: "json",
    success: result => {
      if (result.status.name == "ok") {

        const departments = result.data

        const departmentList = document.getElementById('department-list');
        const departmentFragment = new DocumentFragment()

        const createEmployeeOptions = document.getElementById('new-employee-department');
        const createEmployeeOptionsFragment = new DocumentFragment();

        const updateEmployeeOptions = document.getElementById('employee-department');
        const updateEmployeeOptionsFragment = new DocumentFragment();

        departments.map(department => {
          let id = 'd' + department.id

          let tr = document.createElement('tr');
          tr.id = id;

          let departmentName = document.createElement('td');
          departmentName.innerHTML = department.name;
          departmentName.classList = 'align-middle department-name';

          let location = document.createElement('td')
          location.innerHTML = department.location;
          location.classList = 'align-middle location';
          location.setAttribute('data-location-id', department.locationId)

          let updateButtonCell = document.createElement('td');
          updateButtonCell.classList = 'align-middle row-button';
          let updateButton = document.createElement('button');
          updateButton.classList = 'update-department-button btn btn-info text-white';
          updateButtonCell.append(updateButton);
          let updateButtonIcon = document.createElement('i');
          updateButtonIcon.classList = 'fa-solid fa-pen-to-square';
          updateButton.append(updateButtonIcon);

          let deleteButtonCell = document.createElement('td');
          deleteButtonCell.classList = 'align-middle row-button';
          let deleteButton = document.createElement('button');
          deleteButton.classList = 'delete-department-button btn btn-danger';
          deleteButtonCell.append(deleteButton)
          let deleteButtonIcon = document.createElement('i');
          deleteButtonIcon.classList = 'fa-solid fa-delete-left';
          deleteButton.append(deleteButtonIcon);

          tr.append(departmentName,location, updateButtonCell, deleteButtonCell);

          departmentFragment.append(tr)

          let createEmployeeOption = document.createElement('option');
          createEmployeeOption.innerHTML = department.name;
          createEmployeeOption.setAttribute('value', department.id);

          createEmployeeOptionsFragment.append(createEmployeeOption);

          let updateEmployeeOption = document.createElement('option');
          updateEmployeeOption.innerHTML = department.name;
          updateEmployeeOption.setAttribute('value', department.id);

          updateEmployeeOptionsFragment.append(updateEmployeeOption);

        })
        departmentList.replaceChildren(departmentFragment);
        $('.update-department-button').on('click', () => {openUpdateDepartmentModal()});
        $('.delete-department-button').on('click', () => {openDeleteDepartmentModal()});

        createEmployeeOptions.replaceChildren(createEmployeeOptionsFragment);

        updateEmployeeOptions.replaceChildren(updateEmployeeOptionsFragment);

      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  })
};

const showDepartments = () => {
  getDepartments();
  departmentTable.removeClass('d-none')
  employeeTable.addClass('d-none')
  locationTable.addClass('d-none')
  searchBar.addClass('d-none')
}

const getLocations = () => {
  $.ajax({
    url: "libs/php/getLocations.php",
    type: "POST",
    dataType: "json",
    success: result => {
      if (result.status.name == "ok") {


        let locations = result.data

        const locationList = document.getElementById('location-list');
        const locationFragment = new DocumentFragment();

        const createDepartmentOptions = document.getElementById('new-department-location');
        const createDepartmentOptionsFragment = new DocumentFragment();

        const updateDepartmentOptions = document.getElementById('department-location');
        const updateDepartmentOptionsFragment = new DocumentFragment();
        
        locations.map(location => {
          let id = 'l' + location.id

          let tr = document.createElement('tr');
          tr.id = id;

          let locationName = document.createElement('td');
          locationName.innerHTML = location.name;
          locationName.classList = 'align-middle location-name';

          let updateButtonCell = document.createElement('td');
          updateButtonCell.classList = 'align-middle row-button';
          let updateButton = document.createElement('button');
          updateButton.classList = 'update-location-button btn btn-info text-white';
          updateButtonCell.append(updateButton);
          let updateButtonIcon = document.createElement('i');
          updateButtonIcon.classList = 'fa-solid fa-pen-to-square';
          updateButton.append(updateButtonIcon);

          let deleteButtonCell = document.createElement('td');
          deleteButtonCell.classList = 'align-middle row-button';
          let deleteButton = document.createElement('button');
          deleteButton.classList = 'delete-location-button btn btn-danger';
          deleteButtonCell.append(deleteButton)
          let deleteButtonIcon = document.createElement('i');
          deleteButtonIcon.classList = 'fa-solid fa-delete-left';
          deleteButton.append(deleteButtonIcon);

          tr.append(locationName, updateButtonCell, deleteButtonCell);

          locationFragment.append(tr);

          let createDepartmentOption = document.createElement('option');
          createDepartmentOption.innerHTML = location.name;
          createDepartmentOption.setAttribute('value', location.id);

          createDepartmentOptionsFragment.append(createDepartmentOption);

          let updateDepartmentOption = document.createElement('option');
          updateDepartmentOption.innerHTML = location.name;
          updateDepartmentOption.setAttribute('value', location.id);

          updateDepartmentOptionsFragment.append(updateDepartmentOption);
        })
        locationList.replaceChildren(locationFragment);
        $('.update-location-button').on('click', () => {openUpdateLocationModal()});
        $('.delete-location-button').on('click', () => {openDeleteLocationModal()});

        createDepartmentOptions.replaceChildren(createDepartmentOptionsFragment);

        updateDepartmentOptions.replaceChildren(updateDepartmentOptionsFragment);

      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  })
};

const showLocations = () => {
  getLocations();
  locationTable.removeClass('d-none')
  employeeTable.addClass('d-none')
  departmentTable.addClass('d-none')
  searchBar.addClass('d-none')
}

// Create Emplpoyee
const createEmployee = () => {
  const firstName = $('#new-employee-forename').val()
  const lastName = $('#new-employee-surname').val()
  const jobTitle = $('#new-employee-role').val()
  const email = $('#new-employee-email').val()
  const departmentID = $('#new-employee-department').val()
  $.ajax({
    url: "libs/php/createEmployee.php",
    type: "POST",
    dataType: "json",
    data: {
      firstName: firstName,
      lastName: lastName,
      jobTitle: jobTitle,
      email: email,
      departmentID: departmentID
    },
    success: result => {
      if (result.status.name == "ok") {
        closeCreateEmployeeModal();
        $('#toast-title').text('Employee created successfully');
        $('#toast-message').text(`${firstName} ${lastName}`);
        $('#toast-alert').show();
        getEmployees();
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
  
};

const createEmployeeModal = $('#create-employee-modal')

const openCreateEmployeeModal = () => {
  createEmployeeModal.find('.btn-primary').addClass('disabled')
  $('.form-control').next('p').addClass('d-none')
  createEmployeeModal.find('.form-control').removeClass('valid')
  createEmployeeModal.find('select').addClass('valid')
  clearCreateEmployeeValues();
  createEmployeeModal.modal("show");
}

const closeCreateEmployeeModal = () => {
  createEmployeeModal.modal("hide")
}

const clearCreateEmployeeValues = () => {
  $('#new-employee-forename').val('')
  $('#new-employee-surname').val('')
  $('#new-employee-role').val('')
  $('#new-employee-email').val('')
}

// Update Employee
let employeeId = "";

const updateEmployee = () => {
  const firstName = $('#employee-forename').val()
  const lastName = $('#employee-surname').val()
  const jobTitle = $('#employee-role').val()
  const email = $('#employee-email').val()
  const departmentID = $('#employee-department').val()
  $.ajax({
    url: "libs/php/updateEmployee.php",
    type: "POST",
    dataType: "json",
    data: {
      id: employeeId.substring(1),
      firstName: firstName,
      lastName: lastName,
      jobTitle: jobTitle,
      email: email,
      departmentID: departmentID
    },
    success: result => {
      if (result.status.name == "ok") {
        closeUpdateEmployeeModal();
        $('#toast-title').text('Employee updated successfully')
        $('#toast-message').text(`${firstName} ${lastName}`)
        $('#toast-alert').show()
        getEmployees()
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
};

const updateEmployeeModal = $('#update-employee-modal');

const openUpdateEmployeeModal = () => {
  const obj = event.target;
  employeeId = $(obj).closest('tr').attr('id')

  $.ajax({ 
    url: "libs/php/getEmployeeByID.php",
    type: "POST",
    dataType: "json",
    data: {
      id: employeeId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        const employee = result.data.personnel[0]
        $('#employee-forename').val(employee.firstName)
        $('#employee-surname').val(employee.lastName)
        $('#employee-role').val(employee.jobTitle)
        $('#employee-email').val(employee.email)
        $('#employee-department').val(employee.departmentID)

      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });

  $('.form-control').next('p').addClass('d-none')
  updateEmployeeModal.find('.form-control').removeClass('valid')
  updateEmployeeModal.find('.form-control').each(function() {
    if($(this).val() != '') {
      $(this).addClass('valid')
    }
  })
  
  updateEmployeeModal.modal("show");
}

const closeUpdateEmployeeModal = () => {
  updateEmployeeModal.modal("hide")
}

// Delete Employee
const deleteEmployee = () => {
  const name = $(`#${employeeId}`).children('.name').html()
  $.ajax({
    url: "libs/php/deleteEmployee.php",
    type: "POST",
    dataType: "json",
    data: {
      id: employeeId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        closeDeleteEmployeeModal()
        $('#toast-title').text('Employee removed successfully')
        $('#toast-message').text(name)
        $('#toast-alert').show()
        getEmployees()
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
};

const deleteEmployeeModal = $('#delete-employee-modal');

const openDeleteEmployeeModal = () => {
  const obj = event.target
  employeeId = $(obj).closest('tr').attr('id')
  const name = $(obj).closest('tr').children('.name').html();
  $('#delete-employee-modal-body').text(`Are you sure you wish to remove ${name} permanently?`)
  deleteEmployeeModal.modal("show");
}

const closeDeleteEmployeeModal = () => {
  deleteEmployeeModal.modal("hide")
}

// Create Department
const createDepartment = () => {
  const name = $('#new-department-name').val()
  const locationID = $('#new-department-location').val()
  const rows = document.querySelector("#department-table tbody").rows;
  const matchingDepartments = [];
  for (let i = 0; i < rows.length; i++) {
    const department = rows[i].cells[0].textContent;
    matchingDepartments.push(department)
  } 
  if(!matchingDepartments.includes(name)){
    $.ajax({
      url: "libs/php/createDepartment.php",
      type: "POST",
      dataType: "json",
      data: {
        name: name,
        locationID: locationID,
      },
      success: result => {
        if (result.status.name == "ok") {
          closeCreateDepartmentModal();
          $('#toast-title').text('Department created successfully');
          $('#toast-message').text(`${name}`);
          $('#toast-alert').show();
          getDepartments();
        }
      },
      error: (errorThrown) => {
        console.log(errorThrown);
      },
    });
  } else {
    $('#alert-message').text(`It was not possible to create ${name} because a department with this name already exists.`);
    $('#alert-list').empty();
    closeCreateDepartmentModal()
    openAlertModal()
  }
};

const createDepartmentModal = $('#create-department-modal')

const openCreateDepartmentModal = () => {
  createDepartmentModal.find('.btn-primary').addClass('disabled')
  $('.form-control').next('p').addClass('d-none')
  createDepartmentModal.find('.form-control').removeClass('valid')
  createDepartmentModal.find('select').addClass('valid')

  clearCreateDepartmentValues();
  createDepartmentModal.modal("show");
}

const closeCreateDepartmentModal = () => {
  createDepartmentModal.modal("hide");
}

const clearCreateDepartmentValues = () => {
  $('#new-department-name').val('')
}

// Update Department
let departmentId = "";

const updateDepartment = () => {
  const name = $('#department-name').val()
  const currentName = $(`#${departmentId}`).children('.department-name').html()
  const locationID = $('#department-location').val()
  const rows = document.querySelector("#employee-table tbody").rows;
  const matchingEmployees = [];
  for (let i = 0; i < rows.length; i++) {
    const firstName = rows[i].cells[0].textContent;
    const lastName = rows[i].cells[1].textContent;
    const department = rows[i].cells[4].textContent;
    if (currentName == department) {
      matchingEmployees.push(`${firstName} ${lastName}`)
    }
  }
  if(matchingEmployees.length == 0) {
    $.ajax({
      url: "libs/php/updateDepartment.php",
      type: "POST",
      dataType: "json",
      data: {
        id: departmentId.substring(1),
        name: name,
        locationID: locationID,
      },
      success: result => {
        if (result.status.name == "ok") {
          closeUpdateDepartmentModal();
          $('#toast-title').text('Department updated successfully')
          $('#toast-message').text(`${name}`)
          $('#toast-alert').show()
          getDepartments()
        }
      },
      error: (errorThrown) => {
        console.log(errorThrown);
      },
    });
  } else {
    $('#alert-message').text(`It was not possible to edit ${currentName} because the following employee(s) work at this department:`);
    $('#alert-list').empty();
    matchingEmployees.map(employee => {
      $('#alert-list').append(`<li>${employee}</li>`)
    })
    closeUpdateDepartmentModal()
    openAlertModal()
  }
};

const updateDepartmentModal = $('#update-department-modal');

const openUpdateDepartmentModal = () => {
  const obj = event.target;
  departmentId = $(obj).closest('tr').attr('id')

  $.ajax({ 
    url: "libs/php/getDepartmentByID.php",
    type: "POST",
    dataType: "json",
    data: {
      id: departmentId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        const department = result.data.department[0];
        $('#department-name').val(department.name)
        $('#department-location').val(department.locationId) 
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
  
  $('.form-control').next('p').addClass('d-none')
  updateDepartmentModal.find('.form-control').removeClass('valid')
  updateDepartmentModal.find('.form-control').each(function() {
    if($(this).val() != '') {
      $(this).addClass('valid')
    }
  })
  
  updateDepartmentModal.modal("show");
}

const closeUpdateDepartmentModal = () => {
  updateDepartmentModal.modal("hide")
}

// Delete Department
const deleteDepartment = () => {
  const name = $(`#${departmentId}`).children('.department-name').html()
  $.ajax({
    url: "libs/php/deleteDepartment.php",
    type: "POST",
    dataType: "json",
    data: {
      id: departmentId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        closeDeleteDepartmentModal()
        $('#toast-title').text('Department removed successfully')
        $('#toast-message').text(`${name}`)
        $('#toast-alert').show()
        getDepartments()
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
};

const deleteDepartmentModal = $('#delete-department-modal');

const openDeleteDepartmentModal = () => {
  const obj = event.target;
  departmentId = $(obj).closest('tr').attr('id')

  $.ajax({
    url: "libs/php/countEmployees.php",
    type: "POST",
    dataType: "json",
    data: {
      id: departmentId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        const employeeCount = result.data.employeeCount[0].ec;
        const name = $(obj).closest('tr').children('.department-name').html();

        if (employeeCount == 0) {
          $('#delete-department-modal-body').text(`Are you sure you wish to remove ${name} permanently?`);
          deleteDepartmentModal.modal("show");
        } else {
          $('#alert-message').text(`It is not possible to delete ${name} because ${employeeCount} employee(s) work at this department.`);
          closeDeleteDepartmentModal()
          openAlertModal()
        }
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
};

const closeDeleteDepartmentModal = () => {
  deleteDepartmentModal.modal("hide")
};

// Create Location
const createLocation = () => {
  const name = $('#new-location-name').val()
  const rows = document.querySelector("#location-table tbody").rows;
  const matchingLocations = [];
  for (let i = 0; i < rows.length; i++) {
    const location = rows[i].cells[0].textContent;
    matchingLocations.push(location)
  } 

  if(!matchingLocations.includes(name)){
    $.ajax({
      url: "libs/php/createLocation.php",
      type: "POST",
      dataType: "json",
      data: {
        name: name,
      },
      success: result => {
        if (result.status.name == "ok") {
          closeCreateLocationModal();
          $('#toast-title').text('Location created successfully');
          $('#toast-message').text(`${name}`);
          $('#toast-alert').show();
          getLocations();
        }
      },
      error: (errorThrown) => {
        console.log(errorThrown);
      },
    });
  } else {
    $('#alert-message').text(`It was not possible to create ${name} because a location with this name already exists.`);
    $('#alert-list').empty();
    closeCreateLocationModal()
    openAlertModal()
  }
};

const createLocationModal = $('#create-location-modal')

const openCreateLocationModal = () => {
  createLocationModal.find('.btn-primary').addClass('disabled')
  $('.form-control').next('p').addClass('d-none')
  createLocationModal.find('.form-control').removeClass('valid')
  createLocationModal.find('select').addClass('valid')

  clearCreateLocationValues();
  createLocationModal.modal("show");
}

const closeCreateLocationModal = () => {
  createLocationModal.modal("hide");
}

const clearCreateLocationValues = () => {
  $('#new-location-name').val('')
}

// Update Location
let locationId = "";

const updateLocation = () => {
  const name = $('#location-name').val();

  $.ajax({
    url: "libs/php/updateLocation.php",
    type: "POST",
    dataType: "json",
    data: {
      id: locationId.substring(1),
      name: name,
    },
    success: result => {
      if (result.status.name == "ok") {
        closeUpdateLocationModal();
        $('#toast-title').text('Location updated successfully')
        $('#toast-message').text(`${name}`)
        $('#toast-alert').show()
        getLocations()
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });

}

const updateLocationModal = $('#update-location-modal');
  
const openUpdateLocationModal = () => {
  const obj = event.target;
  locationId = $(obj).closest('tr').attr('id')

  $.ajax({ 
    url: "libs/php/getLocationByID.php",
    type: "POST",
    dataType: "json",
    data: {
      id: locationId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        const location = result.data.location[0];
        $('#location-name').val(location.name)
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });

  $('.form-control').next('p').addClass('d-none')
  updateLocationModal.find('.form-control').removeClass('valid')
  updateLocationModal.find('.form-control').each(function() {
    if($(this).val() != '') {
      $(this).addClass('valid')
    }
  })

  updateLocationModal.modal("show");
}

const closeUpdateLocationModal = () => {
  updateLocationModal.modal("hide")
}

// Delete Location 
const deleteLocation = () => {
  const name = $(`#${locationId}`).children('.location-name').html();

  $.ajax({
    url: "libs/php/deleteLocation.php",
    type: "POST",
    dataType: "json",
    data: {
      id: locationId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        closeDeleteLocationModal()
        $('#toast-title').text('Location removed successfully')
        $('#toast-message').text(`${name}`)
        $('#toast-alert').show()
        getLocations()
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });
};

const deleteLocationModal = $('#delete-location-modal');

const openDeleteLocationModal = () => {
  const obj = event.target;
  locationId = $(obj).closest('tr').attr('id')

  $.ajax({
    url: "libs/php/countDepartments.php",
    type: "POST",
    dataType: "json",
    data: {
      id: locationId.substring(1),
    },
    success: result => {
      if (result.status.name == "ok") {
        const departmentCount = result.data.departmentCount[0].dc;
        const name = $(obj).closest('tr').children('.location-name').html();
        if (departmentCount == 0) {
          $('#delete-location-modal-body').text(`Are you sure you wish to remove ${name} permanently?`);
          deleteLocationModal.modal("show");
        } else {
          $('#alert-message').text(`It is not possible to delete ${name} because ${departmentCount} department(s) are situated at this location.`);
          closeDeleteLocationModal()
          openAlertModal()
        }

      }
    },
    error: (errorThrown) => {
      console.log(errorThrown);
    },
  });

}

const closeDeleteLocationModal = () => {
  deleteLocationModal.modal("hide")
}

// Alerts

const alertModal = $('#alert-modal');

const openAlertModal = () => {
  alertModal.modal("show");
}

const closeAlertModal = () => {
  alertModal.modal("hide")
}

// Search Results
const searchResults = event => {
  const filter = event.target.value.toUpperCase();
  const rows = document.querySelector("#employee-table tbody").rows;
  
  for (let i = 0; i < rows.length; i++) {
      const firstCol = rows[i].cells[0].textContent.toUpperCase();
      const secondCol = rows[i].cells[1].textContent.toUpperCase();
      const thirdCol = rows[i].cells[2].textContent.toUpperCase();
      const fourthCol = rows[i].cells[3].textContent.toUpperCase();
      const fifthCol = rows[i].cells[4].textContent.toUpperCase();
      const sixthCol = rows[i].cells[5].textContent.toUpperCase();
      if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1 || fifthCol.indexOf(filter) > -1 || sixthCol.indexOf(filter) > -1) {
          rows[i].style.display = "";
      } else {
          rows[i].style.display = "none";
      }      
  }
}

// Toast Alet
const closeToast = () => {
  $('#toast-alert').hide()
}

const checkValid = (elem) => {
  let validity = elem.checkValidity();
  let instructions = $(elem).next('p');
  validity ? instructions.addClass('d-none') : instructions.removeClass('d-none');
  validity ? $(elem).addClass('valid') : $(elem).removeClass('valid');
  let allValid = '';
  let booleanArray = [];
  let modal = $(elem).closest('.modal');

  modal.find('.form-control').each(function() {
    booleanArray.push($(this).hasClass('valid'))
    allValid = booleanArray.every(Boolean);
  })
  let submitButton = modal.find('.btn-primary')
  allValid ? submitButton.removeClass('disabled') : submitButton.addClass('disabled');

}

// Events
// Navbar
$('#show-employee-button').on('click', () => {showEmployees()})
$('#show-department-button').on('click', () => {showDepartments()})
$('#show-location-button').on('click', () => {showLocations()})
$('#search-bar').on('keyup', () => {searchResults(event)})
// Tables
$('#create-employee-modal-button').on('click', () => {openCreateEmployeeModal()})
$('#create-department-modal-button').on('click', () => {openCreateDepartmentModal()})
$('#create-location-modal-button').on('click', () => {openCreateLocationModal()})
//Validation
$('.form-control').on('keyup', event => {
  checkValid(event.target)
})
// Employee
$('#create-employee-button').on('click', () => {createEmployee()})
$('#close-create-employee-button').on('click', () => {closeCreateEmployeeModal()})
$('#update-employee-button').on('click', () => {updateEmployee()})
$('#close-update-employee-button').on('click', () => {closeUpdateEmployeeModal()})
$('#delete-employee-button').on('click', () => {deleteEmployee()})
$('#close-delete-employee-button').on('click', () => {closeDeleteEmployeeModal()})
// Department
$('#create-department-button').on('click', () => {createDepartment()})
$('#close-create-department-button').on('click', () => {closeCreateDepartmentModal()})
$('#update-department-button').on('click', () => {updateDepartment()})
$('#close-update-department-button').on('click', () => {closeUpdateDepartmentModal()})
$('#delete-department-button').on('click', () => {deleteDepartment()})
$('#close-delete-department-button').on('click', () => {closeDeleteDepartmentModal()})
// Location
$('#create-location-button').on('click', () => {createLocation()})
$('#close-create-location-button').on('click', () => {closeCreateLocationModal()})
$('#update-location-button').on('click', () => {updateLocation()})
$('#close-update-location-button').on('click', () => {closeUpdateLocationModal()})
$('#delete-location-button').on('click', () => {deleteLocation()})
$('#close-delete-location-button').on('click', () => {closeDeleteLocationModal()})
// Alerts
$('#close-alert-modal-button').on('click', () => {closeAlertModal()})
$('#close-toast-button').on('click', () => {closeToast()})


