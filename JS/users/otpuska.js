// Define an array to store changes
var changesArray = [];

function changeDays(compensationId, operator, year) {
    var daysElement = document.getElementById('days-' + compensationId);
    var currentDays = parseInt(daysElement.innerText) || 0;

    if (operator === '+') {
        currentDays++;
    } else if (operator === '-') {
        currentDays = Math.max(0, currentDays - 1);
    }

    daysElement.innerText = currentDays;

    // Add changes to the array
    changesArray.push({
        compensationId: compensationId,
        updatedDays: currentDays,
        year: year
    });
}

function saveChanges() {
    // Create a form dynamically
    var form = document.createElement('form');
    form.method = 'post';
    form.action = 'editOtpusk';

    // Create a hidden input field for the changes array
    var inputChanges = document.createElement('input');
    inputChanges.type = 'hidden';
    inputChanges.name = 'changesArray';
    inputChanges.value = JSON.stringify(changesArray);

    // Append input fields to the form
    form.appendChild(inputChanges);

    // Append the form to the document body
    document.body.appendChild(form);


    // Submit the form
    form.submit();
}
