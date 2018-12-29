export const basicChart = {
    type: 'pie',
    options: {
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
