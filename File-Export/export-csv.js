jQuery(function ($) {
    $(document).on('click', '#export_admin_order', function (event) {
        event.preventDefault();

        $('#export_admin_order').attr('disabled', true);

        var filterAction = $.getUrlVar('filter_action');
        var customerId = $.getUrlVar('_customer_user');
        var m = $.getUrlVar('m');

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: {
                action: 'export_order_from_admin',
                filter: filterAction,
                customerId: customerId,
                m: m,
            },
            success: function (response) {
                var downloadLink = document.createElement("a");
                var fileData = ['\ufeff' + response];

                var blobObject = new Blob(fileData, {
                    type: "text/csv;charset=utf-8;"
                });

                var time = Math.round(Date.now() / 1000);
                var url = URL.createObjectURL(blobObject);
                downloadLink.href = url;
                downloadLink.download = "orders-" + time + ".csv";

                /*
                 * Actually download CSV
                 */
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);

                $('#export_admin_order').attr('disabled', false);
            }
        });
    });

    $.extend({
        getUrlVars: function () {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function (name) {
            return $.getUrlVars()[name];
        }
    });
});