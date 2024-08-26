(function() {
  
  const ctx = document.querySelector("#regalos-grafica");
  if(ctx) {
    
    fetch("/api/regalos")
    .then(res => res.json())
    .then( res => {
        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: res.map( regalo => regalo.nombre),
            datasets: [{
                data: res.map( regalo => regalo.total),
                borderWidth: 1,
                backgroundColor: [
                    '#ea580c',
                    '#84cc16',
                    '#22d3ee',
                    '#a855f7',
                    '#ef4444',
                    '#14b8a6',
                    '#db2777',
                    '#e11d48',
                    '#7e22ce'
                ]
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
            }
        });
    });
}

})();