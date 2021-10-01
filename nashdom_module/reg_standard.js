$(document).ready(() => {
    $(".add_info").toggle();

    $('#add_info_butt').click(
        function () {
            $(".add_info").toggle();
   	}
    );
 

    $("#submit_button").click(function () {

        let data = fetchData();
	

        if (validateFields(data)) {

        	regUser(data);
			regUserPhpBB(data);	
			
        }

    });

    $("#back_button").click(function () {

        deleteUserCookie();
        window.open("/registration_3/pages/reg_choose.php", "_self");
    });

    //$('#phone_number_input').inputmask("+7 (999) 999-99-99");
    //$('#phone_number_input').maskedinput("+7 (999) 999-99-99");
   
    $('#acceptance_text').click(function () {
        let checkbox = $('#acceptance_checkbox');
        checkbox.prop('checked', !checkbox.prop('checked'));
        if (checkbox.prop('checked')) {
            $('#acceptance_text').css("color", "#000000");
        }
    });


});

function fetchData() {
    let login;
    let password;
    let reg_service = 0;
    let gender = parseInt($("input:radio[name ='gender']:checked").val(), 10);
    if (Cookies.get("auth_type") === "vk") {
        login = null;
        password = null;
        reg_service = 2;
    }
    if (Cookies.get("auth_type") === "fb") {
        login = null;
        password = null;
        reg_service = 3;
    }
    if (Cookies.get("auth_type") === "ok") {
        login = null;
        password = null;
        reg_service = 4;
    }

    let loginField = $("#login_input");
    let passwordField = $("#password_input");
    let confPassField = $("#conf_password_input");
    return {
        'login': loginField.length ? loginField.val().trim() : "",
        'password': passwordField.length ? passwordField.val() : "",
        'conf_password': confPassField.length ? confPassField.val() : "",
        'user_name': $("#user_name_input").val().trim(),
        'flat': $("#flat_input").val().trim(),
        'email': $("#email_input").val().trim(),
        'first_name': $("#first_name_input").val().trim(),
        'last_name': $("#last_name_input").val().trim(),
        'middle_name': $("#middle_name_input").val().trim(),
        'gender': gender,
        'birth_date': $("#birth_date_input").val(),
        'phone_number': extractFromMask($("#phone_number_input").val()),
        'work': $("#work_input").val().trim(),
        'membership': $("#membership_input").val().trim(),
        'experience': $("#experience_input").val().trim(),
        'reg_service': reg_service,
    };
}

function extractFromMask(number) {
    return number.split("+").join("")
        .split("(").join("")
        .split(")").join("")
        .split("-").join("")
        .split(" ").join("")
        .replace("7", "8");
}

function validateFields(data) {
    let result = true;

    if (Cookies.get("auth_type") !== "vk"
        && Cookies.get("auth_type") !== "ok"
        && Cookies.get("auth_type") !== "fb") {
        result &= checkLogin(data["login"]);
        result &= checkPassword(data["password"], data["conf_password"]);
    }

    result &= checkUsername(data["user_name"]);
    result &= checkFlat(data["flat"]);
    result &= checkEmail(data["email"]);
    result &= checkName(data["first_name"], 0);
    result &= checkName(data["last_name"], 1);
    result &= checkName(data["middle_name"], 2);
    result &= checkLongData(data["work"], 0);
    result &= checkLongData(data["membership"], 1);
    result &= checkLongData(data["experience"], 2);
    result &= checkAcceptance();

    return result;

}

function checkLogin(login) {

    removeMessage("#incorrect_login_error");

    let result = true;

    if (login.length === 0) {
        appendErrorMessage('#login_form', 'incorrect_login_error', "Введите логин.");
        return false;
    }

    if (!isLongEnough(login, 3, 30)) {
        appendErrorMessage('#login_form', 'incorrect_login_error', "Логин должен содержать от 3-х до 30 символов.");
        return false;
    }

    if (isFieldIncorrect(login, 0)) {
        appendErrorMessage('#login_form', 'incorrect_login_error', "Логин может содержать только латинские символы, цифры и символ _ и может начинаться только с латинской буквы.");
        return false;
    }

    return true;

}

function checkPassword(password, confPassword) {
    removeMessage("#incorrect_password_error");
    removeMessage("#incorrect_conf_login_error");

    if (password.length === 0) {
        appendErrorMessage('#password_form', 'incorrect_password_error', "Введите пароль.");
        return false;
    }

    if (!isLongEnough(password, 8, 40)) {
        appendErrorMessage('#password_form', 'incorrect_password_error', "Пароль должен содержать от 8 до 40 символов.");
        return false;
    }

    if (isFieldIncorrect(password, 1)) {
        appendErrorMessage('#password_form', 'incorrect_password_error', "Пароль может содержать только латинские строчные и прописные буквы, цифры и следующие символы: @$!%*?_.,&");
        return false;
    }

    if (password !== confPassword) {
        appendErrorMessage('#password_form', 'incorrect_password_error', "Пароли не совпадают");
        appendErrorMessage('#conf_password_form', 'incorrect_conf_login_error', "Пароли не совпадают");
        return false;
    }

    return true;
}

function checkUsername(userName) {
    removeMessage("#user_name_error");

    if (userName.length === 0) {
        appendErrorMessage('#user_name_form', 'user_name_error', "Введите имя пользователя.");
        return false;
    }

    if (!isLongEnough(userName, 2, 30)) {
        appendErrorMessage('#user_name_form', 'user_name_error', "Имя пользователя должно содержать от 2 до 40 символов.");
        return false;
    }

    if (isFieldIncorrect(userName, 2)) {
        appendErrorMessage('#user_name_form', 'user_name_error', "Имя пользователя должно содержать хотя бы 2 символа и начинаться с буквы");
        return false;
    }

    return true;
}


function checkFlat(flat) {
    removeMessage("#flat_error");

    if (flat.length === 0) {
        appendErrorMessage('#flat_form', 'flat_error', "Введите номер квартиры");
        return false;
    }

    if (isFieldIncorrect(flat, 3)) {
        appendErrorMessage('#flat_form', 'flat_error', "Номер квартиры введён некорректно");
        return false;
    }

    if (!isLongEnough(flat.toString(), 1, 3)) {
        appendErrorMessage('#flat_form', 'flat_error', "Слишком большой номер квартиры");
        return false;
    }

    return true;
}

function checkEmail(email) {
    removeMessage("#email_error");

    if (email.length === 0) {
        return true;
    }

    if (isFieldIncorrect(email, 4)) {
        appendErrorMessage('#email_form', 'email_error', "Электронная почта введена некорректно");
        return false;
    }

    if (!isLongEnough(email, 1, 100)) {
        appendErrorMessage('#email_form', 'email_error', "Электронная почта введена некорректно");
        return false;
    }

    return true;
}


function checkName(name, position) {

    let formSelector;
    let errorId;

    switch (position) {
        case 0:
            formSelector = "#first_name_form";
            errorId = "first_name_error";
            break;
        case 1:
            formSelector = "#last_name_form";
            errorId = "last_name_error";
            break;
        case 2:
            formSelector = "#middle_name_form";
            errorId = "middle_name_error";
            break;
    }

    removeMessage("#" + errorId);

    if (name.length === 0) {
        return true;
    }

    if (!isLongEnough(name, 2, 30)) {
        appendErrorMessage(formSelector, errorId, "Поле должно содержать от 2 до 30 символов");
        return false;
    }

    if (isFieldIncorrect(name, 5)) {
        appendErrorMessage(formSelector, errorId, "Поле может содержать только кириллические символы, ' и -");
        return false;
    }

    return true;
}

function checkLongData(data, position) {

    let formSelector;
    let errorId;

    switch (position) {
        case 0:
            formSelector = "#work_form";
            errorId = "work_error";
            break;
        case 1:
            formSelector = "#membership_form";
            errorId = "membership_error";
            break;
        case 2:
            formSelector = "#experience_form";
            errorId = "experience_error";
            break;
    }

    removeMessage("#" + errorId);


    if (data.length === 0) {
        return true;
    }

    if (data.length > 300) {
        appendErrorMessage(formSelector, errorId, "Лимит 300 символов");
        return false;
    }

    return true;

}

function isFieldIncorrect(value, fieldId) {
    let regex;
    switch (fieldId) {
        //login regex
        case 0:
            regex = /^[a-zA-Z]+[a-zA-Z0-9_]+/;
            break;
        //password regex
        case 1:
            regex = /^[@$!%*?_.,&A-Za-z\d]{8,}$/;
            break;
        //username regex
        case 2:
            regex = /^[a-zA-Zа-яА-я]+[a-zA-Zа-яА-я0-9_\s]+/;
            break;
        //flat regex
        case 3:
            regex = /^[1-9]+[0-9]*/;
            break;
        //email regex
        case 4:
            regex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
            break;
        //firstName, lastName, middleName regex
        case 5:
            regex = /^[а-яА-Я]+[а-яА-Я\-']*[а-яА-Я]+/;
            break;
    }


    return !regex.test(value);
}

function isLongEnough(value, min, max) {
    let strLength = value.length;
    return strLength >= min && strLength <= max;
}

function changeInterface() {
    $("#registration_form").remove();
    $("<div>Вы успешно зарегистрированы! Теперь вы будете перенаправлены на страницу вашего дома!</div>").appendTo("body");
}

function regUser(data) {

    let params = "?";
    for (let key in data) {
        params += '&' + key + '=' + data[key];
		//document.write(data[key]+'<br />');
    }
	//alert('params =  ' + params);
	
// =========================================================================== 

    $.ajax({
	                            
        method: 'GET',
        url: './auth_scripts/reg.php' + params,
        contentType: 'json',
        success: function (data) {
			
            //data = JSON.parse(data);
			//alert('re-re 7');

            removeMessage('.error_message');

            if (data['message'] != 'error') {
                deleteRegCookie();
                changeInterface();
                redirectToMainPage();
                return;
            }

            if (data['reasons'].includes('login') && !isMessageExist("#exist_login_error")) {
                appendErrorMessage('#login_form', ' exist_login_error', "Пользователь с таким логином уже зарегистрирован");
            }

            if (data['reasons'].includes('email') && !isMessageExist("#exist_email_error")) {
                appendErrorMessage('#email_form', ' exist_email_error', "Пользователь с такой электронной уже зарегистрирован");
            }

        }

    });	
}

//Посылает данные из формы в файл для регистрации на форуме
function regUserPhpBB(data) {
	
	_address = sessionStorage["detailPage"];
	
	$.post(
		"./../../phpbb/login.php",
		{
		register: "Register",
		address: _address,
		username: data['login'],
		password: data['password'],
		email: data['email']
		} 
	);
	
}

function checkAcceptance() {
    let isChecked = $('#acceptance_checkbox').prop('checked');

    $('#acceptance_text').css('color', '#000000');

    if (!isChecked) {
        $('#acceptance_text').css('color', '#ff0000');
    }

    return isChecked;
}

function isMessageExist(selector) {
    return $(selector).length;
}


function appendErrorMessage(selector, id, text) {
    $(selector).append("<div class='error_message' id=" + id + ">" + text + "</div>");
}

function removeMessage(selector) {
    $(selector).remove();
}

function deleteRegCookie() {
    Cookies.remove("auth_type");
    Cookies.remove("uid");
    Cookies.remove("fias_val");
    Cookies.remove("house");
    Cookies.remove("street_fias_id");
    Cookies.remove("soc_net_user_name");
}

function deleteUserCookie() {
    Cookies.remove("uid");
    Cookies.remove("auth_type");
    Cookies.remove("soc_net_user_name");
}

function redirectToMainPage() {
	address = sessionStorage['url_house'] ;
//	alert (address);
	adres="http://nashdom.club/"+address;
    	setTimeout(function () {
       		 	window.open(adres, "_self")
   		 }, 5000)
}

