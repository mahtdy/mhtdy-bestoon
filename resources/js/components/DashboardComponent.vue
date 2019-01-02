<template>
    <!--  Container -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!--  Dashboard Cart -->
                <div class="card text-right">
                    <div class="card-header">داشبورد</div>

                    <!--  Dashboard Body -->
                    <div v-if="isLoading" class="isloading">
                        <h2 class="text-center h2 text-primary">درحال پردازش اطلاعات ...</h2>
                    </div>

                    <div class="card-body">
                        <!-- Warning -->
                        <div v-if="warning" class="alert alert-warning shadow-sm">
                            <strong> مواظب باش! </strong>
                            <small>پس انداز این ماه در خطره.</small>
                        </div>
                        <!-- Income And Expense Status -->

                        <table class="table table-bordered table-info text-center shadow">
                            <thead>
                            <tr>
                                <th scope="col">میـزان درآمد یک ماه</th>
                                <th scope="col">میـزان هزینه یک ماه</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ monthIncome }} ریال</td>
                                <td>{{ monthExpense }} ریال</td>
                            </tr>
                            </tbody>
                        </table>

                        <!--  Dashboard Chart -->
                        <div class="col-md-12">
                            <canvas id="basicChart" width="1024" height="480"
                                    style="width: 1024px; height: 480px;"></canvas>
                        </div>
                        <!--  End Dashboard Chart -->
                        <hr>

                        <!--  Dashboard Forms -->
                        <div class="row">

                            <!--  New Income Form -->
                            <div class="col-md-6 mb-3">
                                <div class="card shadow rounded">
                                    <div class="card-header ">
                                        <h3 class="text-center">ثبت درآمد جدید</h3>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent>
                                            <div class="form-group">
                                                <input type="text" class="form-control" required
                                                       placeholder="عنوان درآمد" v-model="inctitle">
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control" required
                                                       placeholder="مقدار درآمد به ریال"
                                                       v-model="incamount">
                                            </div>
                                            <button type="submit" class="btn btn-success btn-block mb-2"
                                                    @click="saveIncome">ذخیره
                                            </button>
                                            <button type="reset" class="btn btn-light btn-block">خالی کردن فرم</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--  End Income Form -->

                            <!--  New Expense Form -->
                            <div class="col-md-6">
                                <div class="card shadow rounded">
                                    <div class="card-header">
                                        <h3 class="text-center">ثبت هزینه جدید</h3>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent>
                                            <div class="form-group">
                                                <input type="text" class="form-control" required
                                                       placeholder="عنوان هزینه" v-model="extitle">
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control" required
                                                       placeholder="مقدار هزینه به ریال"
                                                       v-model="examount">
                                            </div>
                                            <button @click="saveExpense" type="submit"
                                                    class="btn btn-primary btn-block mb-2">ذخیره
                                            </button>
                                            <button type="reset" class="btn btn-light btn-block">خالی کردن فرم</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--  End Expense Form -->
                            <div class="col-md-6">
                                <h4 class="text-center h4 mt-3 mb-3">لیست آخرین درآمد ها</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="row">#</th>
                                        <th scope="col">عنوان درآمد</th>
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">تاریخ ثبت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(income, index) in incomes" :key="index">
                                        <td class="btn-link text-danger" @click="deleteIncome(income.id)"
                                            style="cursor: pointer">{{ index+1 }}
                                        </td>
                                        <td class="btn-link" @click="editIncome(income.id)" style="cursor: pointer">{{
                                            income.title }}
                                        </td>
                                        <td>{{ income.amount }} ریال</td>
                                        <td>
                                            {{ income.created_diff }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-center h4 mt-3 mb-3">لیست آخرین هزینه ها</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="row">#</th>
                                        <th scope="col">عنوان هزینه</th>
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">تاریخ ثبت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(expense, index) in expenses" :key="index">
                                        <td class="btn-link text-danger" @click="deleteExpense(expense.id)"
                                            style="cursor: pointer">{{ index+1 }}
                                        </td>
                                        <td class="btn-link" @click="editExpense(expense.id)" style="cursor: pointer">{{
                                            expense.title }}
                                        </td>
                                        <td>{{ expense.amount }} ریال</td>
                                        <td>{{ expense.created_diff }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    // Custom Functions
    function eArabic(x) {
        return x.toLocaleString('ar-EG');
    }

    // Imports
    import basicChart from '../Charts/basicchart';
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import moment from 'moment';

    // Vue Codes
    export default {
        data() {
            return {
                monthExpense: '',
                monthIncome: '',
                basicChart: basicChart,
                inctitle: '',
                incamount: '',
                extitle: '',
                examount: '',
                warning: false,
                isLoading: true,
                incomes: [],
                expenses: [],
            }
        },
        methods: {
            // Creating A Chart
            createChart(chartId, chartData) {
                axios.get('/iande').then(async response => {
                    let incomes = response.data.totalIncomes;
                    let expenses = response.data.totalExpenses;
                    const ctx = document.getElementById(chartId);
                    const myChart = new Chart(ctx, {
                        type: chartData.type,
                        data: {
                            labels: ["درآمد ها", "هزینه ها"],
                            datasets: [{

                                backgroundColor: ["#3e95cd", "#EC407A"],
                                data: [incomes, expenses]
                            }]
                        },
                        options: chartData.options,
                    });
                    Chart.defaults.global.defaultFontFamily = "'Shabnam'";
                });
            },

            // Saving A New Income
            saveIncome() {
                if (this.inctitle != '' && this.incamount != '') {
                    if (confirm('آیا اطمینان دارید ؟')) {
                        axios.post('/newIncome', {
                            title: this.inctitle,
                            amount: this.incamount
                        });
                        flash('درآمد جدید با موفقیت ثبت شد.');
                        this.setIncomesAndExpenses();
                        this.createChart('basicChart', this.basicChart);
                        this.getStatusOfMonth();
                    }
                } else {
                    alert('لطفا تمامی موارد را پر کنید!')
                }
            },

            // Saving A New Expense
            saveExpense() {
                if (this.extitle != '' && this.examount != '') {
                    if (confirm('آیا اطمینان دارید ؟')) {
                        axios.post('/newExpense', {
                            title: this.extitle,
                            amount: this.examount
                        });
                        flash('هزینه جدید با موفقیت ثبت شد.');
                        this.createChart('basicChart', this.basicChart);
                        this.getStatusOfMonth();
                        this.setIncomesAndExpenses();
                    }
                } else {
                    alert('لطفا تمامی موارد را پر کنید!')
                }
            },

            // Getting Status Of This Month
            getStatusOfMonth() {
                const self = this;

                axios.get('/iande').then(data => {
                    self.monthIncome = eArabic(data.data.totalIncomes);
                    self.monthExpense = eArabic(data.data.totalExpenses);
                    if (data.data.totalIncomes != 0 && data.data.totalExpenses != 0) {
                        if (data.data.totalIncomes / 2 <= data.data.totalExpenses) {
                            self.warning = true;
                        } else {
                            self.warning = false;
                        }
                    }

                });
            },

            // Setting Incomes And Expenses
            setIncomesAndExpenses() {
                axios.get('/iandeList').then(res => {
                    this.incomes = res.data.incomes;
                    this.expenses = res.data.expenses;

                });
            },

            // Edit Modals

            editIncome(incomeID) {
                let income = this.incomes.find(x => x.id === incomeID);
                Swal.mixin({
                    input: 'text',
                    confirmButtonText: 'بعدی &larr;',
                    showCancelButton: true,
                    progressSteps: ['1', '2']
                }).queue([
                    {
                        title: "مرحله 1",
                        text: 'عنوان جدید را بنویسید یا بر روی ادامه کلیک کنید',
                        inputValue: income.title,
                    },
                    {
                        title: "مرحله 2",
                        text: 'مبلغ جدید را بنویسید یا بر روی بعدی کلیک کنید',
                        inputValue: income.amount,
                    }
                ]).then((result) => {
                    if (result.value) {
                        if (result.value[0] != "" && result.value[1] != "") {
                            axios.post('/editIncome', {
                                id: incomeID,
                                title: result.value[0],
                                amount: result.value[1]
                            }).then(() => {
                                console.log('Requested');
                                this.createChart('basicChart', this.basicChart);
                                this.getStatusOfMonth();
                                this.setIncomesAndExpenses();
                            }).catch(err => {
                                console.log(err)
                            });
                        }
                        Swal({
                            title: 'تمام شد!',
                            type: 'success',
                            confirmButtonText: 'تشکر'
                        })
                    }
                })
            },

            editExpense(expenseID) {
                let expense = this.expenses.find(x => x.id === expenseID);
                Swal.mixin({
                    input: 'text',
                    confirmButtonText: 'بعدی &larr;',
                    showCancelButton: true,
                    progressSteps: ['1', '2']
                }).queue([
                    {
                        title: "مرحله 1",
                        text: 'عنوان جدید را بنویسید یا بر روی ادامه کلیک کنید',
                        inputValue: expense.title
                    },
                    {
                        title: "مرحله 2",
                        text: 'مبلغ جدید را بنویسید یا بر روی بعدی کلیک کنید',
                        inputValue: expense.amount
                    }
                ]).then((result) => {
                    if (result.value) {
                        if (result.value[0] != "" && result.value[1] != "") {
                            console.log('Requested');
                            axios.post('/editExpense', {
                                id: expenseID,
                                title: result.value[0],
                                amount: result.value[1]
                            }).then(() => {
                                this.createChart('basicChart', this.basicChart);
                                this.getStatusOfMonth();
                                this.setIncomesAndExpenses();
                            }).catch(err => {
                                console.log(err)
                            });
                        }
                        Swal({
                            title: 'تمام شد!',
                            type: 'success',
                            confirmButtonText: 'تشکر'
                        })
                    }
                })
            },

            // Delete Expense And Income
            deleteIncome(incomeID) {
                const self = this;
                const swalWithBootstrapButtons = Swal.mixin({
                    confirmButtonClass: 'btn btn-success mr-3',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'آیا اطمینان دارید ؟',
                    text: "اطمینان دارید که این مورد حذف شود ؟",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله حذفش کن',
                    cancelButtonText: 'لغو',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {

                        axios.post('/deleteIncome', {
                            id: incomeID
                        }).then(() => {
                            swalWithBootstrapButtons(
                                'حذف شد !',
                                'این مورد با موفقیت حذف شد.',
                                'success'
                            );
                            self.createChart('basicChart', self.basicChart);
                            self.getStatusOfMonth();
                            self.setIncomesAndExpenses();
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'لغو شد!',
                            'این مورد حذف نشد :)',
                            'error'
                        )
                    }
                })
            },

            deleteExpense(expenseID) {
                const self = this;
                const swalWithBootstrapButtons = Swal.mixin({
                    confirmButtonClass: 'btn btn-success mr-3',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'آیا اطمینان دارید ؟',
                    text: "اطمینان دارید که این مورد حذف شود ؟",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله حذفش کن',
                    cancelButtonText: 'لغو',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {

                        axios.post('/deleteExpense', {
                            id: expenseID
                        }).then(() => {
                            swalWithBootstrapButtons(
                                'حذف شد !',
                                'این مورد با موفقیت حذف شد.',
                                'success'
                            );
                            self.createChart('basicChart', self.basicChart);
                            self.getStatusOfMonth();
                            self.setIncomesAndExpenses();
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'لغو شد!',
                            'این مورد حذف نشد :)',
                            'error'
                        )
                    }
                })
            }

        },
        mounted() {

            // Loading Page
            setTimeout(() => {
                this.isLoading = false;
            }, 2500);

            // On Time Functions
            this.createChart('basicChart', this.basicChart);
            this.getStatusOfMonth();
            this.setIncomesAndExpenses();
        }
    }
</script>

<style scoped>
    .isloading {
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: #fefefe;
        z-index: 10;
    }

    .isloading h2 {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
