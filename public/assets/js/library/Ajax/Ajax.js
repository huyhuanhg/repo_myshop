/*export default */class Ajax {
    get(URL, callback) {
        "use strict";
        // GET
        //Khoi tao doi tuong
        let xhttp = new XMLHttpRequest() || ActiveXObject();
        //Bat su kien thay doi trang thai cuar request
        xhttp.onreadystatechange = function () {
            //Kiem tra neu nhu da gui request thanh cong
            if (this.readyState == 4 && this.status == 200) {
                //In ra data nhan duoc
                // addData(this.responseText)
                callback(this.responseText);
            }
        }
        //cau hinh request
        xhttp.open('GET', URL, true);
        //gui request
        xhttp.send();

    }

    post(URL, data, callback) {
        "use strict";
        // POST
        // console.log(data);

        data = this.#handleData(data);
        //Khoi tao doi tuong
        let xhttp = new XMLHttpRequest() || ActiveXObject();
        //Bat su kien thay doi trang thai cuar request
        xhttp.onreadystatechange = function () {
            //Kiem tra neu nhu da gui request thanh cong
            if (this.readyState == 4 && this.status == 200) {
                //In ra data nhan duoc
                callback(this.responseText)
            }
        }
        //cau hinh request
        xhttp.open('POST', URL, true);
        //cau hinh header cho request
        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //gui request

        xhttp.send(data);
    }

    #handleData(data) {
        let strData = '';
        if (Object.isExtensible(data)) {
            Object.keys(data).forEach((key) => {
                    strData += key + '=' + data[key] + '&';
                }
            )
        }
        return strData.substring(0, strData.length - 1);
    };
}