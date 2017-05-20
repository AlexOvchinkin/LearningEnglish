export default class AJAX {

    static sendResult(status, csrfToken) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/onAnswer');
        xhr.setRequestHeader("CSRF-Token", csrfToken);
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