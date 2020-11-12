function editInformation() {
  let firstName = document.getElementById("firstName");
  let firstNameInput = document.getElementById("firstNameInput");
  let lastName = document.getElementById("lastName");
  let lastNameInput = document.getElementById("lastNameInput");
  let editInformationBtn = document.getElementById("editInformationBtn");
  let editInformationBtnSubmit = document.getElementById("editInformationBtnSubmit");

  firstName.style.display = "none";
  lastName.style.display = "none";
  editInformationBtn.style.display = "none";

  firstNameInput.style.display = "";
  lastNameInput.style.display = "";
  editInformationBtnSubmit.style.display = "";
}
