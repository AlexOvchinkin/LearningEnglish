class Register {
    constructor(element) {
        this.element = element;
        this.password = document.getElementById("password");
        this.passwordRepeat = document.getElementById("password-repeat");
        this.passwordRepeatLabel = document.getElementById("password-repeat-label");
        this.notice = document.getElementById("notice");

        element.addEventListener("submit", this.submitHandler.bind(this));

        this.password.addEventListener(
            "keypress",
            this.passwordKeyHandler.bind(this)
        );

        this.passwordRepeat.addEventListener(
            "keypress",
            this.passwordKeyHandler.bind(this)
        );
    }

    passwordKeyHandler(ev) {
        setTimeout(() => {
            if (this.isPasswordsEqual()) {
                this.passwordRepeatLabel.style.color = "#457070";
            } else {
                this.passwordRepeatLabel.style.color = "red";
            }
        }, 0);
    }

    submitHandler(ev) {
        let error = false;

        if (!this.isPasswordFormat()) {
            error = true;
            this.showNotice('Неверный формат пароля!');
        } else if (!this.isPasswordsEqual()) {
            error = true;
            this.showNotice('Подтверждение пароля не совпадает!');
        } else if (!this.isCheckFields()) {
            error = true;
            this.showNotice('Не все поля заполнены!');
        }

        if (error) {
            ev.preventDefault();
            this.emptyPassword();
        }
    }

    emptyPassword() {
        this.password.value = '';
        this.passwordRepeat.value = '';
        this.passwordRepeatLabel.style.color = "#457070";
    }

    showNotice(msg) {
        this.notice.innerHTML = msg;
        this.notice.style.display = "block";

        setTimeout(() => {
            this.notice.style.display = "none";
        }, 1500);
    }

    isPasswordFormat() {
        let password = this.password.value;
        let regexp = /^[a-zA-Z0-9]+$/;

        if (
            password.trim().length == 0 ||
            !regexp.test(password) ||
            password.length < 6
        ) {
            return false;
        }

        return true;
    }

    isPasswordsEqual() {
        let password = this.password.value;
        let passwordRepeat = this.passwordRepeat.value;

        return password == passwordRepeat;
    }

    isCheckFields() {
        let name = document.getElementById('name');
        let email = document.getElementById('email');

        if (name.value.trim().length == 0 || email.value.trim().length == 0) {
            return false;
        }

        return true;
    }
}

let register = new Register(document.body.querySelector(".registration"));
