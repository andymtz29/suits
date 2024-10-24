// Función para registrar producto
const registrar_producto = () => {
    const nombre_producto = document.getElementById('producto').value;
    const cantidad_producto = document.getElementById('cantidad').value;
    const precio_producto = document.getElementById('precio').value;

    const data = new FormData();
    data.append("producto", nombre_producto);
    data.append("cantidad", cantidad_producto);
    data.append("precio", precio_producto);
    data.append("action", "registrar");

    fetch("./productos.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        alert(respuesta[1]);
        if (respuesta[0] == 1) {
            window.location = "../../index.php"; 
        }
    });
}

// Función para eliminar producto
const eliminar_producto = (id_producto) => {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        const data = new FormData();
        data.append("producto_key", id_producto); 
        data.append("action", "eliminar");

        fetch("./app/controller/productos.php", {
            method: "POST",
            body: data
        }).then(respuesta => respuesta.json())
        .then(respuesta => {
            alert(respuesta[1]); 
            if (respuesta[0] == 1) {
                window.location = "index.php"; 
            }
        });
    }
}

// Función para editar producto
const editar_producto = (precio) => {
    const nombre_producto = document.getElementById('producto').value;
    const cantidad_producto = document.getElementById('cantidad').value;
    const precio_producto = document.getElementById('precio').value;

    const data = new FormData();
    data.append("producto", nombre_producto);
    data.append("cantidad", cantidad_producto);
    data.append("precio", precio_producto);
    data.append("action", "editar");

    fetch("./productos.php?id=" + precio, { 
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        alert(respuesta[1]);
        if (respuesta[0] == 1) {
            window.location = "../../index.php"; 
        }
    });
}

$(document).ready(function() {
    $('#myTable').DataTable({
        language: {
            url: './public/json/lenguaje.json'
        }
    });
});