APP = function () {
    if (! this || this === window) return new APP();
    this.response = false;
    return this;
};

APP.prototype = {

    init: function () {

        this.endpoint = 'http://crud.dev/back/';

        if ( window.localStorage.getItem('user_hash') != undefined &&
             window.localStorage.getItem('user_hash') != '' &&
             window.localStorage.getItem('user_hash') != null )
        {
            this.user_hash    = window.localStorage.getItem('user_hash');
            this.user_name    = window.localStorage.getItem('user_name');
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
            cache: false,
            data:data,
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                if ( result && result.hash != undefined && result.hash.length == 64) {
                    window.localStorage.setItem('user_hash',    result.hash);
                    window.localStorage.setItem('user_name',    result.name);
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
            url: this.endpoint + 'list/infos/'+pag+'/'+search,
            dataType: 'json',
            cache: false,
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
            url: this.endpoint + 'info/'+hash,
            dataType: 'json',
            cache: false,
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
            url: this.endpoint + 'info',
            dataType: 'json',
            data:data,
            cache: false,
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
            url: this.endpoint + 'info',
            dataType: 'json',
            data:data,
            cache: false,
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
            url: this.endpoint + 'info',
            dataType: 'json',
            data:data,
            cache: false,
            error: function(xhr, status, error) {
                callback(false);
            },
            success: function (result) {
                callback('ok');
            }
        });
    }
};