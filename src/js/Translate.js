import { WRONG_ANSWER, RIGHT_ANSWER } from './constants'
import AJAX from './AJAX'

class Translate {

    constructor(element) {
        this.element = element;
        this.mainWord = this.element.querySelector('.translate__main-word');
        this.checkButtons = this.element.querySelectorAll('.translate__check-word');
        this.csrfToken = this.element.querySelector('.csrf-token');

        this.element.addEventListener('click', (ev) => {
            let element = ev.target.closest('.translate__check-word');

            if (element) {
                if (element.hasAttribute('data-translate')
                    && element.hasAttribute('data-check')
                    && !element.classList.contains('translate-blocked')) {

                    this.blockCheckButtons();

                    if (element.dataset.translate == this.mainWord.dataset.translate) {
                        this.setRightResult(element);
                        AJAX.sendResult(RIGHT_ANSWER, this.csrfToken.value);
                    } else {
                        this.setWrongResult(element);
                        setTimeout(() => {
                            AJAX.sendResult(WRONG_ANSWER, this.csrfToken.value);
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
}

let container = document.body.querySelector('.translate');

if (container) {
    let translate = new Translate(container);
}