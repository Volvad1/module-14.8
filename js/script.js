// проверка доступности Cookie
function checkCookieEnabled() {
    // если отключены
    if (!navigator.cookieEnabled) {
        return false;
    }
    // установим cookie и попробуем прочитать
    document.cookie = "ct=1";
    let ret = document.cookie.indexOf("ct=") != -1;

    // удалим тестовый cookie
    document.cookie = "ct=1; max-age=0";

    return ret;
}

// Получение Cookie по ключу/имени
// или undefined, если ничего не найдено
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

// Устанавливает куки с именем name и значением value, с настройкой path=/ по умолчанию 
function setCookie(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };

    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }

    document.cookie = updatedCookie;
}

// Установка отрицательной даты истечения срока действия для удаления Coocie
function deleteCookie(name) {
    setCookie(name, "", {
      'max-age': -1
    })
  }