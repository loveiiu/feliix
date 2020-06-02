<?php include 'check.php';?>
<!DOCTYPE html>
<html>
<head>
<!-- 共用資料 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, min-width=640, user-scalable=0, viewport-fit=cover"/>

<!-- favicon.ico iOS icon 152x152px -->
<link rel="shortcut icon" href="images/favicon.ico" />
<link rel="Bookmark" href="images/favicon.ico" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="images/iosicon.png"/>

<!-- SEO -->
<title>FELIIX template</title>
<meta name="keywords" content="FELIIX">
<meta name="Description" content="FELIIX">
<meta name="robots" content="all" />
<meta name="author" content="FELIIX" />

<!-- Open Graph protocol -->
<meta property="og:site_name" content="FELIIX" />
<!--<meta property="og:url" content="分享網址" />-->
<meta property="og:type" content="website" />
<meta property="og:description" content="FELIIX" />
<!--<meta property="og:image" content="分享圖片(1200×628)" />-->
<!-- Google Analytics -->

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="css/default.css"/>
<link rel="stylesheet" type="text/css" href="css/ui.css"/>
<link rel="stylesheet" type="text/css" href="css/case.css"/>
<link rel="stylesheet" type="text/css" href="css/mediaqueries.css"/>

<!-- jQuery和js載入 -->
<script type="text/javascript" src="js/rm/jquery-3.4.1.min.js" ></script>
<script type="text/javascript" src="js/rm/realmediaScript.js"></script>
<script type="text/javascript" src="js/main.js" defer></script>

<!-- import CSS -->
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">



<!-- 這個script之後寫成aspx時，改用include方式載入header.htm，然後這個就可以刪掉了 -->
<script>
$(function(){
    $('header').load('include/header.php');
})
</script>

</head>

<body class="primary">
 	
<div class="bodybox">
    <!-- header -->
	<header>header</header>
    <!-- header end -->
    <div id="app" class="mainContent">
        <!-- tags js在 main.js -->
        <div class="tags">
            <a class="tag A focus">Apply for Leave</a>
            <a class="tag B">Leave Record</a>
        </div>
        <!-- Blocks -->
        <div class="block A focus">
            <h6>Leaves Summary</h6>
            <div class="box-content">
                <!-- 表格樣式 -->
                <div class="title">
                    <b>Employee Name</b>
                    <div class="function">
                        <el-date-picker
                            v-model="month1"
                            type="month"
                            format="yyyy MMM"
                            placeholder="Pick a Month">
                        </el-date-picker>

                        <el-date-picker
                            v-model="month2"
                            type="month"
                            format="yyyy MMM"
                            placeholder="Pick a Month">
                        </el-date-picker>
                    </div>
                </div>
                <div class="tablebox">
                    <ul class="head">
                        <li>Leave Type</li>
                        <li>Available</li>
                        <li>Taken</li>
                        <li>Frozen</li>
                        <li>Balance</li>
                    </ul>
                    <ul>
                        <li>Annual Leave</li>
                        <li>176 Hrs.</li>
                        <li>48 Hrs.</li>
                        <li>0 Hr.</li>
                        <li>128 Hrs.</li>
                    </ul>
                    <ul>
                        <li>Paid Sick Leave</li>
                        <li>40 Hrs.</li>
                        <li>8 Hrs.</li>
                        <li>8 Hrs.</li>
                        <li>24 Hrs.</li>
                    </ul>
                    <ul>
                        <li>Personal Leave</li>
                        <li>-</li>
                        <li>48 Hrs.</li>
                        <li>0 Hr.</li>
                        <li>-</li>
                    </ul>
                </div>
                <!-- 表單樣式 -->
                <div class="title">
                    <b>Leave Application Form</b>
                </div>
                <div class="formbox">
                    <ul>
                        <li class="head">Employee Name</li>
                        <li>{{ name }}</li>
                    </ul>
                    <ul>
                        <li class="head">Leave Type</li>
                        <li>
                            <select name="" id="" v-model="leave_type">
                                <option value="A">Annual Leave</option>
                                <option value="B">Sick Leave</option>
                                <option value="C">Period Leave</option>
                            </select>
                        </li>
                    </ul>

                    <ul v-if="showExtra">
                        <li class="head" v-if="showExtra">Certificate of Diagnosis</li>
                        <li v-if="showExtra"><input type="file" id="file" ref="file" accept="image/*" capture="camera"></li>
                    </ul>
                    
                    <div class="group">
                        <ul>
                            <li class="head">Start Time</li>
                            <li>
                            <input type="datetime-local" v-model="apply_start" />
                            </li>
                        </ul>
                        <ul>
                            <li class="head">End Time</li>
                            <li>
                            <input type="datetime-local" v-model="apply_end" />
                            </li>
                        </ul>
                    </div>
                    <ul>
                        <li class="head">Leave Length</li>
                        <li>{{ period }}</li>
                    </ul>
                    <ul>
                        <li class="head">Reason</li>
                        <li>
                            <textarea name="message" rows="3" cols="20" v-model="reason" >
                
                            </textarea>
                        </li>
                    </ul>
                   
                    <div class="btnbox">
                    <a class="btn" @click="reset">Reset</a>
                    <a class="btn" @click="apply" :disabled="submit">Submit</a>
                    </div>
                </div>
                <!-- 表單樣式 -->
            </div>
        </div>
        <div class="block B">
            <h6>Leave Records</h6>
            <div class="box-content">
                <div class="title">
                    <b>Employee Name</b>
                    <div class="function">
                       <input name="Foodb" type="radio" value="A" id="A" class="green"><label for="A">All</label>
                   <input name="Foodb2" type="radio" value="A2" id="A2" class="blue"><label for="A2">Waiting for Approval</label>
<!--
                        <b class="light green"></b>All
                        <b class="light blue"></b>Waiting for Approval
-->
                        <select name="" id="">
                            <option value="">MAR / 2020</option>
                            <option value="">FEB / 2020</option>
                            <option value="">JAN / 2020</option>
                        </select>
                    </div>
                </div>
                <div class="tablebox">
                    <ul class="head">
                        <li><i class="micons">view_list</i></li>
                        <li>Status</li>
                        <li>Type</li>
                        <li>Leave Time</li>
                    </ul>
                    <ul>
                        <li><input name="Foodb2" type="radio" value="A2" id="B2" class="alone blue"></li>
                        <li>Waiting for Approval</li>
                        <li>Annual Leave</li>
                        <li>2020/01/07 9:30 - 2020/01/11 18:30</li>
                    </ul>
                    <ul>
                        <li><input name="Foodb2" type="radio" value="A2" id="B2" class="alone blue"></li>
                        <li>Approval</li>
                        <li>Annual Leave</li>
                        <li>2020/01/07 9:30 - 2020/01/11 18:30</li>
                    </ul>
                    <ul>
                        <li><input name="Foodb2" type="radio" value="A2" id="B2" class="alone blue"></li>
                        <li>Approval</li>
                        <li>Sick Leave</li>
                        <li>2020/01/07 9:30 - 2020/01/11 18:30</li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> 
<script src="js/axios.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="//unpkg.com/vue-i18n/dist/vue-i18n.js"></script>
<script src="//unpkg.com/element-ui"></script>
<script src="//unpkg.com/element-ui/lib/umd/locale/en.js"></script>

<script>
  ELEMENT.locale(ELEMENT.lang.en)
</script>

<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="js/apply_for_leave.js"></script>
</html>