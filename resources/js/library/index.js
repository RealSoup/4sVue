import Vue from 'vue';

Vue.prototype.auth = function () {
    return window.auth_user;
}

Vue.prototype.nl2br = function (content) {
    return (content + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br />' + '$2');
}

Vue.prototype.isMine = function (id) {
    return this.auth().id == id;
}
