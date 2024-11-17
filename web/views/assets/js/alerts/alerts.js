//FORMATEAR ENVIO DE FORMULARIO LADO SERVIDOR

function fncFormatInputs() {
    if (window.history.replaceState) {
        window - history.replaceState(null, null, window.location.href);
    }
}

// Alerta Notie
function fncNotie(type, text) {
    notie.alert({
        type: type,
        text: text,
        time: 10
    })
}


// Alerta SweetAlert

function fncSweetAlert(type, text, url) {
    switch (type) {
        case "error":
            if (url == "") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: text
                })




            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: text
                }).then((result) => {
                    if (result.value) {
                        window.open(url, "top");
                    }
                })
            }

            break;
        case "success":
            if (url == "") {
                Swal.fire({
                    icon: "success",
                    title: "Bienvenido",
                    text: text
                })
          

            } else {
                Swal.fire({
                    icon: "success",
                    title: "Bienvenido",
                    text: text
                }).then((result) => {
                    if (result.value) {
                        window.open(url, "top");
                    }
                })
            }

            break;
        case "loading":
            if (url == "") {
                Swal.fire({
                    allwOutsideClick: false,
                    icon: "info",
                    text: text
                })

                Swal.showLoading();
                break;

            }
    }
}

//ALERTA TOASTR
function fncToastr(type, text) {

    var toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter ', Swal.stopTimer)
            toast.addEventListener('mouseleave ', Swal.resumeTimer)

        }
    })

    toast.fire({
        icon: type,
        title: text
    })
}


// ALERTA LINEA PRECARGA
function fncMatPreloader(type) {
    var preloader = new $.materialPreloader({
        position: "top",
        height: "5px",
        col_1: "#159756",
        col_2: "#da4733",
        col_3: "#3b78e7",
        col_4: "#fdba2c",
        fadeIn: 200,
        fadeOut: 200
    })

    if (type == "on") {
        preloader.on();
    }
    if (type == "off") {
        $(".load-bar-container").remove();
    }
}
