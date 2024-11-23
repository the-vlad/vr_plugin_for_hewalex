export default class Checkbox {
  constructor() {
    this.checkboxList = document.querySelectorAll(".acf-checkbox-list");
    this.checkboxes = document.querySelectorAll(
      ".acf-field-checkbox .acf-input .acf-checkbox-list li label"
    );
    if (this.checkboxList) {
      this.events();
    }
  }

  events() {
    [...this.checkboxes].forEach((el, index) => {
      const checkbox_input = document.createElement("span");
      checkbox_input.setAttribute("class", `acf-styled-checkmark ${index}`);
      el.append(checkbox_input);
    });
  }
}
