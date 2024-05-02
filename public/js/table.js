$(document).ready(function() {
    function renderTable(data) {
        var f = document.getElementById('tbody');
        f.innerHTML = '';
        data.forEach(function (data) {
            var ff = document.createElement('tr');
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

    const slider = document.getElementById("errorSliderRange");
    const input = document.getElementById("errorsСount");
    const button = document.getElementById('randomButton');
    const seedInput = document.getElementById('seedRange');

    slider.addEventListener("input", () => {
        input.value = slider.value ;
    });

    input.addEventListener("input", () => {
        slider.value = input.value;
    });

    button.addEventListener("click", () => {
        seedInput.value = Math.floor(Math.random() * 10000000);

    })


    function sendData() {
        var region = $('#selectRegion').val();
        var errors = $('#errorsСount').val();
        var seed = $('#seedRange').val();
        $.ajax({
            url: '/index/getdata',
            type: 'GET',
            data: { region : region, seed : seed, errors : errors },
            success: function(response) {
                renderTable(response)
            }
        });
    }

    document.getElementById('randomButton').addEventListener('click', sendData);
    document.getElementById('selectRegion').addEventListener('change', sendData);
    document.getElementById('seedRange').addEventListener('change', sendData);
    document.getElementById('errorsСount').addEventListener('change', sendData);
    document.getElementById('errorSliderRange').addEventListener('change', sendData);

});

