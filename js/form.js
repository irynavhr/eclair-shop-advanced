
// export function initContactFormValidation() {
//   const contactForm = document.getElementById("contactForm");
//   if (!contactForm) return;

//   contactForm.addEventListener("submit", function (event) {
//     event.preventDefault();

//     const nameInput = document.getElementById("name");
//     const emailInput = document.getElementById("email");
//     const messageInput = document.getElementById("message");
//     const alertContainer = document.getElementById("alertContainer");

//     if (!nameInput || !emailInput || !messageInput || !alertContainer) return;

//     const name = nameInput.value.trim();
//     const email = emailInput.value.trim();
//     const message = messageInput.value.trim();

//     alertContainer.innerHTML = "";

//     const errors = [];

//     if (name === "") errors.push("Name is required.");
//     if (email === "") errors.push("Email is required.");
//     if (message === "") errors.push("Message is required.");

//     const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     if (email !== "" && !emailRegex.test(email)) {
//       errors.push("Invalid email format.");
//     }

//     if (message.length > 0 && message.length < 10) {
//       errors.push("Message must be at least 10 characters long.");
//     }

//     if (errors.length > 0) {
//       const alertDiv = document.createElement("div");
//       alertDiv.className = "alert alert-danger";
//       alertDiv.innerHTML = errors.join("<br>");
//       alertContainer.appendChild(alertDiv);
//     } else {
//       alertContainer.innerHTML = '<div class="alert alert-success">Form submitted successfully!</div>';
//       contactForm.reset();
//     }
//   });
// }









export function initContactFormValidation() {
  const contactForm = document.getElementById("contactForm");
  if (!contactForm) return;

  contactForm.addEventListener("submit", function (event) {
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");
    const alertContainer = document.getElementById("alertContainer");

    if (!name || !email || !message || !alertContainer) return;

    const nameVal = name.value.trim();
    const emailVal = email.value.trim();
    const messageVal = message.value.trim();

    alertContainer.innerHTML = '';

    const errors = [];

    if (!nameVal || !emailVal || !messageVal) {
      errors.push("Please fill in all fields.");
    }

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (emailVal && !emailRegex.test(emailVal)) {
  errors.push("Invalid email format.");
}


    if (errors.length > 0) {
      event.preventDefault(); // ❗Блокуємо лише якщо є помилки
      const alert = document.createElement("div");
      alert.className = "alert alert-danger";
      alert.innerHTML = errors.join("<br>");
      alertContainer.appendChild(alert);
    }
    // Інакше — форма надсилається нормально
  });
}
