//#region --- KIEM TRA GIA TRI RONG
    /**
     * Kiểm tra giá trị biến
     * @returns {boolean} true: giá trị rỗng, false: giá trị không rỗng
     * @param {any} object Biến cần kiếm tra null, undefined, ""
     */
    function isEmpty(object) {
        var checkVar = false;
        if (typeof object === 'object' && object.length <= 0) {
            checkVar = true;
        } else if (typeof object === 'undefined' || object === null || object === '') {
            checkVar = true;
        }
        return checkVar;
    }
//#endregion

//#region --- HIEN THI THONG BAO
    /**
    * Pop up hiển thị nội dung tin nhắn
    * @param {string} message nội dung tin nhắn
    * @param {object} btn danh mục nút
    */
    function showMessages(message, btn, option) {
        var optionAlert = {
            'title': "Thông báo",
            'content': message,
            'closeOnEsc': true,
            'closeOnClick': true,
            'class': 'jAlert-Bookoke',
            'btns': btn,
        }

        if (typeof option == 'object' && !isEmpty(option)) {
            optionAlert = Object.assign(optionAlert, option);
        }

        $.jAlert(optionAlert);
    }
//#endregion

//#region --- HIEN THI THONG BAO LOI
function showErrorMessage(data) {
    var error = data["error-message"];
    var errorText = '';

    if (typeof (error) === 'object' && error != '') {
        $.each(error, function (k, v) {
            errorText += " " + v[0] + "<br>";
        });
    } else if (typeof error == 'string') {
        errorText = error;
    }

    showMessages(errorText);
}
//#endregion

//#region --- FORMAT NUMBER
function formatNumber(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 0 : c,
      d = d == undefined ? "," : d,
      t = t == undefined ? "." : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
//#endregion