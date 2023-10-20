class InputValidator {
    constructor(regex) {
        this.regex = regex;
    }

    checkInput(id) {
        const nameInput = document.getElementById(id);
        if (nameInput) {
            const nameValue = nameInput.value;
            return this.regex.test(nameValue);
        }
        return false;
    }
}