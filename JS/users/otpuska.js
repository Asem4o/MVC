// Define the input fields outside the functions
var inputCompensationId = document.createElement('input');
inputCompensationId.type = 'hidden';
inputCompensationId.name = 'compensationId';
inputCompensationId.id = 'compensationId'; // Add an ID for easy access
inputCompensationId.value = '';

var inputUpdatedDays = document.createElement('input');
inputUpdatedDays.type = 'hidden';
inputUpdatedDays.name = 'updatedDays';
inputUpdatedDays.id = 'updatedDays'; // Add an ID for easy access
inputUpdatedDays.value = '';

var inputYear = document.createElement('input');
inputYear.type = 'hidden';
inputYear.name = 'year';
inputYear.id = 'year'; // Add an ID for easy access
inputYear.value = '';

function changeDays(compensationId, operator, year) {
    var daysElement = document.getElementById('days-' + compensationId);
    var currentDays = parseInt(daysElement.innerText) || 0;

    if (operator === '+') {
        currentDays++;
    } else if (operator === '-') {
        currentDays = Math.max(0, currentDays - 1);
    }

    daysElement.innerText = currentDays;

    // Set values directly in the form
    inputCompensationId.value = compensationId;
    inputUpdatedDays.value = currentDays;
    inputYear.value = year;
}

function saveChanges() {
    // Create a form dynamically
    var form = document.createElement('form');
    form.method = 'post';
    form.action = 'editOtpusk';

    // Append input fields to the form
    form.appendChild(inputCompensationId);
    form.appendChild(inputUpdatedDays);
    form.appendChild(inputYear);

    // Append the form to the document body
    document.body.appendChild(form);

    // Debugging: Log values to the console before form submission
    console.log('Before form submission:');
    console.log('compensationId:', inputCompensationId.value);
    console.log('updatedDays:', inputUpdatedDays.value);
    console.log('year:', inputYear.value);

    form.submit();
}
