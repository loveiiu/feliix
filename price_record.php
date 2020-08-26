<?php include 'check.php';?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daily Expense</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/hierarchy-select.min.css" type="text/css">
    <link rel="stylesheet" href="css/vue-select.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">


    <style>
        th {
            text-align: center;
        }

        td {
            text-align: center;
            vertical-align: middle !important;
            font-size: small;
        }
        .red{
            color: #ff0000;
        }

    </style>


    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/hierarchy-select.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


</head>

<body>


<div id="app">
<div style="background: rgb(2,106,167); padding: 0.5vh; height:7.5vh;">
    <a href="" style="margin-left:1vw; position: relative; top:-10%;" ><span style="color: white;">&#9776;</span></a>

    <span style="margin-left:1vw; font-weight:700; font-size:xx-large; color: white;">FELIIX</span>

    <button style="border: none; margin-left:0.5vw; font-weight:700; font-size:x-large; background-color:rgb(2,106,167); color: white; padding: 0.5rem 0.5rem 0.5rem 0.5rem; float:right; margin-right:1rem;"
            data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                       aria-expanded="true" aria-controls="collapseOne"><i class="fas fa-plus-square fa-lg"></i></button>

</div>




<div style="margin-top:2.5vh; margin-left:1.5vw; margin-bottom:3vh;">



<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="width:98.5%;">

        <div class="panel panel-default">

            <div class="panel-heading" role="tab" id="headingOne"
                 style="border: 3px solid rgb(222,226,230); padding:0.5% 0 0.2% 1%;">

                <h4 class="panel-title">

                    <span
                       style="font-size: 18px;">Add & Edit Record</span>

                </h4>
            </div>

            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

                <div class="panel-body" style="border: 3px solid rgb(222,226,230); border-top:none;">


                    <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                        <div style="margin-bottom: -1.5vh;">&nbsp</div>

                        <tr>
                            <td style="width:15vw;">
                                <label>Date</label>
                            </td>

                            <td style="text-align: left;"><input type="date" class="form-control custom-control-inline"
                                                                 style="width:15vw;" id="todays-date" readonly></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Account</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:15vw;" v-model="account">
                                    <option>----------------------------------</option>
                                    <option value="1">Security Bank</option>
                                    <option value="2">Office Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <label>Operation Type</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:15vw;" v-model="operation_type">
                                    <option>----------------------------------</option>
                                    <option value="1">Cash In</option>
                                    <option value="2">Cash Out</option>
                                </select>
                            </td>

                        </tr>


                        <tr>
                            <td>
                                <label>Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;" v-model="category">
                                    <option>Accounting and govt payments</option>
                                    <option>Bills</option>
                                    <option>Client Refunds</option>
                                    <option>Consignment</option>
                                    <option>Credit Card</option>
                                    <option>Marketing</option>
                                    <option>Misc</option>
                                    <option>Office Needs</option>
                                    <option>Others</option>
                                    <option>Projects</option>
                                    <option>Rental</option>
                                    <option>Salary</option>
                                    <option>Sales Petty Cash</option>
                                    <option>Store</option>
                                    <option>Transportation Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr v-if="category == 'Marketing' || category == 'Office Needs' || category == 'Others' || category ==  'Projects' || category == 'Store'">
                            <td>
                                <label >Sub Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;"v-model="sub_category">
                                    <option>Allowance</option>
                                    <option>Commission</option>
                                    <option>Delivery</option>
                                    <option>Maintenance</option>
                                    <option>Meals</option>
                                    <option>Misc</option>
                                    <option>Others</option>
                                    <option>Outsource</option>
                                    <option>Petty cash</option>
                                    <option>Products</option>
                                    <option>Supplies</option>
                                    <option>Tools and Materials</option>
                                    <option>Transportation</option>
                                </select>
                            </td>

                        </tr>


                        <tr id="relatedaccount">
                            <td>
                                <label>Related Account</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:15vw;" v-model="related_account">
                                    <option value="None">None</option>
                                    <option>Security Bank</option>
                                    <option>Office Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr id="payee">
                            <td>
                                <label>Payee</label>
                            </td>

                            <td style="text-align: left;">

                                <div class="form-control" style="width:15vw;">
                                    <v-select v-model="payee"
                                              :options="payees"
                                              attach
                                              chips
                                              label="payeeName"
                                              multiple></v-select>
                                </div>

                            </td>

                        </tr>


                        <tr>
                            <td style="width:15vw;">
                                <label>Paid/Received Date</label>
                            </td>

                            <td style="text-align: left;"><input type="date" class="form-control custom-control-inline"
                                                                 style="width:15vw;" v-model="paid_date"></td>

                        </tr>


                        <tr>
                            <td style="width:15vw;">
                                <label>Amount</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control custom-control-inline"
                                                                 style="width:15vw;" v-model="amount"></td>

                        </tr>

                        <tr>Fund Transfer
                            <td>
                                <label>Details</label>
                            </td>

                            <td style="text-align: left; width:70vw;"><textarea class="form-control" rows="2"
                                                                               style="width:77vw;" v-model="details"></textarea></td>

                        </tr>



                        <tr>
                            <td>
                                <label>Remarks</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control" style="width:77vw;" v-model="remarks">
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <label>Photos</label>
                            </td>

                            <td style="text-align: left;"><input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" accept="image/*" capture="camera">
                            </td>

                        </tr>


                        <tr>
                            <td>

                            </td>

                            <td style="text-align: left;"><input type="checkbox" style="margin-right:0.5vw; " v-model="is_marked">Mark this record with special font color
                            </td>

                        </tr>



                    </table>

                    <div style="margin-left:6vw; margin-top:2vh; margin-bottom:1.5vh;">

                        <button class="btn btn-secondary" style="width:10vw; font-weight:700" v-on:click="reset(1)">Reset
                        </button>

                        <button class="btn btn-secondary" style="width:10vw; font-weight:700; margin-left:2vw;" href="#collapseOne" v-on:click="reset(2)">Cancel
                        </button>

                        <button class="btn btn-primary" style="width:10vw; font-weight:700; margin-left:2vw;" v-on:click="add(1,edd)" >Save
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div style="margin-top:2vh;">

        <input type="date" v-model="start_date">&nbsp; to &nbsp;<input type="date" v-model="end_date">


        <select style="width:10vw; margin-left:1vw;" v-model="category">
            <option>Accounting and govt payments</option>
            <option>Bills</option>
            <option>Client Refunds</option>
            <option>Consignment</option>
            <option>Credit Card</option>
            <option>Marketing</option>
            <option>Misc</option>
            <option>Office Needs</option>
            <option>Others</option>
            <option>Projects</option>
            <option>Rental</option>
            <option>Salary</option>
            <option>Sales Petty Cash</option>
            <option>Store</option>
            <option>Transportation Petty Cash</option>
        </select>

        <select style="width:10vw; margin-left:1vw;" v-if="category == 'Marketing' || category == 'Office Needs' || category == 'Others' || category ==  'Projects' || category == 'Store'" v-model="sub_category">
            <option>Allowance</option>
            <option>Commission</option>
            <option>Delivery</option>
            <option>Maintenance</option>
            <option>Meals</option>
            <option>Misc</option>
            <option>Others</option>
            <option>Outsource</option>
            <option>Petty cash</option>
            <option>Products</option>
            <option>Supplies</option>
            <option>Tools and Materials</option>
            <option>Transportation</option>
        </select>

        <select v-model="perPage" v-on:change="getRecords(this)">
            <option v-for="size in inventory" :value="size.id">{{size.name}}</option>
        </select>

        <button style="margin-left:1.5vw;" v-on:click="getRecords"><i class="fas fa-filter"></i></button>&ensp;
        <button v-on:click="printRecord"><i class="fas fa-file-export"></i></button>&ensp;


        <ul class="pagination pagination-sm" style="float:right; margin-right:1.5vw;">
                <li class="page-item" :disabled="page == 1"  @click="page < 1 ? page = 1 : page--" v-on:click="getRecords"><a class="page-link">Previous</a></li>

                <li class="page-item" v-for="pg in pages" @click="page=pg" :class="[page==pg ? 'active':'']" v-on:click="getRecords"><a class="page-link" >{{ pg }}</a></li>

                <li class="page-item" :disabled="page == pages.length" @click="page++" v-on:click="getRecords"><a class="page-link" >Next</a></li>
            </ul>

    </div>


    <div id="panelchecked">

        <table class="table table-sm table-bordered table-hover" style="width:97vw;">

            <thead class="thead-light">



            <tr>

                <th colspan="10" style="font-size:larger; font-weight:700;">Office Petty Cash</th>
            </tr>

            <tr>


                <th class="text-nowrap" style="width:6vw;">Date</th>

                <th class="text-nowrap" style="width:10vw;">Category</th>

                <th class="text-nowrap" style="width:20vw;">Details</th>

                <th class="text-nowrap" style="width:4vw;">Photos</th>

                <th class="text-nowrap" style="width:10vw;">Payee</th>

                <th style="width:8vw;">Paid / Received Date</th>

                <th class="text-nowrap" style="width:7vw;">Cash In</th>

                <th class="text-nowrap" style="width:7vw;">Cash Out</th>

                <th class="text-nowrap" style="width:12vw;">Remarks</th>

                <th class="text-nowrap" style="width:6vw;">Actions</th>


            </tr>

            </thead>

            <tbody >
             <tr v-for='item in items' v-if="item.account == 1" :class="[item.is_marked == '1' ? 'red' : '']">
                <td>{{item.paid_date}}</td>

                <td>{{item.category}}</td>

                <td style="text-align: left;">{{item.details}}</td>

                 <td><a :href="`${mail_ip}/img/${item.pic_url}`" target="_blank"><i class="fas fa-image fa-lg" ></i></a></td>

                <td>{{item.payee}}</td>

                <td>{{item.paid_date}}</td>

                <td style="text-align: right;">{{item.cash_in}}</td>

                <td style="text-align: right;">{{item.cash_out}}</td>


                <td style="text-align: left;">{{item.remarks}}</td>


                 <td class="text-nowrap" v-if="is_viewer == '1'">
                     <button><i class="fas fa-lock" :class="[item.is_locked == '1'? red:''] v-on:click="update(item.id,1)""></i></button>
                 </td>
                 <td class="text-nowrap" v-else-if="!item.is_locked == '0'">
                     <button data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                             aria-expanded="true" aria-controls="collapseOne" v-on:click="edit(item.id)"><i class="fas fa-edit"></i>
                     </button>


                     <button data-toggle="modal"
                             data-target="#exampleModalScrollable" v-on:click="edit(item.id)"><i class="fas fa-project-diagram"></i>
                     </button>



                     <button v-on:click="deleteRecord(item.id)"><i class="fas fa-times"></i></button>

                 </td>
                 <td class="text-nowrap" v-else>
                 </td>

            </tr>
            </tbody>

            <thead class="thead-light">

            <tr>
                <th colspan="4">Total</th>
                <th style="text-align: center;" colspan="2">Beginning Balance: 0.00</th>
                <th style="text-align: right;">600,000.00</th>
                <th style="text-align: right;">390,954.31</th>
                <th style="text-align: center;" colspan="2">
                Ending Balance: 209,045.69</th>
            </tr>

            </thead>

        </table>


        <br><br>


        <table class="table table-sm table-bordered table-hover"  style="width:97vw;">

            <thead class="thead-light">



            <tr>

                <th colspan="10" style="font-size:larger; font-weight:700;">Security Bank</th>
            </tr>

            <tr>


                <th class="text-nowrap" style="width:6vw;">Date</th>

                <th class="text-nowrap" style="width:10vw;">Category</th>

                <th class="text-nowrap" style="width:20vw;">Details</th>

                <th class="text-nowrap" style="width:4vw;">Photos</th>

                <th class="text-nowrap" style="width:10vw;">Payee</th>

                <th style="width:8vw;">Paid / Received Date</th>

                <th class="text-nowrap" style="width:7vw;">Cash In</th>

                <th class="text-nowrap" style="width:7vw;">Cash Out</th>

                <th class="text-nowrap" style="width:12vw;">Remarks</th>

                <th class="text-nowrap" style="width:6vw;">Actions</th>


            </tr>

            </thead>

            <tbody >
            <tr v-for='item in items' v-if="item.account == 2" :class="[item.is_marked == '1' ? 'red' : '']">
                <td>{{item.paid_date}}</td>

                <td>{{item.category}}</td>

                <td style="text-align: left;">{{item.details}}</td>

                <td style="text-align: left;">
                    <a :href="`${mail_ip}/img/${pic_url}`" target="_blank"><i class="fas fa-image fa-lg" ></i></a>
                </td>

                <td>{{item.payee}}</td>

                <td>{{item.paid_date}}</td>

                <td style="text-align: right;">{{item.cash_in}}</td>

                <td style="text-align: right;">{{item.cash_out}}</td>


                <td style="text-align: left;">{{item.remarks}}</td>


                <td class="text-nowrap" v-if="is_viewer == '1'">
                    <button><i class="fas fa-lock" :class="[item.is_locked == '1'? red:''] v-on:click="update(item.id,1)""></i></button>
                </td>
                <td class="text-nowrap" v-else-if="item.is_locked == '0'">
                    <button data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne" v-on:click="edit(item.id)"><i class="fas fa-edit"></i>
                    </button>


                    <button data-toggle="modal"
                            data-target="#exampleModalScrollable" v-on:click="edit(item.id)"><i class="fas fa-project-diagram"></i>
                    </button>



                    <button v-on:click="deleteRecord(item.id)"><i class="fas fa-times" ></i></button>

                </td>
                <td class="text-nowrap" v-else>
                </td>

            </tr>
            </tbody>

            <thead class="thead-light">

            <tr>
                <th colspan="4">Total</th>
                <th style="text-align: center;" colspan="2">Beginning Balance: 0.00</th>
                <th style="text-align: right;">600,000.00</th>
                <th style="text-align: right;">390,954.31</th>
                <th style="text-align: center;" colspan="2">
                    Ending Balance: 209,045.69</th>
            </tr>

            </thead>

        </table>

<br><br>

         <table class="table table-sm table-bordered table-hover" style="width:97vw;">

            <thead class="thead-light">

            <tr>
                <th style="width:25vw; font-size:larger;">All Accounts</th>
                <th style="text-align: center; width:18vw; font-size:larger;">Beginning Balance: 0.00</th>
                <th style="text-align: center; width:18vw; font-size:larger;">Cash In: 1,000,000.00</th>
                <th style="text-align: center; width:18vw; font-size:larger;">Cash Out: 487,428.31</th>
                <th style="text-align: center; width:18vw; font-size:larger;">
                Ending Balance: 512,571.69</th>
            </tr>

            </thead>

        </table>





    </div>


</div>



<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" id="exampleModalScrollable">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="myLargeModalLabel">Split Record</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>


            <div class="modal-body">


                <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                    <div style="margin-bottom: -2vh;">&nbsp</div>

                    <tr>
                        <td style="width:15vw;">
                            <label>Date</label>
                        </td>

                        <td style="text-align: left;"><input type="date" class="form-control"
                                                             style="width:15vw;" readonly id="todays_date"></td>

                    </tr>


                    <tr>
                        <td>
                            <label>Account</label>
                        </td>

                        <td style="text-align: left;">
                            <input type="text" class="form-control" style="width:15vw;" readonly
                                   v-model="account_name">
                        </td>

                    </tr>

                    <tr>
                        <td>
                            <label>Operation Type</label>
                        </td>

                        <td style="text-align: left;">
                            <input type="text" class="form-control" style="width:15vw;" readonly v-model="operation_type">
                        </td>

                    </tr>

                    <tr>
                        <td>
                            <label>Category</label>
                        </td>
                        <td style="text-align: left;">
                            <input type="text" class="form-control" style="width:25vw;" readonly v-model="category">
                        </td>

                    </tr>


                    <tr>
                        <td>
                            <label>Related Account</label>
                        </td>

                        <td style="text-align: left;">
                            <input type="text" class="form-control" style="width:25vw;" readonly
                                   v-model="related_account">
                        </td>

                    </tr>


                    <tr>
                        <td>
                            <label>Payee</label>
                        </td>

                        <td style="text-align: left;">
                            <input type="text" class="form-control" style="width:25vw;" readonly
                                   v-model="payee">
                        </td>

                    </tr>


                    <tr>
                        <td style="width:15vw;">
                            <label>Paid/Received Date</label>
                        </td>

                        <td style="text-align: left;"><input type="text" class="form-control"
                                                             style="width:15vw;" readonly v-model="paid_date"></td>

                    </tr>


                    <tr>
                        <td>
                            <label>Amount</label>
                        </td>

                        <td style="text-align: left; width:70vw;"><input type="text" class="form-control"
                                                                         style="width:15vw;" v-model="amount"
                                                                         readonly></td>

                    </tr>


                    <tr>
                        <td>
                            <label>Details</label>
                        </td>

                        <td style="text-align: left;">
                            <textarea class="form-control" rows="3" style="width:45vw;" v-model="details" readonly></textarea>
                        </td>

                    </tr>


                    <tr>
                        <td>
                            <label>Remarks</label>
                        </td>

                        <td style="text-align: left;">
                            <input type="text" class="form-control" style="width:25vw;" readonly v-model="remarks">
                        </td>

                    </tr>


                    <tr>
                        <td>
                            <label>Photos</label>
                        </td>

                        <td style="text-align: left;">
                            <a :href="`${mail_ip}/img/${pic_url}`" target="_blank"><i class="fas fa-image fa-lg" ></i></a>
                        </td>

                    </tr>

                </table>


                <hr>
                <h6>Split Record #1</h6>


                <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                    <div style="margin-bottom: -2vh;">&nbsp</div>

                    <tr>
                        <td style="width:8.5vw;">
                            <label>Category</label>
                        </td>

                        <td style="text-align: left;">
                            <select class="form-control" style="width:25vw;" id="categories" v-model ="split1.category">
                                <option>Accounting and govt payments</option>
                                <option>Bills</option>
                                <option>Client Refunds</option>
                                <option>Consignment</option>
                                <option>Credit Card</option>
                                <option>Marketing</option>
                                <option>Misc</option>
                                <option>Office Needs</option>
                                <option>Others</option>
                                <option>Projects</option>
                                <option>Rental</option>
                                <option>Salary</option>
                                <option>Sales Petty Cash</option>
                                <option>Store</option>
                                <option>Transportation Petty Cash</option>
                            </select>
                        </td>

                    </tr>

                    <tr v-if="split1.category == 'Marketing' ||  split1.category == 'Office Needs' || split1.category == 'Others' || split1.category ==  'Projects' || split1.category == 'Store'">
                        <td>
                            <label >Sub Category</label>
                        </td>

                        <td style="text-align: left;">
                            <select class="form-control" style="width:25vw;"v-model="split1.sub_category">
                                <option>Allowance</option>
                                <option>Commission</option>
                                <option>Delivery</option>
                                <option>Maintenance</option>
                                <option>Meals</option>
                                <option>Misc</option>
                                <option>Others</option>
                                <option>Outsource</option>
                                <option>Petty cash</option>
                                <option>Products</option>
                                <option>Supplies</option>
                                <option>Tools and Materials</option>
                                <option>Transportation</option>
                            </select>
                        </td>

                    </tr>


                    <tr id="payee">
                        <td>
                            <label>Payee</label>
                        </td>

                        <td style="text-align: left;">

                            <div class="form-control" style="width:15vw;">
                                <v-select v-model="split1.payee"
                                          :options="payees"
                                          attach
                                          chips
                                          label="payeeName"
                                          multiple></v-select>
                            </div>

                        </td>

                    </tr>


                    <tr>
                        <td>
                            <label>Amount</label>
                        </td>

                        <td style="text-align: left;"><input type="text" class="form-control"
                                                                         style="width:15vw;" v-model="split1.amount"></td>

                    </tr>


                    <tr>
                        <td>
                            <label>Details</label>
                        </td>

                        <td style="text-align: left;"><textarea class="form-control" rows="2"
                                                                            style="width:45vw;" v-model="split1.details"></textarea></td>

                    </tr>


                    <tr>
                        <td>
                            <label>Remarks</label>
                        </td>

                        <td style="text-align: left;"><input type="text" class="form-control" style="width:45vw;" v-model="split1.remarks">
                        </td>

                    </tr>

                    <tr>
                        <td>
                            <label>Photos</label>
                        </td>

                        <td style="text-align: left;"><input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" accept="image/*" capture="camera">
                        </td>

                    </tr>

                    <tr>
                        <td>

                        </td>

                        <td style="text-align: left;"><input type="checkbox" style="margin-right:0.5vw; " v-model="split1.is_marked">Mark with
                            Special Font Color
                        </td>

                    </tr>

                </table>
                    <h6>Split Record #2</h6>


                    <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                        <div style="margin-bottom: -2vh;">&nbsp</div>

                        <tr>
                            <td style="width:8.5vw;">
                                <label>Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;" id="categories" v-model ="split2.category">
                                    <option>Accounting and govt payments</option>
                                    <option>Bills</option>
                                    <option>Client Refunds</option>
                                    <option>Consignment</option>
                                    <option>Credit Card</option>
                                    <option>Marketing</option>
                                    <option>Misc</option>
                                    <option>Office Needs</option>
                                    <option>Others</option>
                                    <option>Projects</option>
                                    <option>Rental</option>
                                    <option>Salary</option>
                                    <option>Sales Petty Cash</option>
                                    <option>Store</option>
                                    <option>Transportation Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr v-if="split2.category == 'Marketing' ||  split2.category == 'Office Needs' || split2.category == 'Others' || split2.category ==  'Projects' || split2.category == 'Store'">
                            <td>
                                <label >Sub Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;"v-model="split2.sub_category">
                                    <option>Allowance</option>
                                    <option>Commission</option>
                                    <option>Delivery</option>
                                    <option>Maintenance</option>
                                    <option>Meals</option>
                                    <option>Misc</option>
                                    <option>Others</option>
                                    <option>Outsource</option>
                                    <option>Petty cash</option>
                                    <option>Products</option>
                                    <option>Supplies</option>
                                    <option>Tools and Materials</option>
                                    <option>Transportation</option>
                                </select>
                            </td>

                        </tr>


                        <tr id="payee">
                            <td>
                                <label>Payee</label>
                            </td>

                            <td style="text-align: left;">

                                <div class="form-control" style="width:15vw;">
                                    <v-select v-model="split2.payee"
                                              :options="payees"
                                              attach
                                              chips
                                              label="payeeName"
                                              multiple></v-select>
                                </div>

                            </td>

                        </tr>


                        <tr>
                            <td>
                                <label>Amount</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control"
                                                                 style="width:15vw;" v-model="split2.amount"></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Details</label>
                            </td>

                            <td style="text-align: left;"><textarea class="form-control" rows="2"
                                                                    style="width:45vw;" v-model="split2.details"></textarea></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Remarks</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control" style="width:45vw;" v-model="split2.remarks">
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <label>Photos</label>
                            </td>

                            <td style="text-align: left;"><input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" accept="image/*" capture="camera">
                            </td>

                        </tr>

                        <tr>
                            <td>

                            </td>

                            <td style="text-align: left;"><input type="checkbox" style="margin-right:0.5vw; " v-model="split2.is_marked">Mark with
                                Special Font Color
                            </td>

                        </tr>

                    </table>
                    <h6>Split Record #3</h6>


                    <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                        <div style="margin-bottom: -2vh;">&nbsp</div>

                        <tr>
                            <td style="width:8.5vw;">
                                <label>Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;" id="categories" v-model ="split3.category">
                                    <option>Accounting and govt payments</option>
                                    <option>Bills</option>
                                    <option>Client Refunds</option>
                                    <option>Consignment</option>
                                    <option>Credit Card</option>
                                    <option>Marketing</option>
                                    <option>Misc</option>
                                    <option>Office Needs</option>
                                    <option>Others</option>
                                    <option>Projects</option>
                                    <option>Rental</option>
                                    <option>Salary</option>
                                    <option>Sales Petty Cash</option>
                                    <option>Store</option>
                                    <option>Transportation Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr v-if="split3.category == 'Marketing' ||  split3.category == 'Office Needs' || split3.category == 'Others' || split3.category ==  'Projects' || split3.category == 'Store'">
                            <td>
                                <label >Sub Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;"v-model="split3.sub_category">
                                    <option>Allowance</option>
                                    <option>Commission</option>
                                    <option>Delivery</option>
                                    <option>Maintenance</option>
                                    <option>Meals</option>
                                    <option>Misc</option>
                                    <option>Others</option>
                                    <option>Outsource</option>
                                    <option>Petty cash</option>
                                    <option>Products</option>
                                    <option>Supplies</option>
                                    <option>Tools and Materials</option>
                                    <option>Transportation</option>
                                </select>
                            </td>

                        </tr>


                        <tr id="payee">
                            <td>
                                <label>Payee</label>
                            </td>

                            <td style="text-align: left;">

                                <div class="form-control" style="width:15vw;">
                                    <v-select v-model="split3.payee"
                                              :options="payees"
                                              attach
                                              chips
                                              label="payeeName"
                                              multiple></v-select>
                                </div>

                            </td>

                        </tr>


                        <tr>
                            <td>
                                <label>Amount</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control"
                                                                 style="width:15vw;" v-model="split3.amount"></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Details</label>
                            </td>

                            <td style="text-align: left;"><textarea class="form-control" rows="2"
                                                                    style="width:45vw;" v-model="split3.details"></textarea></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Remarks</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control" style="width:45vw;" v-model="split3.remarks">
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <label>Photos</label>
                            </td>

                            <td style="text-align: left;"><input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" accept="image/*" capture="camera">
                            </td>

                        </tr>

                        <tr>
                            <td>

                            </td>

                            <td style="text-align: left;"><input type="checkbox" style="margin-right:0.5vw; " v-model="split3.is_marked">Mark with
                                Special Font Color
                            </td>

                        </tr>

                    </table>
                    <h6>Split Record #4</h6>


                    <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                        <div style="margin-bottom: -2vh;">&nbsp</div>

                        <tr>
                            <td style="width:8.5vw;">
                                <label>Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;" id="categories" v-model ="split4.category">
                                    <option>Accounting and govt payments</option>
                                    <option>Bills</option>
                                    <option>Client Refunds</option>
                                    <option>Consignment</option>
                                    <option>Credit Card</option>
                                    <option>Marketing</option>
                                    <option>Misc</option>
                                    <option>Office Needs</option>
                                    <option>Others</option>
                                    <option>Projects</option>
                                    <option>Rental</option>
                                    <option>Salary</option>
                                    <option>Sales Petty Cash</option>
                                    <option>Store</option>
                                    <option>Transportation Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr v-if="split4.category == 'Marketing' ||  split4.category == 'Office Needs' || split4.category == 'Others' || split4.category ==  'Projects' || split4.category == 'Store'">
                            <td>
                                <label >Sub Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;"v-model="split4.sub_category">
                                    <option>Allowance</option>
                                    <option>Commission</option>
                                    <option>Delivery</option>
                                    <option>Maintenance</option>
                                    <option>Meals</option>
                                    <option>Misc</option>
                                    <option>Others</option>
                                    <option>Outsource</option>
                                    <option>Petty cash</option>
                                    <option>Products</option>
                                    <option>Supplies</option>
                                    <option>Tools and Materials</option>
                                    <option>Transportation</option>
                                </select>
                            </td>

                        </tr>


                        <tr id="payee">
                            <td>
                                <label>Payee</label>
                            </td>

                            <td style="text-align: left;">

                                <div class="form-control" style="width:15vw;">
                                    <v-select v-model="split4.payee"
                                              :options="payees"
                                              attach
                                              chips
                                              label="payeeName"
                                              multiple></v-select>
                                </div>

                            </td>

                        </tr>


                        <tr>
                            <td>
                                <label>Amount</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control"
                                                                 style="width:15vw;" v-model="split4.amount"></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Details</label>
                            </td>

                            <td style="text-align: left;"><textarea class="form-control" rows="2"
                                                                    style="width:45vw;" v-model="split4.details"></textarea></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Remarks</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control" style="width:45vw;" v-model="split4.remarks">
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <label>Photos</label>
                            </td>

                            <td style="text-align: left;"><input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" accept="image/*" capture="camera">
                            </td>

                        </tr>

                        <tr>
                            <td>

                            </td>

                            <td style="text-align: left;"><input type="checkbox" style="margin-right:0.5vw; " v-model="split4.is_marked">Mark with
                                Special Font Color
                            </td>

                        </tr>

                    </table>
                    <h6>Split Record #5</h6>


                    <table style="margin-left:1vw; line-height: 5vh;" class="table-hover">

                        <div style="margin-bottom: -2vh;">&nbsp</div>

                        <tr>
                            <td style="width:8.5vw;">
                                <label>Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;" id="categories" v-model ="split5.category">
                                    <option>Accounting and govt payments</option>
                                    <option>Bills</option>
                                    <option>Client Refunds</option>
                                    <option>Consignment</option>
                                    <option>Credit Card</option>
                                    <option>Marketing</option>
                                    <option>Misc</option>
                                    <option>Office Needs</option>
                                    <option>Others</option>
                                    <option>Projects</option>
                                    <option>Rental</option>
                                    <option>Salary</option>
                                    <option>Sales Petty Cash</option>
                                    <option>Store</option>
                                    <option>Transportation Petty Cash</option>
                                </select>
                            </td>

                        </tr>

                        <tr v-if="split5.category == 'Marketing' ||  split5.category == 'Office Needs' || split5.category == 'Others' || split5.category ==  'Projects' || split5.category == 'Store'">
                            <td>
                                <label >Sub Category</label>
                            </td>

                            <td style="text-align: left;">
                                <select class="form-control" style="width:25vw;"v-model="split5.sub_category">
                                    <option>Allowance</option>
                                    <option>Commission</option>
                                    <option>Delivery</option>
                                    <option>Maintenance</option>
                                    <option>Meals</option>
                                    <option>Misc</option>
                                    <option>Others</option>
                                    <option>Outsource</option>
                                    <option>Petty cash</option>
                                    <option>Products</option>
                                    <option>Supplies</option>
                                    <option>Tools and Materials</option>
                                    <option>Transportation</option>
                                </select>
                            </td>

                        </tr>


                        <tr id="payee">
                            <td>
                                <label>Payee</label>
                            </td>

                            <td style="text-align: left;">

                                <div class="form-control" style="width:15vw;">
                                    <v-select v-model="split5.payee"
                                              :options="payees"
                                              attach
                                              chips
                                              label="payeeName"
                                              multiple></v-select>
                                </div>

                            </td>

                        </tr>


                        <tr>
                            <td>
                                <label>Amount</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control"
                                                                 style="width:15vw;" v-model="split5.amount"></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Details</label>
                            </td>

                            <td style="text-align: left;"><textarea class="form-control" rows="2"
                                                                    style="width:45vw;" v-model="split5.details"></textarea></td>

                        </tr>


                        <tr>
                            <td>
                                <label>Remarks</label>
                            </td>

                            <td style="text-align: left;"><input type="text" class="form-control" style="width:45vw;" v-model="split5.remarks">
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <label>Photos</label>
                            </td>

                            <td style="text-align: left;"><input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" accept="image/*" capture="camera">
                            </td>

                        </tr>

                        <tr>
                            <td>

                            </td>

                            <td style="text-align: left;"><input type="checkbox" style="margin-right:0.5vw; " v-model="split5.is_marked">Mark with
                                Special Font Color
                            </td>

                        </tr>

                    </table>
                <div style="margin-left:6vw; margin-top:2vh; margin-bottom:1.5vh;">

                    <button class="btn btn-secondary" style="width:10vw; font-weight:700; margin-left:2vw;"
                            >Cancel
                    </button>

                    <button class="btn btn-primary" style="width:10vw; font-weight:700; margin-left:2vw;"
                             v-on:click="add(2)">Confirm
                    </button>

                </div>


            </div>


        </div>

    </div>

</div>


</div>









<script>



    var today = new Date();
    var dd = ("0" + (today.getDate())).slice(-2);
    var mm = ("0" + (today.getMonth() + 1)).slice(-2);
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $("#todays-date").attr("value", today);
    $("#todays_date").attr("value", today);






</script>



</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/exif-js"></script>
<script src="js/vue-select.js"></script>
<script src="js/axios.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script defer src="https://kit.fontawesome.com/a076d05399.js"></script> 
<script src="//unpkg.com/vue-i18n/dist/vue-i18n.js"></script>
<script src="//unpkg.com/element-ui"></script>
<script src="//unpkg.com/element-ui/lib/umd/locale/en.js"></script>

<script>
    ELEMENT.locale(ELEMENT.lang.en)
</script>

<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="js/add_or_edit_price_record.js"></script>

</html>