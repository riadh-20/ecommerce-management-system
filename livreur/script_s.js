const singialerButton = document.getElementById('singialer-button');
const formContainer = document.getElementById('form-container');
const problemForm = document.getElementById('problem-form');
const problemInput = document.getElementById('problem-input');
const consoleButton = document.getElementById('console-button');
const acceptButton = document.getElementById('accept-button');

singialerButton.addEventListener('click', () => {
  formContainer.classList.remove('hidden');
});

problemForm.addEventListener('submit', (event) => {
  event.preventDefault();
  const problem = problemInput.value;
  console.log(problem);
  problemInput.value = '';
});

consoleButton.addEventListener('click', () => {
  console.log('Console button clicked');
});

acceptButton.addEventListener('click', () => {
  const problem = problemInput.value;
  if (problem) {
    sendToDatabase(problem);
    formContainer.classList.add('hidden');
  }
});

function sendToDatabase(problem) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'send-to-database.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(`problem=${problem}`);
}