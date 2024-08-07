const tableLista = document.querySelector("#tableListaProductos tbody");
const tblPendientes = document.querySelector('#tblPendientes');
let productosjson = [];
const estadoEnviado = document.querySelector('#estadoEnviado');
const estadoProceso = document.querySelector('#estadoProceso');
const estadoCompletado = document.querySelector('#estadoCompletado');

// Llamar la lista de productos
document.addEventListener("DOMContentLoaded", function() {
    if (tableLista) {
        getListaProductos();
    }
    //Listar Pendientes al datable
    $('#tblPendientes').DataTable({
        ajax: {
            url: base_url + 'clientes/listarPendientes',
            dataSrc: ''
        },
        columns: [
            { data: 'id_transaccion' },
            { data: 'monto' },
            { data: 'fecha' },
            { data: 'accion' }
        ],
        language,
        dom,
        buttons

    });
});

//Listar productos del cliente e implementar la data en el html 
function getListaProductos() {
    let html = '';
    const url = base_url + 'principal/listaProductos';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.send(JSON.stringify(listaCarrito));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res.totalPaypal > 0) {
                res.productos.forEach(producto => {
                    html += `<tr>
                        <td>
                            <img class="img-thumbnail rounded-circle" src="${producto.imagen}" alt="" width="100">
                            </td>
                            <td>${producto.nombre}</td>
                            <td><span class="badge bg-warning">${res.moneda + ' ' + producto.precio}</span></td>
                            <td><span class="badge bg-warning"><h3>${producto.cantidad}</h3></span></td>
                            <td>${producto.subTotal}</td>
                        </tr>`;
                    //Agregrar los productos a paypal en un formato json
                    let json = {
                        "name": producto.nombre,
                        "unit_amount": {
                            "currency_code": res.moneda,
                            "value": producto.precio
                        },
                        "quantity": producto.cantidad
                    }
                    productosjson.push(json);
                });

                //Mostrar productos 
                tableLista.innerHTML = html;
                document.querySelector('#totalProducto').textContent = 'TOTAL A PAGAR: ' + res.moneda + ' ' + res.total;
                botonPaypal(res.totalPaypal, res.moneda);
            } else {
                //De lo contrario visualizar en el html
                tableLista.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">CARRITO VACIO</td>
                </tr>
                `;
            }

        }
    }
}

// Implementación botón de paypal
function botonPaypal(total, moneda) {
    paypal.Buttons({
        createOrder: (data, actions) => {
            return actions.order.create({
                "purchase_units": [{
                    "amount": {
                        "currency_code": moneda,
                        "value": total,
                        "breakdown": {
                            "item_total": { 
                                "currency_code": moneda,
                                "value": total
                            }
                        }
                    },
                    "items": productosjson
                }]
            });
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(function(orderData) {
                registrarPedido(orderData)
            });
        }
    }).render('#paypal-button-container');
}

//Registrar pedido del cliente POST y realizar un reaload.
function registrarPedido(datos) {
    const url = base_url + 'clientes/registrarPedido';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.send(JSON.stringify({
        pedidos: datos,
        productos: listaCarrito
    }));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Swal.fire("Novedad", res.msg, res.icono);
            if (res.icono == 'success') {
                localStorage.removeItem('listaCarrito');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        }
    }
}

//Visualizar pedido cliente GET, implementación en el html y apertura del modal
function verPedido(idPedido) {
    estadoEnviado.classList.remove('bg-info');
    estadoProceso.classList.remove('bg-info');
    estadoCompletado.classList.remove('bg-info');
    const mPedido = new bootstrap.Modal(document.getElementById('modalPedido'));
    const url = base_url + 'clientes/verPedido/' + idPedido;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            //Validación del proceso
            if (res.pedido.proceso == 1) {
                estadoEnviado.classList.add('bg-info');
            } else if (res.pedido.proceso == 2) {
                estadoProceso.classList.add('bg-info');
            } else {
                estadoCompletado.classList.add('bg-info');
            }
            res.productos.forEach(row => {
                let subTotal = parseFloat(row.precio) * parseInt(row.cantidad);
                html += `<tr>
                    <td>${row.producto}</td>
                    <td><span class="badge bg-warning">${res.moneda + ' ' + row.precio}</span></td>
                    <td><span class="badge bg-warning">${row.cantidad}</span></td>
                    <td>${subTotal.toFixed(2)}</td>
                </tr>`;
            });
            document.querySelector('#tablePedidos tbody').innerHTML = html;
            mPedido.show();
        }
    }

}

// Cuenta de prueba para realizar el pago de Paypal 

// CORREO: sb-j6jdb7896999@personal.example.com
// CONTRASEÑA: e8O2lR-I

