$(document).ready(function () {


    $("#btn-agregar-item").on('click',function(e){
        e.preventDefault();
        $("#modalItemCoti").modal('show');
    });

    $("#guardarItemCoti").on('click', function(e){
        e.preventDefault();
        let descripcion = $("#descripcion").val();
        let cantidad = $("#cantidadModal").val();
        let precio = $("#precio_sin_igvModal").val();

        // Calcular Item
        let item;
        if ($("#table-form tr:last").find('td')[0]) {
            item =parseInt($("#compraBody tr:last").find('td').eq(0).html());
            item = item+1;
        }else{
            item = 1;
        }

        // Llenado de Tabla
        $("#compraBody").append(`<tr>
        <input type="hidden" name="descripcion[]" value="${descripcion}">
        <input type="hidden" name="cantidad[]" value="${cantidad}">
        <input type="hidden" name="subtotal[]" value="${precio}">
        <td class="item">${item}</td>
        <td>${descripcion}</td>
        <td>${cantidad}</td>
        <td>${precio}</td>
        <td class="sum">${cantidad*precio}</td>
        <td>
            <button class="eliminar-producto btn-accion-tabla eliminar tooltipsC"><i class="fa fa-fw fa-trash text-danger"></i></button>
            <button class="editar-producto btn-accion-tabla tooltips"><i class="fas fa-pencil-alt text-info"></i></button>
        </td>
        </tr>`);

        // Hallar el total de la compra
        let total=0;
        $("#table-form .sum").each(function () {
            total += parseFloat($(this).text());
        });
        $('input[name="total"]').attr('value', total);

        // Ingresar total en la tabla
        $("#compraFoot").html(`<tr>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Total</strong></td>
        <td>${total}</td>
        </tr>`);

        $("#formitemcoti").trigger('reset');
        $("#modalItemCoti").modal('hide');

    });



    $("#descripcion").maxLength(900,{
        showNumber: "#limit"
    })
    $("#descripcion-edit").maxLength(900,{
        showNumber: "#limit-edit"
    })



    $("#actualizarItemCoti").on('click', function(e){

        e.preventDefault();
            console.log('actualizar')
            let item = $("#item-edit").val();
            let descripcion = $("#descripcion-edit").val();
            let cantidad = $("#cantidadModal-edit").val();
            let precio = $("#precio_sin_igvModal-edit").val();

            console.log($("#descripcion-edit").val().length)

            let el = $(`td.item:contains('${item}')`).parent();

            // Llenado de Tabla
            $(`td.item:contains('${item}')`).parent().html(`
            <input type="hidden" name="descripcion[]" value="${descripcion}">
            <input type="hidden" name="cantidad[]" value="${cantidad}">
            <input type="hidden" name="subtotal[]" value="${precio}">
            <td class="item">${item}</td>
            <td>${descripcion}</td>
            <td>${cantidad}</td>
            <td>${precio}</td>
            <td class="sum">${cantidad*precio}</td>
            <td>
                <button class="eliminar-producto btn-accion-tabla eliminar tooltipsC"><i class="fa fa-fw fa-trash text-danger"></i></button>
                <button class="editar-producto btn-accion-tabla tooltips"><i class="fas fa-pencil-alt text-info"></i></button>
            </td>
            `);

            // Hallar el total de la compra
            let total=0;
            $("#table-form .sum").each(function () {
                total += parseFloat($(this).text());
            });
            $('input[name="total"]').attr('value', total);

            // Ingresar total en la tabla
            $("#compraFoot").html(`<tr>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Total</strong></td>
            <td>${total}</td>
            </tr>`);

            $("#formedititemcoti").trigger('reset');
            $("#modalEditItemCoti").modal('hide');

    });


});




$(document).on('click','.eliminar-producto', function(e){
    console.log('hola producto');
            e.preventDefault();
            swal({
                title: '¿ Está seguro que desea eliminar el registro ?',
                text: "Esta acción no se puede deshacer!",
                icon: 'warning',
                buttons: {
                    cancel: "Cancelar",
                    confirm: "Aceptar"
                },
            }).then((value) => {
                if (value) {
                    let element = $(this)[0].parentElement.parentElement;
                    $(element).remove();



            $("#table-form .item").each(function (i) {
                $(this).html(i+1);
            });

            // Hallar el total de la compra
            let total=0;
            $("#table-form .sum").each(function () {
                total += parseFloat($(this).text());
            });
            $('input[name="total"]').attr('value', total);

            // Ingresar total en la tabla
            $("#compraFoot").html(`<tr>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Total</strong></td>
            <td>${total}</td>
            </tr>`);
        }
    });
});





$(document).on('click','.editar-producto', function(e){
    e.preventDefault();
    console.log('editar-producto')
    let element = $(this).parent().parent();
    let tds = element.children('td');

    let item = tds[0].textContent;
    let descripcion = tds[1].textContent;
    let cantidad = parseInt(tds[2].textContent);
    let subtotal = parseFloat(tds[3].textContent);
    console.log(subtotal)

    $("#item-edit")[0].value = item;
    $("#descripcion-edit")[0].innerText = descripcion;
    $("#cantidadModal-edit")[0].value = cantidad;
    $("#precio_sin_igvModal-edit")[0].value = subtotal;

    console.log($("#descripcion-edit"))

    $("#modalEditItemCoti").modal('show');
});

