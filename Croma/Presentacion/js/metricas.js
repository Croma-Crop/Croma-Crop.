var graficoEquipos = document.getElementById("grafico-equipos");

if (graficoEquipos !== null) {
    new Chart(graficoEquipos, {
        type: "bar",
        data: {
            labels: nombresEquipos,
            datasets: [{
                data: totalesEquipos,
                backgroundColor: "#30364f"
            }]
        },
        options: {
            indexAxis: "y",
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { ticks: { precision: 0 } }
            }
        }
    });
}
