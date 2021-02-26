$(document).ready(function() {
    $("#contenedor").load("template/productos.html ");
    var productosCarrito = [];
    $("#limpiar").click(function() {
        $(".elementoNuevo").remove();
        productosCarrito = [];
    });
    $.ajax({
        url: "/catalogo",
        method: "get",
        dataType: "json",
        success: function(data) {
            var opciones = ["Todo"];
            $.each(data, function(ind, valor) {
                var divProducto = $("#clonar").clone().appendTo("#listado");
                $(divProducto).attr("hidden", false);
                $(divProducto).addClass("item");
                $(divProducto).data("datos", data);
                var divGeneral = $("<div class='single-popular-items mb-50 text-center'>");
                var divImagen = $("<div class='popular-img' id=producto'>")
                var categoria = valor.categoria.replace(/\s/g, '');
                var nombre = valor.nombre.replace(/\s/g, '');
                var imagen = valor.imagenes[0];
                var direccion = 'uploads/imagenes/productos' + "/" + categoria + "/" + nombre + "/" + imagen;
                var carrito = $("<div class='img-cap'><span>Añadir al carrito</span></div>");
                var imagenProducto = $("<img src='" + direccion + "' alt=''>");
                $(imagenProducto).appendTo(divImagen);
                $(carrito).appendTo(divImagen);
                $(carrito).click(function() {
                    if (!productosCarrito.includes(valor.id)) {
                        productosCarrito.push(valor.id);
                        var tr = $("<tr class='elementoNuevo'>");
                        var imagenProducto = $("<img width='50' height='50' src='" + direccion + "' alt=''>");
                        var nombre = $("<strong>" + valor.nombre + "</strong>")
                        var precio = $("<span>" + valor.precio + "€</span>")
                        var cantidad = $("<span id='cantidad' class='cantidadCarrito'>1</span>")
                        var tdimagen = $("<td id='imagenProducto'>");
                        var tdnombre = $("<td id='nombreProducto'>");
                        var tdprecio = $("<td id='precioProducto'>");
                        var tdcantidad = $("<td id='cantidadProducto'>");

                        tdimagen.append(imagenProducto);
                        tdnombre.append(nombre);
                        tdprecio.append(precio);
                        tdcantidad.append(cantidad);
                        tr.append(tdimagen);
                        tr.append(tdnombre);
                        tr.append(tdprecio);
                        tr.append(tdcantidad);

                        $("#productos").append(tr);

                    } else {
                        productosCarrito.push(valor.id);
                        var cantidadNueva = parseInt($("#cantidad").text()) + 1;
                        $("#cantidad").text(cantidadNueva);

                    }

                });

                var info = $('<div class="popular-caption" id="info">');
                var h3 = $("<h3>");
                var nombreProducto = $("<a href='#' id='" + valor.id + "'>" + valor.nombre + "</a>")
                h3.append(nombreProducto);
                var precio = $("<span>" + valor.precio + "€</span>")

                $(h3).appendTo(info);
                $(precio).appendTo(info);

                $(divGeneral).append(divImagen);
                $(divGeneral).append(info);

                $(divProducto).append(divGeneral);
                h3.click(function() {
                    $.ajax({
                        url: "/catalogo/" + valor.id,
                        method: "get",
                        dataType: "json",
                        success: function(info) {
                            $("#seccion").hide();
                            var div = $('<div class="row">');
                            div.load("template/info.html", function() {
                                for (let i = 0; i < info.imagenes.length; i++) {
                                    var direccion = 'uploads/imagenes/productos' + "/" + categoria + "/" + nombre + "/" + info.imagenes[i];
                                    var divPicture = $('<div class="single_product_img d-inline">');
                                    var picture = $('<img src="' + direccion + '" width="200" height="200" alt="#" class="img-fluid">')
                                    $(divPicture).append(picture);
                                    $("#imagenes").append(divPicture);
                                    var texto = info.descripcion.split([";"]);
                                    $("#nombre").text(texto[0]);
                                    $("#descripcion").text(texto[1]);
                                }

                                $(".add_to_cart").click(function() {
                                    var num = parseInt($(".input-number").val());
                                    if (!productosCarrito.includes(valor.id)) {
                                        productosCarrito.push(valor.id);
                                        var tr = $("<tr class='elementoNuevo'>");
                                        var imagenProducto = $("<img width='50' height='50' src='" + direccion + "' alt=''>");
                                        var nombre = $("<strong>" + valor.nombre + "</strong>")
                                        var precio = $("<span>" + valor.precio + "€</span>")
                                        var cantidad = $("<span id='cantidad' class'cantidadCarrito'>" + num + "</span>")
                                        var tdimagen = $("<td id='imagenProducto'>");
                                        var tdnombre = $("<td id='nombreProducto'>");
                                        var tdprecio = $("<td id='precioProducto'>");
                                        var tdcantidad = $("<td id='cantidadProducto' class='cantidadProducto'>");

                                        tdimagen.append(imagenProducto);
                                        tdnombre.append(nombre);
                                        tdprecio.append(precio);
                                        tdcantidad.append(cantidad);
                                        tr.append(tdimagen);
                                        tr.append(tdnombre);
                                        tr.append(tdprecio);
                                        tr.append(tdcantidad);
                                        $("#productos").append(tr);
                                    } else {
                                        var cantidadNueva = parseInt($("#cantidad").text()) + num;
                                        $("#cantidad").text(cantidadNueva);
                                    }

                                });
                            });
                            $("main").append(div);
                        }
                    });
                });

                if (!opciones.includes(valor.categoria)) {
                    opciones.push(valor.categoria)
                }

            });
            for (let i = 0; i < opciones.length; i++) {
                var value = opciones[i].replace(/\s/g, '');
                var opcion = $('<option value="' + value + '">' + opciones[i] + '</option>')
                $("#categorias").append(opcion);
            }
            $("#categorias").change(function() {
                let seleccionada = $("#categorias option:selected").text();
                if (seleccionada != "Todo") {
                    console.log($(".item").length)
                    var info = $(".item").data("datos");
                    for (let i = 0; i < $(".item").length; i++) {
                        if (info[i].categoria != seleccionada) {
                            $($(".item")[i]).hide();
                        } else {
                            $($(".item")[i]).show();
                        }
                    }
                } else {
                    var info = $(".item").data("datos");
                    for (let i = 0; i < $(".item").length; i++) {
                        if (info[i].categoria != seleccionada) {
                            $($(".item")[i]).show();
                        }
                    }
                }
            });
        }
    });
    $("#pagar").click(function() {
        var autenticado = $("#autenticado").text();
        if (autenticado == "true") {
            if (productosCarrito.length == 0) {
                alert("No hay contenido en tu carrito")
            } else {
                //se utiliza $.ajax(), a la cual se le pasa un objeto {}, con la información
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "/productos/pedidos/pagar",
                    data: {
                        productosCarrito: productosCarrito
                    },
                    success: function() {
                        alert("Pedido realizado")
                        productosCarrito = [];
                        $("#productos").children().remove();
                        $(function() {
                            $('#exampleModal').modal('toggle');
                        });
                    }
                });
            }
        } else {
            alert("Logueate")
            window.location.href = '/login'
        }
    });
});