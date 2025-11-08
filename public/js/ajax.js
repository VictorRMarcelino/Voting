var Ajax = {

    loadAjax: function(options) {
        let setings = $.extend({
            async: false
        }, options);

        $.ajax(setings).then(function(response) {
            debugger
            if (response != undefined && response != '') {
                let resposta = JSON.parse(response);
    
                if (resposta['error'] != undefined) {
                    Message.error('Erro', resposta['error']);
                    return;
                }
            }

            setings.fnSucess.apply(this, [response]);
        });
    }
}