jQuery(document).ready(function($) {
    $('#immovables-form').submit(function(e) {
        e.preventDefault(); 

        // Сбор данных формы
        var formData = {
            action: 'add_real_estate',
            title: $('#title').val(),
            price: $('#price').val(),
            address: $('#address').val(),
            square: $('#square').val(),
            live_square: $('#live-square').val(),
            floor: $('#floor').val(),
            city: $('#city_id').val(),
            type: $('#type').val(),
            nonce: $('#nonce').val()
        };

        console.log(formData); // Логи 

        // Отправка AJAX-запроса
        $.post(ajaxurl, formData, function(response) {
            if (response.success) {
                $('#form-response').html('<p>' + response.data.message + '</p>');

                var newPostHtml = `
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card h-100 w-100">
                            <img src="http://localhost:8888/Finlead%20Team%20testwork/wp-content/themes/understrap-child/images/default-image.png" class="card-img-top" style="height:150px;" alt="${response.data.title}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${response.data.title}</h5>
                                <p class="card-text">
                                    Цена: ${response.data.price}<br>
                                    Адрес: ${response.data.address}<br>
                                    Площадь: ${response.data.square} м²
                                </p>
                                <a href="${response.data.url}" class="btn mt-auto btn-primary">Подробнее</a>
                            </div>
                        </div>
                    </div>
                `;

                // Добавление нового поста на страницу
                $('.card-row').prepend(newPostHtml);
            } else {
                $('#form-response').html('<p>Ошибка при добавлении недвижимости js.</p>');
            }
        }, 'json');
    });
});