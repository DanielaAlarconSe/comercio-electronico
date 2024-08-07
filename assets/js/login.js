const btnRegister = document.querySelector("#btnRegister");
const btnLogin = document.querySelector("#btnLogin");
const frmLogin = document.querySelector("#frmLogin");
const frmRegister = document.querySelector("#frmRegister");
const registrarse = document.querySelector("#registrarse");
const login = document.querySelector("#login");
const nombreRegistro = document.querySelector("#nombreRegistro");
const claveRegistro = document.querySelector("#claveRegistro");
const correoRegistro = document.querySelector("#correoRegistro");
const correoLogin = document.querySelector("#correoLogin");
const claveLogin = document.querySelector("#claveLogin");
const inputBusqueda = document.querySelector("#search");

//Alternar visibilidad entre los formularios de inicio de sesión y registro al hacer clic en los botones correspondientes
document.addEventListener("DOMContentLoaded", function () {
  btnRegister.addEventListener("click", function () {
    frmLogin.classList.add("d-none");
    frmRegister.classList.remove("d-none");
  });
  btnLogin.addEventListener("click", function () {
    frmRegister.classList.add("d-none");
    frmLogin.classList.remove("d-none");
  });
  //registro
  registrarse.addEventListener("click", function () {
    if (
      nombreRegistro.value == "" ||
      correoRegistro.value == "" ||
      claveRegistro.value == ""
    ) {
      Swal.fire("Campos Requeridos", "TODOS LOS CAMPOS SON REQUERIDOS", "warning");
    } else {
      //Asignación de la data y registro POST
      let formData = new FormData();
      formData.append("nombre", nombreRegistro.value);
      formData.append("clave", claveRegistro.value);
      formData.append("correo", correoRegistro.value);
      const url = base_url + "clientes/registroDirecto";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(formData);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Swal.fire("Transacción Exitosa", res.msg, res.icono);
          if (res.icono == "success") {
            setTimeout(() => {
              enviarCorreo(correoRegistro.value, res.token);
            }, 2000);
          }
        }
      };
    }
  });
  //login 
  login.addEventListener("click", function () {
    if (correoLogin.value == "" || claveLogin.value == "") {
      Swal.fire("Campos Requeridos", "TODOS LOS CAMPOS SON REQUERIDOS", "warning");
    } else {
      let formData = new FormData();
      formData.append("correoLogin", correoLogin.value);
      formData.append("claveLogin", claveLogin.value);
      const url = base_url + "clientes/loginDirecto";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(formData);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Swal.fire("Inicio Exitoso", res.msg, res.icono);
          if (res.icono == "success") {
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          }
        }
      };
    }
  });

  //Búsqueda de productos y visualizar en el html
  inputBusqueda.addEventListener("keyup", function (e) {
    if (e.target.value != "") {
      const url = base_url + "principal/busqueda/" + e.target.value;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          let html = "";
          res.forEach((producto) => {
            html += `<div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                      <a href="#">
                        <img src="${producto.imagen}" class="card-img-top" alt="${producto.nombre}">
                      </a>
                      <div class="card-body">
                        <a href="#" class="h2 text-decoration-none text-dark">${producto.nombre}</a>
                        <p class="card-text">
                        $${producto.precio}
                        </p>
                        <div class="buy_bt"><a href="#" onclick="agregarCarrito(${producto.id}, 1)">Añadir</a></div>
                      </div>
                    </div>
                  </div>`;
          });
          document.querySelector("#resultBusqueda").innerHTML = html;
        }
      };
    }else{
        document.querySelector('#resultBusqueda').innerHTML = '';
    }
  });
});

//Enviar correo de confirmación POST
function enviarCorreo(correo, token) {
  let formData = new FormData();
  formData.append("token", token);
  formData.append("correo", correo);
  const url = base_url + "clientes/enviarCorreo";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      Swal.fire("Novedad", res.msg, res.icono);
      if (res.icono == "success") {
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      }
    }
  };
}

// Apertura modal de logeo
function abrirModalLogin() {
  $('#modalCarrito').modal('hide')
  $('#modalLogin').modal('show')
}
