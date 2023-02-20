var confirmation = document.getElementById("confirmation");

// animation of order confirmed message
function showConfirmation() {
  confirmation.style.display = "block";
  setTimeout(function() {
    confirmation.style.display = "none";
  }, 5000);
}
