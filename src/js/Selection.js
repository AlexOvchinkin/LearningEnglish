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

        this.soundBtn = this.element.querySelector('.selection__sound-btn');

        this.correctSound = document.getElementById('correct-sound');
        this.wrongSound = document.getElementById('wrong-sound');
        this.mainSound = document.getElementById('main-sound');

        if (this.soundBtn) {

            this.soundBtn.addEventListener('click', (ev) => {

                if (this.mainSound.hasAttribute('data-enword')) {

                    let enWord = this.mainSound.dataset.enword;

                    if (this.mainSound && enWord) {

                        this.mainSound.innerHTML =
                            '<audio src="../src/sound/'
                            + enWord
                            + '.mp3" id="correct-sound" autoplay></audio>';
                    }
                }
            });
        }

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
                    this.correctSound.innerHTML =
                        '<audio src="../src/sound/game_sound_correct.mp3" id="correct-sound" autoplay></audio>';
                } else {
                    this.showWrongAnswer(ev);
                    this.rightAnswer = false;
                    this.wrongSound.innerHTML =
                        '<audio src="../src/sound/game-sound-wrong.mp3" id="wrong-sound" autoplay></audio>';
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
