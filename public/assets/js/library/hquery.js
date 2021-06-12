/*
code này hướng tới xu hướng ES6
ngoài ra còn có thể sử dụng Kĩ thuật Polyfill

Ex:
    if (!Element.prototype.test){
        Element.prototype.test = function (e) {
            'use strict';
            console.log(e);
        ...
            statement.....
        ...
        }
    }
*/


// import Query from './Query/Hquery.js';
// import Ajax from './Ajax/Ajax.js';

function $(element) {
    return new Hquery(element);//new Query(element);
}

$.e = function (selector) {
    return document.querySelector(selector);
}
$.all = function (selector) {
    return document.querySelectorAll(selector);
}
$.loop = function (selector, callback) {
    if (Array.isArray(selector)) {
        // for (let i = 0; i < selector.length; i++) {
        //     callback(selector[i], i);
        // }
        selector.forEach(function (item, i) {
            callback(item, i);
        })
    } else {
        // var arr = $.all(selector);
        // for (let i = 0; i < arr.length; i++) {
        //     callback(selector[i], i);
        // }
        $.all(selector).forEach(function (item, i) {
            callback(item, i);
        })
    }
}
/**
 * New element from Ajax
 * @param callbak
 */

$.ajax = function (callback) {

}

$.get = function (URL, callback) {
    let ajax = new Ajax();
    ajax.get(URL, callback)
}

$.post = function (URL, data, callback) {
    let ajax = new Ajax();
    ajax.post(URL, data, callback);
}
