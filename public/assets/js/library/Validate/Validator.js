/**
 * Đã trải qua nhiều phiên bản update
 * có thời gian sẽ viết code lại gọn gàng
 */
/*export default */class Validator {
    formGroup = false;
    formElement;
    fieldEvent = true;
    valid = true;

    constructor(formElement, options) {
        this.formElement = formElement;
        this.#validator(options)
    }

    /**
     *
     * @param options object truyen vao
     */
    #validator(options) {
        this.#createProperties(options);

        let object = this;
        this.formElement.onsubmit = function (e) {
            e.preventDefault(); //dừng Submit
            let isFormValid = true; //Biến kiểm tra form hợp lệ chưa

            //Lặp qua từng rule và validate
            // dùng for-in nhé
            Object.keys(options.rules).forEach((inputSelector) => {
                let isvalid = object.#validate(options, inputSelector, options.rules[inputSelector]);
                if (!isvalid) { //nếu false thì form k hợp lệ
                    isFormValid = false;
                }
            })
            if (isFormValid) {
                let formElement = this;
                if (typeof options.submitHandler === 'function') {
                    let enableInputs = formElement.querySelectorAll('[name]:not([disabled])');
                    let formValues = Array.from(enableInputs).reduce(function (values, input) {
                        switch (input.type) {
                            case 'radio':
                                values[input.name] = formElement.querySelector('input[name=' + input.name + ']:checked').value;
                                break;
                            case 'checkbox':
                                if (input.matches(':checked')) {
                                    values[input.name] = input.value;
                                    // return values;
                                }
                                if (!Array.isArray(values[input.name])){
                                    values[input.name] = [];
                                }
                                values[input.name].push(input.value);
                                break;
                            case 'file':
                                values[input.name] = input.files;
                                break;
                            default:
                                values[input.name] = input.value;
                        }

                        return values;
                    }, {});
                    options.submitHandler(formValues);
                } else {
                    formElement.submit();
                }
            }
        }

        //event onblur and focus
        if (this.fieldEvent !== false) {
            Object.keys(options.rules).forEach((inputSelector) => {
                let inputElement = document.querySelector(inputSelector);
                inputElement.onblur = () => {
                    this.#validate(options, inputSelector, options.rules[inputSelector])
                }
                inputElement.onfocus = (e) => {
                    let formGroupElenment;
                    if (this.formGroup !== false) {
                        formGroupElenment = this.#getParent(inputElement);
                        if (formGroupElenment.classList.contains('invalid')) {
                            let iconError = formGroupElenment.querySelector('.icon')
                            if (iconError) {
                                iconError.remove();
                            }
                            let invalid = formGroupElenment.querySelector('.invalid-feedback');
                            if (invalid) {
                                invalid.remove();
                            }
                            formGroupElenment.classList.remove('invalid')
                        } else if (formGroupElenment.classList.contains('valid')) {
                            let iconSuccess = formGroupElenment.querySelector('.icon')
                            if (iconSuccess) {
                                iconSuccess.remove();
                            }
                            formGroupElenment.classList.remove('valid')
                        }
                    } else {
                        if (e.target.classList.contains('invalid')) {
                            let iconError = this.#getIcon(e.target);
                            let labelMsg = this.#getMsg(e.target);
                            if (iconError) {
                                iconError.remove();
                            }
                            if (labelMsg) {
                                labelMsg.remove();
                            }
                            e.target.classList.remove('invalid')
                        } else if (e.target.classList.contains('valid')) {
                            let iconSuccess = this.#getIcon(e.target);
                            if (iconSuccess) {
                                iconSuccess.remove();
                            }
                            e.target.classList.remove('valid')
                        }
                    }
                }
            })
        }

    }

    #validate(options, inputSelector, rules) {
        let inputElement = this.formElement.querySelector(inputSelector);
        let errorMessage;
        // Lấy ra các rule của selector
        // Lặp qua từng rule và kiểm tra tồn tại lỗi

        Object.keys(rules).every((rule) => {
            let param = options.rules[inputSelector][rule];
            let msg;
            if (options.message !== undefined) {
                if (options.message[inputSelector] !== undefined) {
                    if (options.message[inputSelector][rule] !== undefined) {
                        msg = options.message[inputSelector][rule];
                    }
                }
            }
            switch (inputElement.type) {
                case 'radio':
                case 'checkbox':
                    errorMessage = this[rule](param, msg)(formGroupElenment.querySelector(inputSelector + ':checked'));
                    break;
                default:
                    errorMessage = this[rule](param, msg)(inputElement.value);
            }
            if (errorMessage) return false;
            return true;
        })

        let formGroupElenment;// = this.getParent(inputElement);
        if (errorMessage) {
            if (this.formGroup !== false) {
                formGroupElenment = this.#getParent(inputElement);
                if (!formGroupElenment.classList.contains('invalid')) {

                    let labelMsg = document.createElement("div");
                    labelMsg.className = 'invalid-feedback';
                    labelMsg.innerText = errorMessage;

                    if (options.icon) {
                        let iconError = document.createElement("span");
                        iconError.className = 'icon abs-50';
                        iconError.innerHTML = options.icon.error;
                        formGroupElenment.appendChild(iconError);
                    }

                    formGroupElenment.appendChild(labelMsg);
                    formGroupElenment.classList.add('invalid');
                }
            } else {
                if (!inputElement.classList.contains('invalid')) {

                    let labelMsg = document.createElement("div");
                    labelMsg.className = 'invalid-feedback';
                    labelMsg.innerText = errorMessage;
                    this.#insertAfter(labelMsg, inputElement);

                    if (options.icon) {
                        let iconError = document.createElement("span");
                        iconError.className = 'icon abs-50';
                        iconError.innerHTML = options.icon.error;
                        this.#insertAfter(iconError, inputElement);
                    }
                    inputElement.classList.add('invalid');
                }
            }

        } else {
            if (this.valid) {
                if (this.formGroup !== false) {
                    formGroupElenment = this.#getParent(inputElement);
                    if (!formGroupElenment.classList.contains('valid')) {
                        if (options.icon) {
                            let iconSuccess = document.createElement("span");
                            iconSuccess.className = 'icon abs-50';
                            iconSuccess.innerHTML = options.icon.success;
                            this.#insertBefore(iconSuccess, inputElement);
                        }

                        formGroupElenment.classList.add('valid');
                    }
                } else {
                    if (!inputElement.classList.contains('valid')) {
                        if (options.icon) {
                            let iconSuccess = document.createElement("span");
                            iconSuccess.className = 'icon abs-50';
                            iconSuccess.innerHTML = options.icon.success;
                            this.#insertBefore(iconSuccess, inputElement);
                        }
                        inputElement.classList.add('valid');
                    }
                }
            }
        }

        return !errorMessage;
    }

    #getIcon(control) {
        let parent = control.parentElement;
        let icons = parent.querySelectorAll('.icon')
        icons.forEach(function (icon) {
            let sibling = icon.nextElementSibling;
            if (sibling === control) {
                return icon;
            }
        })
        return false;
    }

    #getMsg(control) {
        let label = control.nextElementSibling;
        if (label.matches('.invalid-feedback')) {
            return label;
        }
        return false;
    }

    #getParent(element) {
        while (element.parentElement) {
            if (element.parentElement.matches(this.formGroup) || element.parentElement.matches('FORM')) {
                return element.parentElement;
            }
            element = element.parentElement;
        }
    }

    #insertBefore(newNode, childNode) {
        let parent = childNode.parentElement;
        parent.insertBefore(newNode, childNode);
    }

    #insertAfter(newNode, childNode) {
        let parent = childNode.parentElement;
        let sibling = childNode.nextElementSibling;
        if (sibling === null) {
            parent.append(newNode);
        } else {
            parent.insertBefore(newNode, sibling);
        }
    }

    #createProperties(options) {
        if (options.formGroup !== undefined) {
            this.formGroup = options.formGroup;
        }
        if (options.fieldEvent === false) {
            this.fieldEvent = false;
        }
        if (options.addValid === false) {
            this.valid = false;
        }
    }

    required(param, msg) {
        return function (value) {
            // if (value){
            //     return value.trim() ? undefined : message || 'Vui lòng nhập họ tên!';
            // }else{
            if (param) return value ? undefined : msg || 'Vui lòng nhập trường này!';
            return undefined;
            // }
        }
    }

    email(param, message) {
        return function (value) {
            let regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (param) return regex.test(value) ? undefined : message || 'Bạn nhập sai email!';
        }
    }

    length(param, message) {
        return function (value) {
            return (value.length == param) ? undefined : message || 'Độ dài không hợp lệ!';
        }
    }

    minLength(param, message) {
        return function (value) {
            return (value.length >= param) ? undefined : message || 'Độ dài tối thiểu không hợp lệ!';
        }
    }

    maxLength(param, message) {
        return function (value) {
            return (value.length <= param) ? undefined : message || 'Độ dài tối đa không hợp lệ!';
        }
    }

    number(param, message) {
        return function (value) {
            let regex = /^\d+$/;
            if (param) return regex.test(value) ? undefined : message || 'Định dạng số không chính xác!';
        }
    }

    equalTo(param, message) {
        return function (value) {
            let confirmPwValue = document.querySelector(param).value;
            return value === confirmPwValue ? undefined : message || 'Nhập lại mật khẩu không trùng khớp!';
        }
    }

    notRegex(param, message) {
        return function (value) {
            for (const val of value) {
                if (param.test(val)) return message || 'Định dạng nhập vào không chính xác!';
            }
            return undefined;
        }
    }

    regex(param, message) {
        return function (value) {
            for (const val of value) {
                if (!param.test(val)) return message || 'Định dạng nhập vào không chính xác!';
            }
            return undefined;
        }
    }

    minValue(param, message) {
        return function (value) {
            return (Number(value) > param) ? undefined : message || 'Giá trị nhỏ hơn giá trị tối thiểu!';
        }
    }

    maxValue(param, message) {
        return function (value) {
            return (Number(value) < param) ? undefined : message || 'Giá trị lớn hơn giá trị tối đa!';
        }
    }
}
