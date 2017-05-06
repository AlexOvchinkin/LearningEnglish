class Vocabulary {

    constructor(element) {
        this.element = element;
        this.element.addEventListener('click', this.clickHandler.bind(this));

        this.btnTrain = document.getElementById('train-btn');
        this.btnTrain.addEventListener('click', this.btnTrainClick.bind(this));
    }

    clickHandler(ev) {
        if (!ev.target.classList.contains('vocabulary__img')) {
            const wordCard = ev.target.closest('.vocabulary__item');
            if (wordCard) {
                wordCard.classList.toggle('vocabulary-selected')
            }
        }
    }

    btnTrainClick(ev) {
        ev.preventDefault();
    }
}

let vocabulary = new Vocabulary(document.body.querySelector('.vocabulary'));
