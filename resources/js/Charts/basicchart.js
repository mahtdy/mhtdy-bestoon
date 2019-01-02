export const basicChart = {
    type: 'pie',
    options: {
        tooltips: {
            enabled: true,
            mode: 'single',
            callbacks: {
                label: function (tooltipItem, data) {
                    var label = data.labels[tooltipItem.index];
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return label + ': ' + datasetLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " ریال";
                }
            }
        },
        title: {
            display: true,
            text: 'گزارش میزان هزینه ها و درآمد های شما در 30 روز گذشته'
        },
        responsive: true,
        legend: {
            position: 'top',
        },
        hover: {
            mode: 'label'
        }
    }
};

export default basicChart;
