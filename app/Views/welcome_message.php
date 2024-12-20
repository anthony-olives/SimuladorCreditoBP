<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Crédito - Banco Pichincha</title>
    <link rel="stylesheet" href="public/Css/styles.css">
</head>
<body>
    <header>
        <p>Banco Pichincha</p>
    </header>

    <main>
        <section class="simulador">
            <form id="simulador-form">
                <div class="campo">
                    <label for="monto">Ingresa el monto a invertir</label>
                    <input type="number" id="monto" name="monto" placeholder="$0,00" required>
                </div>

                <div class="campo">
                    <label for="podras">Podrás invertir entre $500 y $100,000,000</label>
                </div>

                <div class="campo">
                    <label for="plazo">Selecciona el tipo de plazo:</label>
                </div>

                <!-- Tabs para seleccionar Meses o Días -->
                <div class="tabs">
                    <button type="button" id="meses-tab" class="tab-button">Meses</button>
                    <button type="button" id="dias-tab" class="tab-button">Días</button>
                </div>

                <!-- Contenedor de opciones de meses (por defecto visible) -->
                <div id="meses-container" class="tab-container">
                    <div class="tab-option" data-plazo="12">12</div>
                    <div class="tab-option" data-plazo="9">9</div>
                    <div class="tab-option" data-plazo="6">6</div>
                    <button type="button" id="otro-plazo-meses">Otro Plazo</button>
                </div>

                <!-- Contenedor de opciones de días (inicialmente oculto) -->
                <div id="dias-container" class="tab-container hidden">
                    <div class="tab-option" data-plazo="91">91</div>
                    <div class="tab-option" data-plazo="61">61</div>
                    <div class="tab-option" data-plazo="31">31</div>
                    <button type="button" id="otro-plazo-dias">Otro Plazo</button>
                </div>

                <!-- Label donde se mostrará el resultado -->
                <div class="campo">
                    <label id="resultado">En <span class="plazo">12 meses</span> recibirás <span class="monto">$0,00</span><br><span class="interes">Con un interés del 6%</span></label>
                </div>

                <div class="campo">
                    <button type="submit">Invertir ahora</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Banco Pichincha - Todos los derechos reservados.</p>
    </footer>

    <script>
        // Variables para los elementos del DOM
        const mesesTab = document.getElementById('meses-tab');
        const diasTab = document.getElementById('dias-tab');
        const mesesContainer = document.getElementById('meses-container');
        const diasContainer = document.getElementById('dias-container');
        const resultadoLabel = document.getElementById('resultado');
        const montoInput = document.getElementById('monto');

        let plazoSeleccionado = 12; // Valor predeterminado (en meses)
        let tasaInteres = 6; // Tasa de interés predeterminada del 6%

        // Mostrar y ocultar contenedores de pestañas (Tabs)
        mesesTab.addEventListener('click', () => {
            mesesContainer.classList.remove('hidden');
            diasContainer.classList.add('hidden');
        });

        diasTab.addEventListener('click', () => {
            diasContainer.classList.remove('hidden');
            mesesContainer.classList.add('hidden');
        });

        // Selección de plazo (Meses o Días)
        const selectPlazo = (plazo) => {
            plazoSeleccionado = plazo;
            actualizarResultado();
        };

        // Asignar eventos a los botones de plazo en meses
        const mesesOptions = mesesContainer.querySelectorAll('.tab-option');
        mesesOptions.forEach(option => {
            option.addEventListener('click', () => {
                selectPlazo(parseInt(option.getAttribute('data-plazo')));
            });
        });

        // Asignar eventos a los botones de plazo en días
        const diasOptions = diasContainer.querySelectorAll('.tab-option');
        diasOptions.forEach(option => {
            option.addEventListener('click', () => {
                selectPlazo(parseInt(option.getAttribute('data-plazo')));
            });
        });

        // Actualizar el resultado del cálculo
        const actualizarResultado = () => {
            const monto = parseFloat(montoInput.value);
            if (isNaN(monto) || monto <= 0) {
                resultadoLabel.innerHTML = `Por favor, ingresa un monto válido.`;
                return;
            }

            let montoFinal;
            if (mesesContainer.classList.contains('hidden')) {
                // Cálculo basado en días
                const dias = plazoSeleccionado;
                montoFinal = monto * (1 + (tasaInteres / 100) * (dias / 365));
            } else {
                // Cálculo basado en meses
                const meses = plazoSeleccionado;
                montoFinal = monto * (1 + (tasaInteres / 100) * (meses / 12));
            }

            // Mostrar el resultado en el label con el formato adecuado
            resultadoLabel.innerHTML = `En <span class="plazo">${plazoSeleccionado} ${mesesContainer.classList.contains('hidden') ? 'días' : 'meses'}</span> recibirás <span class="monto">$${montoFinal.toFixed(2)}</span><br><span class="interes">Con un interés del ${tasaInteres}%</span>`;
        };

        // Actualizar el resultado cuando se ingresa un monto
        montoInput.addEventListener('input', actualizarResultado);

        // Llamar a la función para inicializar el resultado al cargar
        actualizarResultado();

    </script>
</body>
</html>
