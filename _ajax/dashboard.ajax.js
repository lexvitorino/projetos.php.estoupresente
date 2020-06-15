if (typeof noAno !== "undefined") {
    var grafic1 = new Chart(document.getElementById("grafic1"), {
        type: 'line',
        data: {
            labels: noAno,
            datasets: dataSets
        }
    });
}