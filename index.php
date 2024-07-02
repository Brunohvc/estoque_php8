<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Stock</title>
</head>
<body>

    <button id="updateButton">Update Stock</button>
    <p id="itemCountLabel">Número de itens: 0</p>

    <script>
        // Function to update item count label
        async function updateItemCount() {
            try {
                const response = await fetch('stock.php');
                if (response.ok) {
                    const itemCount = await response.text();
                    document.getElementById('itemCountLabel').innerText = 'Número de itens: ' + itemCount;
                } else {
                    console.error('Failed to fetch item count');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Call the function to update item count when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateItemCount();
        });

        document.getElementById('updateButton').addEventListener('click', async function () {
            const jsonProdutos = [
                {
                    produto: "10.01.0419",
                    cor: "00",
                    tamanho: "P",
                    deposito: "DEP1",
                    data_disponibilidade: "2023-05-01",
                    quantidade: 15
                },
                {
                    produto: "11.01.0568",
                    cor: "08",
                    tamanho: "P",
                    deposito: "DEP1",
                    data_disponibilidade: "2023-05-01",
                    quantidade: 2
                },
                {
                    produto: "11.01.0568",
                    cor: "08",
                    tamanho: "M",
                    deposito: "DEP1",
                    data_disponibilidade: "2023-05-01",
                    quantidade: 4
                },
                {
                    produto: "11.01.0568",
                    cor: "08",
                    tamanho: "G",
                    deposito: "1",
                    data_disponibilidade: "2023-05-01",
                    quantidade: 6
                },
                {
                    produto: "11.01.0568",
                    cor: "08",
                    tamanho: "P",
                    deposito: "DEP1",
                    data_disponibilidade: "2023-06-01",
                    quantidade: 8
                }
            ];
            
            try {
              const jsonProdutosString = JSON.stringify(jsonProdutos);
                const response = await fetch('stock.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'jsonProdutos=' + encodeURIComponent(jsonProdutosString)
                });

                if (response.ok) {
                    const text = await response.text();
                    alert(text);
                    // Update the item count after updating stock
                    updateItemCount();
                } else {
                    console.error('Failed to update stock');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>

</body>
</html>
