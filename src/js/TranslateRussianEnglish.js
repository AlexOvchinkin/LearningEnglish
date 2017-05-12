class Translate {

    constructor(element) {
        this.WRONG = 0;
        this.RIGHT = 1;

        this.element = element;
        this.mainWord = this.element.querySelector('.translate__main-word');
        this.checkButtons = this.element.querySelectorAll('.translate__check-word');

        this.element.addEventListener('click', (ev) => {
            let element = ev.target.closest('.translate__check-word');

            if (element) {
                if (element.hasAttribute('data-translate')
                    && element.hasAttribute('data-check')
                    && !element.classList.contains('translate-blocked')) {

                    this.blockCheckButtons();

                    if (element.dataset.translate == this.mainWord.dataset.translate) {
                        this.setRightResult(element);
                        this.sendResult(this.RIGHT);
                    } else {
                        this.setWrongResult(element);
                        setTimeout(() => {
                            this.sendResult(this.WRONG);
                        }, 2000);
                    }
                }
            }
        })
    }

    setRightResult(element) {
        element.classList.add('translate-right');
    }

    setWrongResult(element) {
        element.classList.add('translate-wrong');

        Array.prototype.forEach.call(this.checkButtons, (item) => {
            if (item.dataset.translate == this.mainWord.dataset.translate) {
                this.setRightResult(item);
            }
        });
    }

    blockCheckButtons() {
        Array.prototype.forEach.call(this.checkButtons, (item) => {
            item.classList.add('translate-blocked');
        });
    }

    sendResult(status) {
        let csrfCookie = document.cookie.match(/CSRF-Token=([\w-]+)/);

        if (csrfCookie) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/onEnRuAnswer');
            xhr.setRequestHeader("CSRF-Token", csrfCookie[1]);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            const param = "ANSWER=" + status;
            xhr.send(param);

            xhr.onreadystatechange = function () {
                if (xhr.readyState > 3 && xhr.status == 200) {
                    window.location.href = xhr.responseText;
                }
            }
        }
    }
}

let container = document.body.querySelector('.translate');

if (container) {
    let translate = new Translate(container);
}

