document.addEventListener('DOMContentLoaded', function() {
    const btnConsultar = document.getElementById('btn_consultar');

    if (btnConsultar) {
        btnConsultar.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const token = this.getAttribute('data-token');

            // Capturar por ID
            const po = document.getElementById('purchase_order').value;
            const mn = document.getElementById('material_number').value;

            if (!po || !mn) {
                alert("Ingresa Purchase Order y Material No.");
                return;
            }

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ 
                    purchase_order: po, 
                    material_number: mn 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data && !data.error) {
                    // Rellenar campos automáticamente usando los IDs
                    document.getElementById('quantity').value = data.total_quantity;
                    document.getElementById('batch').value = data.primary_batch;
                    document.getElementById('delivery_date').value = data.delivery_date;
                    if(document.getElementById('batches')) document.getElementById('batches').value = data.extra_batches_list;
                } else {
                    alert(data.error || "No se encontraron registros.");
                }
            })
            .catch(error => alert("Error de comunicación con SAP."));
        });
    }
});