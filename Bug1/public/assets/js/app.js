document.getElementById('contactForm').onsubmit = function(event) 
{
  event.preventDefault();
  const formData = new FormData(document.getElementById('contactForm')); // BUG: Wrong form ID name

  fetch('/submit', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    document.querySelector('#response').innerHTML = data;
  })
  .catch(error => {
    document.querySelector('#response').innerHTML = 'An error occurred.';
  });
};