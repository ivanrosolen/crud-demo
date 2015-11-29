APP = function () {
    if (! this || this === window) return new APP();
    this.response = false;
    return this;
};

APP.prototype = {

    init: function () {

        this.endpoint = 'http://api.crud.dev/';

        if ( window.localStorage.getItem('user_hash') != undefined &&
             window.localStorage.getItem('user_hash') != '' &&
             window.localStorage.getItem('user_hash') != null )
        {
            this.user_hash = window.localStorage.getItem('user_hash');
            this.user_name = window.localStorage.getItem('user_name');
            this.token     = window.localStorage.getItem('token');
        }
        return this;
    },

    logout: function () {

        window.localStorage.clear();

        $.ajax({
            type: 'GET',
            url: this.endpoint + 'user/logout',
            dataType: 'json',
            error: function(xhr, status, error) {
                return false;
            },
            success: function (result) {
                window.location = 'index.html';
            }
        });
    },

    login: function(data,callback) {

        window.localStorage.clear();

        $.ajax({
            type: 'POST',
            url: this.endpoint + 'user/login',
            dataType: 'json',
            data:data,
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                if ( result && result.hash != undefined && result.hash.length == 64) {
                    window.localStorage.setItem('user_hash', result.hash);
                    window.localStorage.setItem('user_name', result.name);

                    // Create Base64 Object
                    var Base64 = {_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
                    var token = Base64.encode(result.token);
                    window.localStorage.setItem('token',     token);
                    callback('ok');
                } else {
                    callback(false);
                }
            }
        });
    },

    list: function(pag, search, callback) {
        if ( search == '' ) search = 'all';
        $.ajax({
            type: 'GET',
            url: this.endpoint + 'list/infos/' + this.token + '/' + pag + '/' + search,
            dataType: 'json',
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                callback(result);
            }
        });
    },

    retreive: function(hash, callback) {
        $.ajax({
            type: 'GET',
            url: this.endpoint + 'info/' + this.token + '/' +hash,
            dataType: 'json',
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                callback(result);
            }
        });
    },

    create: function(data, callback) {
        $.ajax({
            type: 'POST',
            url: this.endpoint + 'info/' + this.token,
            dataType: 'json',
            data:data,
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                callback(result);
            }
        });
    },

    update: function(data, callback) {
        $.ajax({
            type: 'PUT',
             url: this.endpoint + 'info/' + this.token,
            dataType: 'json',
            data:data,
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                callback(result);
            }
        });
    },

    delete: function(data, callback) {
        $.ajax({
            type: 'DELETE',
            url: this.endpoint + 'info/' + this.token,
            dataType: 'json',
            data:data,
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                callback('ok');
            }
        });
    }
};