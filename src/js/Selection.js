import { WRONG_ANSWER, RIGHT_ANSWER } from './constants'
import AJAX from './AJAX'

class Selection {

    constructor(element) {
        this.WRONG = 0;
        this.RIGHT = 1;

        this.currentLetter = 0;
        this.rightAnswer = true;

        this.currentWord = element.getAttribute('data-word');
        this.element = element;
        this.csrfToken = this.element.querySelector('.csrf-token');

        this.pickList = element.querySelector(".selection__pick-list");
        this.pickList.addEventListener("click", this.pickListClick.bind(this));
    }

    pickListClick(ev) {
        if (ev.target.classList.contains("selection__pick-word")
            && !ev.target.classList.contains("selection-blocked")) {
            if (this.currentWord.charAt(this.currentLetter).trim().length == 0) {
                this.currentLetter++;
                this.pickListClick(ev);

            } else {
                const pickedLetter = ev.target.innerHTML.trim().toLowerCase();
                const checkLetter = this.currentWord.charAt(this.currentLetter).toLowerCase();

                if (checkLetter == pickedLetter) {
                    this.showRightAnswer(ev, this.currentLetter);
                    this.currentLetter++;
                } else {
                    this.showWrongAnswer(ev);
                    this.rightAnswer = false;
                }
            }

            if (this.currentLetter == this.currentWord.length) {
                const status = this.rightAnswer ? RIGHT_ANSWER : WRONG_ANSWER;
                AJAX.sendResult(status, this.csrfToken.value);
            }
        }
    }

    // function showWrongAnswer
    showWrongAnswer(ev) {
        ev.target.classList.add('selection-blocked');
        ev.target.classList.add('selection-wrong');

        setTimeout( (function() {
            return function() {
                ev.target.classList.remove('selection-blocked');
                ev.target.classList.remove('selection-wrong');
            };
        })() ,600 );
    }

    // function showRightAnswer
    showRightAnswer(ev, numLetter) {
        ev.target.classList.add('selection-blocked');
        ev.target.classList.add('selection-right');
        this.showLetter(numLetter);

        setTimeout( (function() {
            return function() {
                ev.target.classList.remove('selection-blocked');
                ev.target.classList.remove('selection-right');
                ev.target.style.display = "none";
            };
        })(), 300 );
    }

    showLetter(numLetter) {
        const letter = document.getElementById('letter-' + numLetter);

        if(letter) {
            letter.classList.remove('selection-hidden');
        }
    }
}

let selection = new Selection(document.body.querySelector(".selection"));
