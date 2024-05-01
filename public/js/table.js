$(document).ready(function() {
    function renderTable(data) {
        var f = document.getElementById('tbody');
        data.forEach(function (data) {
            var ff = document.createElement('tr');
            ff.innerHTML = '';
            var td = document.createElement('td');
            td.appendChild(document.createTextNode(data.id));
            ff.appendChild(td);

            td = document.createElement('td');
            td.appendChild(document.createTextNode(data.uuid));
            ff.appendChild(td);

            td = document.createElement('td');
            td.appendChild(document.createTextNode(data.name));
            ff.appendChild(td);

            td = document.createElement('td');
            td.appendChild(document.createTextNode(data.address));
            ff.appendChild(td);

            td = document.createElement('td');
            td.appendChild(document.createTextNode(data.phoneNumber));
            ff.appendChild(td);

            f.appendChild(ff);
        })
    }

    $('#selectRegion').change(function() {
        var selectedOption = $(this).val();
        console.log('sui')
        $.ajax({
            url: '/index/getdata',
            type: 'GET',
            data: { option : selectedOption },
            success: function(response) {
                renderTable(response)
            }
        });
    });
});

