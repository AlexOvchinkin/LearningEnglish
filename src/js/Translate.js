class Translate {

    constructor(element) {
        this.element = element;
    }

    sendWrongResult() {
        let csrfCookie = document.cookie.match(/CSRF-Token=([\w-]+)/);

        if (csrfCookie) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/onWrongEnRuAnswer', true);
            xhr.setRequestHeader("CSRF-Token", csrfCookie[1]);
            xhr.send();

            xhr.onreadystatechange = function () {
                if (xhr.readyState > 3 && xhr.status == 200) {
                    alert(xhr.responseText);
                }
            }
        }
    }
}

let translate = new Translate(document.body.querySelector('.training_en_ru'));

if (translate) {
    translate.sendWrongResult();
}
