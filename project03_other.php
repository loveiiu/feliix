<!DOCTYPE html>
<html>

<head>
    <!-- 共用資料 -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, min-width=640, user-scalable=0, viewport-fit=cover" />

    <!-- favicon.ico iOS icon 152x152px -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="Bookmark" href="images/favicon.ico" />
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/iosicon.png" />

    <!-- SEO -->
    <title>FELIIX template pc</title>
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
    <link rel="stylesheet" type="text/css" href="js/fancyBox/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <link rel="stylesheet" type="text/css" href="css/ui.css" />
    <link rel="stylesheet" type="text/css" href="css/case.css" />
    <link rel="stylesheet" type="text/css" href="css/mediaqueries.css" />

    <!-- jQuery和js載入 -->
    <script type="text/javascript" src="js/rm/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/rm/realmediaScript.js"></script>
    <script type="text/javascript" src="js/main.js" defer></script>
    <script type="text/javascript" src="js/fancyBox/jquery.fancybox.min.js"></script>

    <script>
        $(function() {
            $('header').load('include/header.php');
            //
            dialogshow($('.list_function a.add.red'), $('.list_function .dialog.r-add'));
            dialogshow($('.list_function a.edit.red'), $('.list_function .dialog.r-edit'));
            dialogshow($('.list_function a.add.blue'), $('.list_function .dialog.d-add'));
            dialogshow($('.list_function a.edit.blue'), $('.list_function .dialog.d-edit'));
            // left block Reply
            dialogshow($('.btnbox a.reply.r1'), $('.btnbox .dialog.r1'));
            dialogshow($('.btnbox a.reply.r2'), $('.btnbox .dialog.r2'));
            dialogshow($('.btnbox a.reply.r3'), $('.btnbox .dialog.r3'));
            dialogshow($('.btnbox a.reply.r4'), $('.btnbox .dialog.r4'));
            // 套上 .dialogclear 關閉所有的跳出框
            $('.dialogclear').click(function() {
                dialogclear()
            });
            // 根據 select 分類
            $('#opType').change(function() {
                //console.log('Operation Type:'+$("#opType").val());
                var f = $("#opType").val();
                $('.dialog.r-edit').removeClass('edit').removeClass('del').addClass(f);
            })
            $('#opType2').change(function() {
                //console.log('Operation Type:'+$("#opType").val());
                var f = $("#opType2").val();
                $('.dialog.d-edit').removeClass('edit').removeClass('del').addClass(f);
            })
            $('#opType3').change(function() {
                //console.log('Operation Type:'+$("#opType").val());
                var f = $("#opType3").val();
                $('.dialog.r-add').removeClass('add').removeClass('dup').addClass(f);
            })

            $('.selectbox').on('click', function() {
                $.fancybox.open({
                    src: '#pop-multiSelect',
                    type: 'inline'
                });
            });
        })
    </script>

</head>

<body class="fourth other">

    <div class="bodybox">
        <!-- header -->
        <header class="dialogclear">header</header>
        <!-- header end -->
        <div id='app' class="mainContent">
            <!-- mainContent為動態內容包覆的內容區塊 -->
            <div class="list_function main">
                <div class="block">
                    <!-- add red -->
                    <div class="popupblock">
                        <a id="dialog_a1" class="add red"></a>
                        <!-- dialog -->
                        <div id="add_a1" class="dialog r-add add">
                            <h6>Add/Duplicate Task</h6>
                            <div class="tablebox s1">
                                <ul>
                                    <li class="head">Operation Type:</li>
                                    <li>
                                        <select name="" id="opType3">
                                            <option value="add">Add New Tesk</option>
                                            <option value="dup">Duplicate Existing Task</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="formbox s2 add">
                                <dl>
                                    <dt>Title:</dt>
                                    <dd><input type="text" v-model="title"></dd>
                                </dl>
                                <dl>
                                    <dt>Priority:</dt>
                                    <dd>
                                        <select v-model="priority">
                                            <option value="1">No Priority</option>
                                            <option value="2">Low</option>
                                            <option value="3">Normal</option>
                                            <option value="4">High</option>
                                            <option value="5">Urgent</option>
                                        </select>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Assignee:</dt>
                                    <dd>
                                        <div class="browser_group">
                                            <select v-model="assignee" id="assignee">
                                                <option v-for="(item, index) in users" :value="item.id" :key="item.username">
                                                    {{ item.username }}
                                                </option>
                                            </select>
                                            <button @click="OpenAssignee">Browse</button><button class="selectbox">Browse</button>
                                        </div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Collaborator:</dt>
                                    <dd>
                                        <div class="browser_group">
                                            <select id="collaborator" v-model="collaborator">
                                                <option v-for="(item, index) in users" :value="item.id" :key="item.username">
                                                    {{ item.username }}
                                                </option>
                                            </select>
                                            <button @click="OpenCollaborator">Browse</button>
                                        </div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Due Date:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="date" v-model="due_date"></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Task Detail:</dt>
                                    <dd><textarea placeholder="" v-model="detail"></textarea></dd>
                                </dl>
                                <dl>
                                    <dd style="display: flex; justify-content: flex_start;">
                                        <span style="color: green; font-size: 14px; font-weight: 500; padding-bottom: 5px; margin-right:10px;">Files: </span>
                                        <div class="pub-con" ref="bg">
                                            <div class="input-zone">
                                                <span class="upload-des">choose file</span>
                                                <input class="input" type="file" name="file" value placeholder="choose file" ref="file" v-show="canSub" @change="changeFile()" multiple />
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Files:</dt>
                                    <dd>
                                        <div class="browser_group">

                                            <div class="pad">
                                                <div class="file-list">
                                                    <div class="file-item" v-for="(item,index) in fileArray" :key="index">
                                                        <p>
                                                            {{item.name}}
                                                            <span @click="deleteFile(index)" v-show="item.progress==0" class="upload-delete"><i class="fas fa-backspace"></i>
                                                            </span>
                                                        </p>
                                                        <div class="progress-container" v-show="item.progress!=0">
                                                            <div class="progress-wrapper">
                                                                <div class="progress-progress" :style="'width:'+item.progress*100+'%'"></div>
                                                            </div>
                                                            <div class="progress-rate">
                                                                <span v-if="item.progress!=1">{{(item.progress*100).toFixed(0)}}%</span>
                                                                <span v-else><i class="fas fa-check-circle"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                    </dd>
                                </dl>
                                <div class="btnbox">
                                    <a class="btn small" @click="task_clear">Cancel</a>
                                    <a class="btn small green">Calendar</a>
                                    <a class="btn small green" @click="task_create">Create</a>
                                </div>
                            </div>
                            <div class="tablebox s2 dup">
                                <ul>
                                    <li class="head">Target Tesk:</li>
                                    <li class="mix">
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                        <a class="btn small green">Duplicate</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- dialog end -->
                    </div>
                    <!-- edit red -->
                    <div class="popupblock">
                        <a class="edit red"></a>
                        <!-- dialog -->
                        <div class="dialog r-edit">
                            <h6>Edit/Delete Task:</h6>
                            <div class="tablebox s1">
                                <ul>
                                    <li class="head">Operation Type:</li>
                                    <li>
                                        <select name="" id="opType">
                                            <option value="edit">Edit Existing Task</option>
                                            <option value="del">Delete Existing Task</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="tablebox s2 del">
                                <ul>
                                    <li class="head">Target Tesk:</li>
                                    <li class="mix">
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                        <a class="btn small">Delete</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tablebox s2 edit">
                                <ul>
                                    <li class="head">Target Sequence:</li>
                                    <li class="mix">
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                        <a class="btn small green">Load</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="formbox s2 edit">
                                <dl>
                                    <dt>Title:</dt>
                                    <dd><input type="text"></dd>
                                </dl>
                                <dl>
                                    <dt>Priority:</dt>
                                    <dd>
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Status:</dt>
                                    <dd>
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Assignee:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Browse</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Collaborator:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Browse</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Due Date:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose Date</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Description:</dt>
                                    <dd><textarea placeholder=""></textarea></dd>
                                </dl>
                                <dl>
                                    <dt>Pictures:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose Picture</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Files:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose File</button></div>
                                    </dd>
                                </dl>
                                <div class="btnbox">
                                    <a class="btn small">Cancel</a>
                                    <a class="btn small green">Calendar</a>
                                    <a class="btn small green">Save</a>
                                </div>
                            </div>
                        </div>
                        <!-- dialog end -->
                    </div>
                    <!-- add -->
                    <div class="popupblock">
                        <a class="add blue"></a>
                        <!-- dialog -->
                        <div class="dialog d-add">
                            <h6>Add Message:</h6>
                            <div class="formbox">
                                <dl>
                                    <dt>Title:</dt>
                                    <dd><input type="text" placeholder=""></dd>
                                </dl>
                                <dl>
                                    <dt>Assignee:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Browse</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Description:</dt>
                                    <dd><textarea placeholder=""></textarea></dd>
                                </dl>
                                <dl>
                                    <dt>Pictures:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose Picture</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Files:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose File</button></div>
                                    </dd>
                                </dl>
                                <div class="btnbox">
                                    <a class="btn small">Cancel</a>
                                    <a class="btn small green">Create</a>
                                </div>
                            </div>
                        </div>
                        <!-- dialog end -->
                    </div>
                    <!-- edit -->
                    <div class="popupblock">
                        <a class="edit blue"></a>
                        <!-- dialog -->
                        <div class="dialog d-edit">
                            <h6>Edit/Delete Message:</h6>
                            <div class="tablebox s1">
                                <ul>
                                    <li class="head">Operation Type:</li>
                                    <li>
                                        <select name="" id="opType2">
                                            <option value="edit">Edit Existing Message</option>
                                            <option value="del">Delete Existing Message</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="tablebox s2 del">
                                <ul>
                                    <li class="head">Target Message:</li>
                                    <li class="mix">
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                        <a class="btn small">Delete</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tablebox s2 edit">
                                <ul>
                                    <li class="head">Target Message:</li>
                                    <li class="mix">
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                        <a class="btn small green">Load</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="formbox s2 edit">
                                <dl>
                                    <dt>Title:</dt>
                                    <dd><input type="text" placeholder=""></dd>
                                </dl>
                                <dl>
                                    <dt>Assignee:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Browse</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Description:</dt>
                                    <dd><textarea placeholder=""></textarea></dd>
                                </dl>
                                <dl>
                                    <dt>Pictures:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose Picture</button></div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Files:</dt>
                                    <dd>
                                        <div class="browser_group"><input type="text"><button>Choose File</button></div>
                                    </dd>
                                </dl>
                                <div class="btnbox">
                                    <a class="btn small">Cancel</a>
                                    <a class="btn small green">Save</a>
                                </div>
                            </div>
                        </div>
                        <!-- dialog end -->
                    </div>
                    <!-- calendar -->
                    <div class="popupblock">
                        <a class="calendar"></a>
                    </div>
                    <!-- tag -->
                    <b class="tag focus">PROJECT</b>
                    <b class="tag">UNDP / Ranee</b>
                </div>
            </div>
            <div class="block left">
                <div class="list_function dialogclear">
                    <!-- Filter -->
                    <div class="filter">
                        <b>Filter:</b>
                        <select name="" id="">
                            <option value="">Info. Type</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        <select name="" id="">
                            <option value="">Priority</option>
                            <option value="">No Priority</option>
                            <option value="">Low</option>
                            <option value="">Normal</option>
                            <option value="">High</option>
                            <option value="">Urgent</option>
                        </select>
                        <select name="" id="">
                            <option value="">Status</option>
                            <option value="">Planning</option>
                            <option value="">Pending Review</option>
                            <option value="">Pending Approval</option>
                            <option value="">For Revision</option>
                            <option value="">On Hold</option>
                            <option value="">Disapproved</option>
                            <option value="">Approved</option>
                            <option value="">On Progress</option>
                            <option value="">Completed</option>
                            <option value="">Special</option>
                        </select>
                        <select name="" id="">
                            <option value="">Due Date</option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div v-for='(receive_record, index) in project03_other_task'>



                    <div class="teskbox dialogclear">
                        <a class="btn small red">{{ receive_record.priority }}</a>
                        <a class="btn small yellow" v-if="receive_record.task_status == '0'">Progressing</a>
                        <a class="btn small green" v-if="receive_record.task_status == '1'">Done</a>
                        <b>[Task] {{ receive_record.title }}</b>
                        <a class="btn small blue right">Arrange Meeting</a>
                    </div>
                    <div class="teskbox dialogclear" style="margin-top:-2px !important">
                        <div class="tablebox m01">
                            <ul>
                                <li><b>Creator</b></li>
                                <li><a class="man" :style="'background-image: url(images/man/' +  receive_record.creator_pic  + ');'"></a></li>
                            </ul>
                            <ul>
                                <li><b>Assignee</b></li>
                                <li>
                                    <i v-for="item in receive_record.assignee">
                                        <a class="man" :style="'background-image: url(images/man/' + item.pic_url + ');'"></a>
                                    </i>

                                </li>
                            </ul>
                            <ul>
                                <li><b>Collaborator</b></li>
                                <li>
                                    <i v-for="item in receive_record.collaborator">
                                        <a class="man" :style="'background-image: url(images/man/' + item.pic_url + ');'"></a>
                                    </i>

                                </li>
                            </ul>
                            <ul>
                                <li><b>Due Date</b></li>
                                <li>{{ receive_record.task_date }}</li>
                            </ul>
                            <ul>
                                <li><b>Description</b></li>
                                <li>{{ receive_record.detail }}</li>
                            </ul>
                            <ul>
                                <li><b>Attachments</b></li>
                                <li>
                                    <i v-for="item in receive_record.items">
                                        <a class="attch" :href="baseURL + item.gcp_name" target="_blank">{{item.filename}}</a>
                                    </i>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="teskbox scroll">
                        <div class="tableframe">
                            <div class="tablebox m02">
                                <!-- 1 message -->
                                <ul v-for="item in receive_record.message" :class="{ deleted : item.message_status == -1, dialogclear : item.message_status == -1 }" >
                                    <li class="dialogclear">
                                        <a class="man" :style="'background-image: url(images/man/' + item.messager_pic + ');'"></a>
                                        <i class="info">
                                            <b>{{item.messager}}</b><br>
                                            {{ item.message_time }}<br>
                                            {{ item.message_date }}
                                            
                                        </i>
                                    </li>
                                    <li v-if="item.message_status == 0">
                                        <div class="msg">
                                            <div class="msgbox dialogclear">
                                                <p v-if="item.ref_id != 0"><a href="" class="tag_name">@{{ item.ref_name}}</a> {{ item.ref_msg}}</p>
                                                <p>{{ item.message }}</p>
                                                <i v-for="file in item.items">
                                                    <a class="attch" :href="baseURL + file.gcp_name" target="_blank">{{file.filename}}</a>
                                                </i>
                                                
                                            </div>
                                            <div class="btnbox">
                                                <a class="btn small green reply r1" :id="'task_reply_btn_' + item.message_id + '_' + item.ref_id" @click="openTaskMsgDlg(item.message_id + '_' + item.ref_id)">Reply</a>
                                                <!-- dialog -->
                                                <div class="dialog reply r1" :id="'task_reply_dlg_' + item.message_id + '_' + item.ref_id">
                                                    <div class="formbox">
                                                        <dl>
                                                            <dd><textarea name="" :id="'task_reply_msg_' + item.message_id + '_' + item.ref_id"></textarea></dd>
                                                            <dd>
                                                                <div class="filebox">
                                                                        <a class="attch" v-for="(item,index) in taskItems(receive_record.task_id)" :key="index" @click="deleteTaskFile(receive_record.task_id, index)">{{item.name}}</a>
                                                                </div>
                                                            </dd>
                                                            <dd>
                                                                <div class="pub-con" ref="bg">
                                                                    <div class="input-zone">
                                                                        <span class="upload-des">choose file</span>
                                                                        <input class="input" type="file" :ref="'file_task_' + receive_record.task_id" placeholder="choose file" @change="changeTaskFile(receive_record.task_id)" multiple />
                                                                    </div>
                                                                </div>
                                                            </dd>

                                                            <dd>
                                                                <div class="btnbox">
                                                                    <a class="btn small orange">Cancel</a>
                                                                    <a class="btn small green">Save</a>
                                                                </div>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <!-- dialog end -->
                                                <a class="btn small yellow">Delete</a>
                                            </div>

                                            <div class="msgbox dialogclear" v-for="reply in item.reply">
                                                <p><a href="" class="tag_name">@{{ item.messager}}</a> {{ reply.reply}}</p>
                                                <i v-for="file in reply.items">
                                                    <a class="attch" :href="baseURL + reply.gcp_name" target="_blank">{{reply.filename}}</a>
                                                </i>

                                            </div>
                                        </div>
                                    </li>

                                    <li v-if="item.message_status == -1">
                                        <div class="msg">
                                            <div class="msgbox">
                                                <p>Deleted by <a href="" class="tag_name">@{{ item.updator }}</a> at {{ item.update_date }}</p>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                                
                            </div>
                        </div>
                        <div class="tablebox lv3c m03 dialogclear">
                            <ul>
                                <li>
                                    <textarea name="" id="" placeholder="Write your comment here" :ref="'comment_task_' + receive_record.task_id"></textarea>
                                    <div class="filebox">
                                        <a class="attch" v-for="(item,index) in taskItems(receive_record.task_id)" :key="index" @click="deleteTaskFile(receive_record.task_id, index)">{{item.name}}</a>

                                    </div>
                                </li>
                                <li>
                                    <div class="pub-con" ref="bg">
                                        <div class="input-zone">
                                            <span class="upload-des">choose file</span>
                                            <input class="input" type="file" :ref="'file_task_' + receive_record.task_id" placeholder="choose file" @change="changeTaskFile(receive_record.task_id)" multiple />
                                        </div>
                                        <a class="btn small green" @click="comment_create(receive_record.task_id)">Comment</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>




            </div>


            <div class="block right ">
                <div class="list_function dialogclear">
                    <!-- 分頁 -->
                    <div class="pagenation">
                        <a class="prev">Previous</a>
                        <a class="page">1</a>
                        <a class="page">2</a>
                        <a class="page">3</a>
                        <b>...</b>
                        <a class="page">12</a>
                        <a class="next">Next</a>
                    </div>
                </div>
                <div class="teskbox">
                    <h5>[MESSAGE] Information from Customer</h5>
                    <div class="tablebox2">
                        <ul>
                            <li class="teskblock dialogclear">
                                <div class="tablebox m01">
                                    <ul>
                                        <li><b>Creator</b></li>
                                        <li><a class="man" style="background-image: url(images/man/man10.jpg);"></a></li>
                                    </ul>
                                    <ul>
                                        <li><b>Date</b></li>
                                        <li>November 4, 2020 / 10:07 AM</li>
                                    </ul>
                                    <ul>
                                        <li><b>Assignee</b></li>
                                        <li>
                                            <a class="man" style="background-image: url(images/man/man11.jpg);"></a>
                                            <a class="man" style="background-image: url(images/man/man12.jpg);"></a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li><b>Description</b></li>
                                        <li>Below are the information that the client provided: <br>
                                            • The site is an existing office, they just needed to renovate it quickly because there was an accident that happened. <br>
                                            • They need workstations, low partitions and suspended panel light. <br>
                                            • They already have existing layout or plan for the office.
                                        </li>
                                    </ul>
                                    <ul>
                                        <li><b>Attachments</b></li>
                                        <li>
                                            <a class="attch">requirement.doc</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="teskblock">
                                <div class="tableframe">
                                    <div class="tablebox m02">
                                        <!-- 1 message -->
                                        <ul>
                                            <li class="dialogclear">
                                                <a class="man" style="background-image: url(images/man/man7.jpg);"></a>
                                                <i class="info">
                                                    <b>Nestor Rosales</b><br>
                                                    2:00 PM<br>
                                                    May 3, 2020
                                                </i>
                                            </li>
                                            <li>
                                                <div class="msg">
                                                    <div class="msgbox dialogclear">
                                                        <p>Hi Nestor. Here are the deliverables. Please check. Thank you.</p>
                                                        <a class="attch">building1.jpg</a>
                                                        <a class="attch">building.jpg</a>
                                                        <a class="attch">quotation.pdf</a>
                                                        <a class="attch">rendering.pdf</a>
                                                    </div>
                                                    <div class="btnbox">
                                                        <a class="btn small green reply r3">Reply</a>
                                                        <!-- dialog -->
                                                        <div class="dialog reply r3">
                                                            <div class="formbox">
                                                                <dl>
                                                                    <dd><textarea name="" id=""></textarea></dd>
                                                                    <dd>
                                                                        <div class="browser_group"><span>Photo:</span><input type="text"><button>Choose</button></div>
                                                                    </dd>

                                                                    <dd>
                                                                        <div class="browser_group"><span>File:</span><input type="text"><button>Choose</button></div>
                                                                    </dd>
                                                                    <dd>
                                                                        <div class="btnbox">
                                                                            <a class="btn small orange">Cancel</a>
                                                                            <a class="btn small green">Save</a>
                                                                        </div>
                                                                    </dd>
                                                                </dl>
                                                            </div>
                                                        </div>
                                                        <!-- dialog end -->
                                                        <a class="btn small yellow">Delete</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- 1 message end -->
                                        <ul class="deleted dialogclear">
                                            <li>
                                                <a class="man" style="background-image: url(images/man/man8.jpg);"></a>
                                                <i class="info">
                                                    <b>Dennis Lin</b><br>
                                                    1:00 PM<br>
                                                    May 30, 2020
                                                </i>
                                            </li>
                                            <li>
                                                <div class="msg">
                                                    <div class="msgbox">
                                                        <p>Deleted by <a href="" class="tag_name">@Nestor Rosales</a> at 2020/04/03 15:47</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                        <ul>
                                            <li class="dialogclear">
                                                <a class="man" style="background-image: url(images/man/man9.jpg);"></a>
                                                <i class="info">
                                                    <b>Kuan Lu</b><br>
                                                    1:30 PM<br>
                                                    May 30, 2020
                                                </i>
                                            </li>
                                            <li>
                                                <div class="msg">
                                                    <div class="msgbox dialogclear">
                                                        <p><a href="" class="tag_name">@Dennis Lin</a> I think this task needs to be more careful.</p>
                                                    </div>
                                                    <div class="btnbox">
                                                        <a class="btn small green reply r4">Reply</a>
                                                        <!-- dialog -->
                                                        <div class="dialog reply r4">
                                                            <div class="formbox">
                                                                <dl>
                                                                    <dd><textarea name="" id=""></textarea></dd>
                                                                    <dd>
                                                                        <div class="browser_group"><span>Photo:</span><input type="text"><button>Choose</button></div>
                                                                    </dd>

                                                                    <dd>
                                                                        <div class="browser_group"><span>File:</span><input type="text"><button>Choose</button></div>
                                                                    </dd>
                                                                    <dd>
                                                                        <div class="btnbox">
                                                                            <a class="btn small orange">Cancel</a>
                                                                            <a class="btn small green">Save</a>
                                                                        </div>
                                                                    </dd>
                                                                </dl>
                                                            </div>
                                                        </div>
                                                        <!-- dialog end -->
                                                        <a class="btn small yellow">Delete</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tablebox lv3c m03 dialogclear">
                                    <ul>
                                        <li><textarea name="" id="" placeholder="Write your comment here"></textarea></li>
                                        <li><a class="btn small green">Comment</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="teskbox red dialogclear">
                    <h5>[MESSAGE] Information from Customer</h5>
                    <div class="tablebox2">
                        <ul>
                            <li class="teskblock">
                                <div class="tablebox m01">
                                    <ul>
                                        <li><b>Creator</b></li>
                                        <li><a class="man" style="background-image: url(images/man/man1.jpg);"></a></li>
                                    </ul>
                                    <ul>
                                        <li><b>Date</b></li>
                                        <li>November 4, 2020 / 10:07 AM</li>
                                    </ul>
                                    <ul>
                                        <li><b>Assignee</b></li>
                                        <li>
                                            <a class="man" style="background-image: url(images/man/man2.jpg);"></a>
                                            <a class="man" style="background-image: url(images/man/man3.jpg);"></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="teskblock">
                                <div class="tableframe">
                                    <div class="tablebox m02">
                                        <!-- 1 message -->
                                        <ul>
                                            <li>
                                                <a class="man" style="background-image: url(images/man/man8.jpg);"></a>
                                                <i class="info">
                                                    <b>Dennis Lin</b><br>
                                                    1:00 PM<br>
                                                    May 30, 2020
                                                </i>
                                            </li>
                                            <li>
                                                <div class="msg">
                                                    <div class="msgbox">
                                                        <p>Edited 2020/04/03 15:47</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- 1 message end -->
                                        <ul class="deleted">
                                            <li>
                                                <a class="man" style="background-image: url(images/man/man9.jpg);"></a>
                                                <i class="info">
                                                    <b>Dennis Lin</b><br>
                                                    1:00 PM<br>
                                                    May 30, 2020
                                                </i>
                                            </li>
                                            <li>
                                                <div class="msg">
                                                    <div class="msgbox">
                                                        <p>Deleted at 2020/04/03 15:47</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul>
                                            <li>
                                                <a class="man" style="background-image: url(images/man/man10.jpg);"></a>
                                                <i class="info">
                                                    <b>Dennis Lin</b><br>
                                                    1:00 PM<br>
                                                    May 30, 2020
                                                </i>
                                            </li>
                                            <li>
                                                <div class="msg">
                                                    <div class="msgbox">
                                                        <p>Edited 2020/04/03 15:47</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>


<script defer src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script defer src="js/axios.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/exif-js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript" src="js/project03_other.js" defer></script>
<script defer src="https://kit.fontawesome.com/a076d05399.js"></script>
<style scoped>
    .extendex-top {
        background: none;
        box-shadow: none;
    }

    .bg-whi {
        min-height: 100vh;
        box-sizing: border-box;
    }

    .top-box {

        background-size: 100%;
    }

    .pub-con {
        box-sizing: border-box;
        background-size: 100%;
        text-align: center;
        position: relative;
    }

    .input-zone {
        width: 5rem;
        background-size: 2.13rem;
        border-radius: 0.38rem;
        border: 0.06rem solid rgba(112, 112, 112, 1);
        position: relative;
        color: var(--fth04);
        font-size: 0.88rem;
        box-sizing: border-box;
    }

    .input {
        opacity: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 2;
    }

    .pad {
        padding: 0.5rem 1.7rem 0 0rem;
        font-size: 0.88rem;
    }

    .btn-container {
        margin: 0.69rem auto;
        text-align: center;
    }

    .btn-container .btn {
        width: 10.56rem;
        height: 2.5rem;
        border-radius: 1.25rem;
        border: none;
        color: #ffffff;
    }

    .btn-container .btn.btn-gray {
        background: rgba(201, 201, 201, 1);
    }

    .btn-container .btn.btn-blue {
        background: linear-gradient(180deg,
                rgba(128, 137, 229, 1) 0%,
                rgba(87, 84, 196, 1) 100%);
        font-size: 1rem;
    }

    .tips {
        margin-top: 1.69rem;
    }

    .file-list {
        font-size: 0.88rem;
        color: #5a5cc6;
    }

    .file-list .file-item {
        margin-top: 0.63rem;
    }

    .file-list .file-item p {
        line-height: 1.25rem;
        position: relative;
    }

    .file-list img {
        width: 1.25rem;
        cursor: pointer;
    }

    .file-list img.upload-delete {
        position: absolute;
        bottom: 0;
        margin: 0 auto;
        margin-left: 1rem;
    }

    .progress-wrapper {
        position: relative;
        height: 0.5rem;
        border: 0.06rem solid rgba(92, 91, 200, 1);
        border-radius: 1px;
        box-sizing: border-box;
        width: 87%;
    }

    .progress-wrapper .progress-progress {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0%;
        border-radius: 1px;
        background-color: #5c5bc8;
        z-index: 1;
    }

    .progress-rate {
        font-size: 14px;
        height: 100%;
        z-index: 2;
        width: 12%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .progress-rate span {
        display: inline-block;
        width: 100%;
        text-align: right;
    }

    .progress-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-list img.upload-success {
        margin-left: 0;
    }
</style>

</html>