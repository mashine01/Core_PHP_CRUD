function openAddEmployeePopup() {
    document.getElementById("addEmployeePopup").style.display = "inline-block";
}

function openUpdateEmployeePopup(empID) {
    document.getElementById("updateEmployeePopup").style.display = "inline-block";
    document.getElementById("updateEmployee").value = empID;
}

function closePopup() {
    document.getElementById("addEmployeePopup").style.display = "none";
    document.getElementById("updateEmployeePopup").style.display = "none";
}

function populateUpdateForm(empID, empName, empPhone, empMail) {
    document.getElementById('updateEmployee').value = empID;
    document.getElementsByName('empName')[1].value = empName;
    document.getElementsByName('empPhone')[1].value = empPhone;
    document.getElementsByName('empMail')[1].value = empMail;
    openUpdateEmployeePopup(empID);
}
