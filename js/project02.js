var app = new Vue({
  el: '#app',
  data:{
    project_id: 0,
    receive_records: [],
    receive_stage_records: [],
    record: {},

    project_comments: {},
    project_probs: {},

    categorys : {},
    client_types : {},
    priorities : {},
    statuses : {},
    stages : {},
    users : {},


    category: '',
    category_id:0,
    client_type : '',
    client_type_id:0,
    priority:'',
    priority_id:0,
    username:'',
    stage:'',
    created_at:'',
    end_at:'',
    location:'',
    contactor:'',
    contact_number:'',
    edit_reason:'',

    // + sign
    stage_sequence:'',
    project_stage:'',
    stage_status:'',


    // Change Project Status
    project_status:'',
    project_status_edit:'',
    project_status_reason:'',

    // Edit Project Info
    edit_category:'',
    edit_client_type:'',
    edit_priority: '',
    edit_contactor:'',
    edit_contact_number:'',
    edit_location:'',
    edit_project_reason:'',

    //  Action to Comments
    comment : '',
    file1: '',
    file2: '',

    startValue: 0,

    //Acton to Est. Closing Prob.
    probability : 0,
    prob_reason :'',

    // Acton to Project Details
    detail_type: '',
    detail_desc: '',
    fileArray: [],
    canSub: true,
    finish: false,


    submit : false,
    // paging
    page: 1,
    //perPage: 10,
    pages: [],

    inventory: [
      {name: '10', id: 10},
      {name: '25', id: 25},
      {name: '50', id: 50},
      {name: '100', id: 100},
      {name: 'All', id: 10000}
    ],
    perPage: 20,

  },

  created () {
    let _this = this;
    let uri = window.location.href.split('?');
    if (uri.length == 2)
    {
      let vars = uri[1].split('&');
      let getVars = {};
      let tmp = '';
      vars.forEach(function(v){
        tmp = v.split('=');
        if(tmp.length == 2)
        _this.project_id = tmp[1];
        _this.getRecordsStage(_this.project_id);
        _this.getProject(_this.project_id);
        _this.getProjectComments(_this.project_id);
        _this.getProjectProbs(_this.project_id);
      });
    }

    this.getProjectCategorys();
    this.getClientTypes();
    this.getPrioritys();
    this.getStatuses();
    this.getStages();

    this.getUsers();

    

  },

  computed: {
    displayedStagePosts () {
      this.setPages();
        return this.paginate(this.receive_stage_records);
    },

    showExtra: function(){
      return (this.status==10);
    },
  },

  mounted(){
 

  },

  watch: {

    receive_stage_records () {
        console.log('Vue watch receive_stage_records');
        this.setPages();
      },

  fileArray: {
      handler(newValue, oldValue) {
        console.log(newValue);
        var finish = newValue.find(function(currentValue, index) {
          return currentValue.progress != 1;
        });
        if (finish === undefined && this.fileArray.length) {
          this.finish = true;
          Swal.fire({
            text: "upload finished",
            type: "success",
            duration: 1 * 1000,
            customClass: "message-box",
            iconClass: "message-icon"
          });
          this.detail_clear();
        }
      }
    }

  },



  methods:{

    deleteFile(index) {
      this.fileArray.splice(index, 1);
      var fileTarget = this.$refs.file;
      fileTarget.value = "";
    },

    changeFile() {
      var fileTarget = this.$refs.file;
      /*
      if (this.fileArray.length >= 10) {
        Swal.fire({
          text: "ten files",
          type: "success",
          duration: 1 * 1000,
          customClass: "message-box",
          iconClass: "message-icon"
        });
        fileTarget.value = "";
      } else {
        if (fileTarget.files[0].size > 31457280) {
          Swal.fire({
            text: "30M",
            type: "success",
            duration: 1 * 1000,
            customClass: "message-box",
            iconClass: "message-icon"
          });
          fileTarget.value = "";
        } else {
            
        */
        for (i = 0; i < fileTarget.files.length; i++) {
            // remove duplicate
            if (
              this.fileArray.indexOf(fileTarget.files[i]) == -1 ||
              this.fileArray.length == 0
            ) {
              var fileItem = Object.assign(fileTarget.files[i], { progress: 0 });
              this.fileArray.push(fileItem);
            }else{
              fileTarget.value = "";
            }
          }
    },

    setPages () {
        console.log('setPages');
        this.pages = [];
        let numberOfPages = Math.ceil(this.receive_stage_records.length / this.perPage);

        if(numberOfPages == 1)
          this.page = 1;
        for (let index = 1; index <= numberOfPages; index++) {
          this.pages.push(index);
        }
      },

      paginate: function (posts) {
        console.log('paginate');
        if(this.page < 1)
          this.page = 1;
        if(this.page > this.pages.length)
          this.page = this.pages.length;

        let page = this.page;
        let perPage = this.perPage;
        let from = (page * perPage) - perPage;
        let to = (page * perPage);
        return  this.receive_stage_records.slice(from, to);
      },

    getRecordsStage: function(keyword) {
      let _this = this;

      if(keyword == 0)
        return;

      const params = {
              pid : keyword,
            };

          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/project02_stages', { params, headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.receive_stage_records = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getProjectComments: function(keyword) {
      let _this = this;

      if(keyword == 0)
        return;

      const params = {
              pid : keyword,
            };

          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/project_comments', { params, headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.project_comments = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getProjectProbs: function(keyword) {
      let _this = this;

      if(keyword == 0)
        return;

      const params = {
              pid : keyword,
            };

          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/project_est_prob', { params, headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.project_probs = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getProject: function(keyword) {

          let _this = this;

          if(keyword == 0)
            return;

          const params = {
              pid : keyword,
            };
    
          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/project02', { params, headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.category = res.data[0].category;
                  _this.client_type = res.data[0].client_type;
                  _this.priority = res.data[0].priority;
                  _this.username = res.data[0].username;
                  _this.stage = res.data[0].stage;
                  _this.project_status = res.data[0].project_status;

                  _this.category_id = res.data[0].category_id;
                  _this.client_type_id = res.data[0].client_type_id;
                  _this.priority_id = res.data[0].priority_id;
                  _this.contactor = res.data[0].contactor;
                  _this.location = res.data[0].location;
                  _this.contact_number = res.data[0].contact_number;

                  _this.edit_category = res.data[0].category_id;
                  _this.edit_client_type = res.data[0].client_type_id;
                  _this.edit_priority = res.data[0].priority_id;
                  _this.edit_contactor = res.data[0].contactor;
                  _this.edit_location = res.data[0].location;
                  _this.edit_contact_number = res.data[0].contact_number;

              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

    getProjectCategorys () {

          let _this = this;
    
          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/admin/project_category', { headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.categorys = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getUsers () {

          let _this = this;
    
          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/project02_user', { headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.users = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getClientTypes () {

          let _this = this;
    
          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/admin/project_client_type', { headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.client_types = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getPrioritys () {

          let _this = this;
    
          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/admin/project_priority', { headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.priorities = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },
    
      getStatuses () {

          let _this = this;
    
          let token = localStorage.getItem('accessToken');

          
    
          axios
              .get('api/admin/project_status', { headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.statuses = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

      getStages () {

          let _this = this;
    
          let token = localStorage.getItem('accessToken');
    
          axios
              .get('api/admin/project_stage', { headers: {"Authorization" : `Bearer ${token}`} })
              .then(
              (res) => {
                  _this.stages = res.data;
              },
              (err) => {
                  alert(err.response);
              },
              )
              .finally(() => {
                  
              });
      },

    

    getUserName: function() {
        var token = localStorage.getItem('token');
        var form_Data = new FormData();
        let _this = this;

        form_Data.append('jwt', token);

        axios({
            method: 'post',
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            url: 'api/on_duty_get_myname',
            data: form_Data
        })
        .then(function(response) {
            //handle success
            _this.name = response.data.username;
            _this.is_manager = response.data.is_manager;

        })
        .catch(function(response) {
            //handle error
            Swal.fire({
              text: JSON.stringify(response),
              icon: 'error',
              confirmButtonText: 'OK'
            })
        });
      },

      onChangeFile1Upload() {
            this.file1 = this.$refs.file1.files[0];
        },

        onChangeFile2Upload() {
            this.file2 = this.$refs.file2.files[0];
        },


      clear: function() {
        this.project_name = '';
        this.project_category = '';
        this.client_type = '';
        this.priority = '';
        this.status = '';
        this.reason = '';
        this.probability = '';
        this.special_note = '';
        
        document.getElementById('insert_dialog').classList.remove("show");


        this.receive_stage_records = [];

        this.getRecords();
        

      },


        shallowCopy(obj) {
          console.log("shallowCopy");
            var result = {};
            for (var i in obj) {
                result[i] = obj[i];
            }
            return result;
        },

        comment_clear() {
            this.comment = '';
            this.file1 = '';
            this.$refs.file2.value = null;
            this.file2 = '';
            this.$refs.file1.value = null;

            this.getProjectComments(this.project_id);

            document.getElementById('comment_dialog').classList.remove("show");
            document.getElementById('project_fn3').classList.remove("focus");
        },


        detail_clear() {

            this.detail_type = '';
            this.detail_desc = '';

            this.fileArray = [];

            //this.getProjectDetail(this.project_id);
            this.canSub = true;
            
            document.getElementById('detail_dialog').classList.remove("show");
            document.getElementById('status_fn5').classList.remove("focus");
        },


        prob_clear() {

            this.probability = 0;
            this.prob_reason = '';

            this.getProjectProbs(this.project_id);
            
            document.getElementById('prob_dialog').classList.remove("show");
            document.getElementById('status_fn4').classList.remove("focus");
        },

        project_clear() {

            this.edit_category = this.category_id;
            this.edit_client_type = this.client_type_id;
            this.edit_priority = this.priority_id;
            this.edit_contactor = this.contactor;
            this.edit_location = this.location;
            this.edit_contact_number = this.contact_number;
            
            document.getElementById('project_dialog').classList.remove("show");
            document.getElementById('project_fn2').classList.remove("focus");
        },

        stage_clear() {
            this.stage_sequence = '';
            this.project_stage = '';
            this.stage_status = '';
            
            
            document.getElementById('stage_dialog').classList.remove("show");
            document.getElementById('stage_fn1').classList.remove("focus");

            this.receive_stage_records = [];

            this.getRecordsStage(this.project_id);
        },

        status_clear() {
            this.project_status_edit = '';
            this.project_status_reason = '';
      
            document.getElementById('status_dialog').classList.remove("show");
            document.getElementById('status_fn1').classList.remove("focus");
            //this.receive_stage_records = [];

            //this.getRecordsStage(this.project_id);
        },

        prob_create() {
            let _this = this;

            if (this.prob_reason.trim() == '') {
              Swal.fire({
                text: 'Please enter probability reason!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }


            _this.submit = true;
            var form_Data = new FormData();

            form_Data.append('pid', this.project_id);
            form_Data.append('probability', this.probability);
            form_Data.append('prob_reason', this.prob_reason.trim());

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/project_est_prob',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.prob_clear();
                    _this.getProject(_this.project_id);
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },

        detail_create() {
            let _this = this;

            if (this.detail_type.trim() == '') {
              Swal.fire({
                text: 'Please select detail type!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            if (this.detail_desc.trim() == '') {
              Swal.fire({
                text: 'Please enter detail description!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }


            _this.submit = true;
            var form_Data = new FormData();

            form_Data.append('pid', this.project_id);
            form_Data.append('detail_type', this.detail_type);
            form_Data.append('detail_desc', this.detail_desc.trim());

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/project_action_detail',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    if(response.data['batch_id'] != 0)
                    {
                        _this.upload(response.data['batch_id']);
                    }
                    //this.$forceUpdate();
                    _this.prob_clear();
                    _this.getProject(_this.project_id);
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },


        upload(batch_id) {
            
              this.canSub = false;
              var myArr = this.fileArray;
              var vm = this;
             
              //循环文件数组挨个上传
              myArr.forEach((element, index) => {
                var config = {
                  headers: { "Content-Type": "multipart/form-data" },
                  onUploadProgress: function(e) {
         
                    if (e.lengthComputable) {
                      var rate = e.loaded / e.total; 
                      console.log(index, e.loaded, e.total, rate);
                      if (rate < 1) {
                        
                        myArr[index].progress = rate;
                        vm.$set(vm.fileArray, index, myArr[index]);
                      } else {
                        myArr[index].progress = 0.99;
                        vm.$set(vm.fileArray, index, myArr[index]);
                      }
                    }
                  }
                };
                var data = myArr[index];
                var myForm = new FormData();
                myForm.append('batch_type', 'action_detail');
                myForm.append('batch_id', batch_id);
                myForm.append("file", data);
       
                axios
                  .post("api/uploadFile_gcp", myForm, config)
                  .then(function(res) {
                    if (res.data.code == 0) {
                 
                      myArr[index].progress = 1;
                      vm.$set(vm.fileArray, index, myArr[index]);
                      console.log(vm.fileArray, index);
                    } else {
                      alert(JSON.stringify(res.data));
                    }
                  })
                  .catch(function(err) {
                    console.log(err);
                  });
              });
            
          },

        comment_create() {
            let _this = this;

            if (this.comment.trim() == '') {
              Swal.fire({
                text: 'Please input Comment!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            _this.submit = true;
            var form_Data = new FormData();

            form_Data.append('pid', this.project_id);
            form_Data.append('comment', this.comment);
            form_Data.append('file1', this.file1);
            form_Data.append('file2', this.file2);
            
            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    onUploadProgress(progressEvent){
                      if (progressEvent.lengthComputable) {
                        let val = (progressEvent.loaded / progressEvent.total * 100).toFixed(0);
            
                        _this.startValue = parseInt(val)
                      }
                    },
                    url: 'api/project02_action_comment',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.comment_clear();
                    _this.getProject(_this.project_id);
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },

        project_create() {
            let _this = this;

            if (this.edit_category.trim() == 0) {
              Swal.fire({
                text: 'Please select Project Category!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            if (this.edit_client_type.trim() == 0) {
              Swal.fire({
                text: 'Please select Client Type!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            if (this.edit_priority.trim() == 0) {
              Swal.fire({
                text: 'Please select Priority!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }


            _this.submit = true;
            var form_Data = new FormData();

            form_Data.append('pid', this.project_id);
            form_Data.append('edit_category', this.edit_category);
            form_Data.append('edit_client_type', this.edit_client_type);
            form_Data.append('edit_priority', this.edit_priority);
            form_Data.append('edit_contactor', this.edit_contactor);
            form_Data.append('edit_location', this.edit_location);
            form_Data.append('edit_contact_number', this.edit_contact_number);
            form_Data.append('edit_project_reason', this.edit_project_reason);

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/project02_edit_project_info',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.project_clear();
                    _this.getProject(_this.project_id);
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },

        status_create() {
            let _this = this;

            if (this.project_status_reason.trim() == '') {
              Swal.fire({
                text: 'Please enter Stage Sequence!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            if (this.project_status_edit.trim() == '') {
              Swal.fire({
                text: 'Please select Project Status!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            _this.submit = true;
            var form_Data = new FormData();

            form_Data.append('pid', this.project_id);
            form_Data.append('project_status_edit', this.project_status_edit);
            form_Data.append('project_status_reason', this.project_status_reason.trim());

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/project02_insert_status',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.status_clear();
                    _this.getProject(_this.project_id);
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },


        stage_add() {
          let _this = this;

            if (this.stage_sequence.trim() == '') {
              Swal.fire({
                text: 'Please enter Stage Sequence!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            if (this.project_stage.trim() == '') {
              Swal.fire({
                text: 'Please select Project Stage!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

            if (this.stage_status.trim() == '') {
              Swal.fire({
                text: 'Please select Stage Status!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }


            _this.submit = true;
            var form_Data = new FormData();

            form_Data.append('pid', this.project_id);
            form_Data.append('stage_sequence', this.stage_sequence);
            form_Data.append('project_stage', this.project_stage);
            form_Data.append('stage_status', this.stage_status);

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/project02_insert_stage',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.stage_clear();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },




  }
});