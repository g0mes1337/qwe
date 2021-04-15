function request(target, body, callback = {}, fallbackCallback = e => alert(e.issueMessage)) {
    const request = new XMLHttpRequest();
    request.open("POST", `${target}`, true);
    request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    request.responseType = "json";
    request.onreadystatechange = () => {
        if (request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 200) callback(request.response);
            else if (request.status === 403) alert("Нет прав доступа!");
            else if (request.status === 204) {
            } else fallbackCallback(request.response);
        }
    };
    request.send(JSON.stringify(body));
}


function SignUp(form) {
    request('application/action/signUp.php', {
            ['mail']: form.mail.value,
            ['password']: form.password.value,
            ['name']: form.name.value,
            ['surname']: form.surname.value,
            ['patronymic']: form.patronymic.value,
            ['login']: form.login.value

        }, (response) => {
            window.location.href = '/logIn';

        }, (response) => {
            alert(response);
        }
    );

}

function LogIn(form) {
    request('application/action/logIn.php', {
            ['mail']: form.mail_confirm.value,
            ['password']: form.password_confirm.value
        }, (response) => {
            window.location.href = '/';
        }, (response) => {
            alert(response);
        }
    );

}

function LogOut() {
    request('application/action/logOut.php', {}, (response) => {
            window.location.href = '/';
        },
        e => {
            console.log(e);
        }
    );
}

function getCategory() {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", 'application/action/getCategory.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send();
    xhr.onreadystatechange = function () {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let result = JSON.parse(xhr.responseText);
            for (let i = 0; i < result.length; i++) {
                document.querySelector('.select-one').insertAdjacentHTML("afterbegin", "  <option value='" + result[i]['id'] + "' id='" + result[i]['id'] + "' >" + result[i]['category_name'] + "</option>");
            }

        }
    }
}

function getUserInfo() {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", 'application/action/getUserInfo.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let result = JSON.parse(xhr.responseText);
            for (let i = 0; i < result.length; i++) {
                document.querySelector('.private_input').insertAdjacentHTML("beforeend", " <div class='font'><p>Название заявки</p><div>" + result[i]['name'] + "</div> <p>Временная метка</p><div>" + result[i]['data'] + "</div>    <p>Категория заявки</p><div>" + result[i]['category_name'] + "</div><p>Описание заявки</p><div>" + result[i]['description'] + "</div><p>Статус заявки </p><div>" + result[i]['status'] + "</div><button name='delete-request' onclick='deleteRequest(" + result[i]['id'] + ")'>Удалить</button></div> ");
            }

        }
    }
}

function addRequest(form) {
    request('application/action/addRequest.php', {
            ['name']: form.name.value,
            ['description']: form.description.value,
            ['photo']: form.photo.value,
            ['id']: form.id.value,

        }, (response) => {
            //  window.location.href = '/';

        }, (response) => {
            alert(response);
        }
    );

}

function deleteRequest(id_request) {
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        id_request: id_request
    });
    xhr.open("POST", 'application/action/deleteRequest.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send(json);
    location.reload();
}


function getCategory_admin() {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", 'application/action/getCategory.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send();
    xhr.onreadystatechange = function () {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let result = JSON.parse(xhr.responseText);
            for (let i = 0; i < result.length; i++) {
                document.querySelector('.delete_admin').insertAdjacentHTML("beforeend", "  <div>" + result[i]['category_name'] + "<button onclick='deleteCategory(" + result[i]['id'] + ")'>Удалить</button> </div></option>");
            }

        }
    }
}

function deleteCategory(id_request) {
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        id_request: id_request
    });
    xhr.open("POST", 'application/action/deleteCategory.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send(json);
    location.reload();
}

function getRequestMain() {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", 'application/action/getRequestMain.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let result = JSON.parse(xhr.responseText);
            for (let i = 0; i < result.length; i++) {
                document.querySelector('.main').insertAdjacentHTML("beforeend", "  <div class='font'> <img src=" + result[i]['photoBefore'] + " alt=''> <p>Название заявки</p><div>" + result[i]['name'] + "</div> <p>Временная метка</p><div>" + result[i]['data'] + "</div>    <p>Категория заявки</p><div>" + result[i]['category_name'] + "</div></div> ");
            }

        }
    }
}

function getRequest_admin() {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", 'application/action/getRequestMain.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let result = JSON.parse(xhr.responseText);
            for (let i = 0; i < result.length; i++) {
                document.querySelector('.out-request').insertAdjacentHTML("beforeend", "  <div>" + result[i]['name'] + " </div> <div class='select-request'><div class='requestAccess'><button onclick='requestAccess(" + result[i]['id'] + ")'>Решить</button></div></br<><button onclick='requestReject(" + result[i]['id'] + ")'>Отклонить</button></div>");
            }

        }
    }
}


function requestAccess(id_request) {
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        id_request: id_request
    });
    xhr.open("POST", 'application/action/requestAccess.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send(json);
}

function requestReject(id_request) {
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        id_request: id_request
    });
    xhr.open("POST", 'application/action/requestReject.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.send(json);
}