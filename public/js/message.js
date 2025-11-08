var Message = {

    show: function(title, icon, text, fnOk) {
        Swal.fire({
            title: title,
            icon: icon,
            text: text
        }).then((result) => {
            if (fnOk == undefined) {
                return;
            }
            
            fnOk.apply(this, [result]);
        })
    },

    error: function(title, text) {
        Message.show(title, 'error', text);
    },

    success: function(title, text, fnOk) {
        Message.show(title, 'success', text, fnOk);
    },

    warn: function(title, text, fnOk) {
        Message.show(title, 'warn', text, fnOk);
    }
}