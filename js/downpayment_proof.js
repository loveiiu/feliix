
var app = new Vue({
  el: '#app',
  data:{
    name: "",
    month1:'',

    picked:'A',
    view_detail:false,

    submit: false,

    receive_records: [],
    record: {},

    baseURL:'https://storage.cloud.google.com/feliiximg/',

    proof_remark:'',

    proof_id: 0,

        // paging
    page: 1,
    //perPage: 10,
    pages: [],

    perPage: 5,

    is_approval: false,

  },

  created () {
    
    this.getUserName();

  },

  computed: {
    displayedRecord () {
      this.setPages();
        return this.paginate(this.receive_records);
    },

  },

  mounted(){
   var d1 = new Date();
    this.month1 = d1;

    $('#start').val(d1.toISOString().slice(0,7).replace(/-/g,"-"));

    this.getLeaveCredit();
    
  },

  watch: {

      picked () {
        this.getLeaveCredit();
      },
  },



  methods:{

    setPages () {
      console.log('setPages');
      this.pages = [];
      let numberOfPages = Math.ceil(this.receive_records.length / this.perPage);

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
      return  this.receive_records.slice(from, to);
    },

    
    getLeaveCredit: function() {
      let _this = this;

      axios.get('api/downpayment_proof')
          .then(function(response) {
              console.log(response.data);
              _this.receive_records = response.data;


          })
          .catch(function(error) {
              console.log(error);
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
            if(_this.name === "Glendon Wendell Co")
              _this.is_approval = true;

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

      unCheckCheckbox()
        {
            for (i = 0; i < this.receive_records.length; i++) 
            {
              this.receive_records[i].is_checked = false;
            }
          //$(".alone").prop("checked", false);
          //this.clicked = false;
        },

      showPic(pic)
      {
        Swal.fire({
          title: 'Certificate of Diagnosis',
          text: 'Click to close',
          imageUrl: 'img/' + pic,
        })
      },

      approveReceiveRecord: function(id) {
            let _this = this;
            //targetId = this.record.id;
            var form_Data = new FormData();

            form_Data.append('crud', "app");
            form_Data.append('id', id);
            form_Data.append('remark', this.proof_remark);

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/downpayment_proof_approval',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.resetForm();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },

        rejectReceiveRecord: function(id) {
            let _this = this;
            //targetId = this.record.id;
            var form_Data = new FormData();

            form_Data.append('crud', "rej");
            form_Data.append('id', id);
            form_Data.append('remark', this.proof_remark);

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/downpayment_proof_reject',
                    data: form_Data
                })
                .then(function(response) {
                    //handle success
                    //this.$forceUpdate();
                    _this.resetForm();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response)
                });
        },

        detail: function() {
          let _this = this;

        //let favorite = [];
          
          //for (i = 0; i < this.receive_records.length; i++) 
            //{
            //  if(this.receive_records[i].is_checked == 1)
            //    favorite.push(this.receive_records[i].sid);
            //}

            if (this.proof_id == 0) {
              Swal.fire({
                text: 'Please select row to see the detail!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                this.view_detail = false;
                return;
            }

            this.record = this.shallowCopy(this.receive_records.find(element => element.id == this.proof_id));

            this.view_detail = true;

        },

    approve: function() {

      let _this = this;

        let favorite = [];

        var approve_record = false;
          
          for (i = 0; i < this.receive_records.length; i++) 
            {
              if(this.receive_records[i].id == this.proof_id)
              {
                if(this.receive_records[i].status === "-1")
                {
                  Swal.fire({
                    text: 'Rejected data cannot be approved! Please contact Admin or IT staffs.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                  });

                  return;
                }

                if(this.receive_records[i].status === "1")
                {
                  Swal.fire({
                    text: 'Approved data cannot be approved again! Please contact Admin or IT staffs.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                  });

                  return;
                }

                favorite.push(this.receive_records[i].id);
              }
            }

            if (favorite.length < 1) {
              Swal.fire({
                text: 'Please select rows to approve!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

          

          Swal.fire({
            title: 'Are you sure to approve?',
            text: "Are you sure to approve apply?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
              _this.submit = true;
              _this.approveReceiveRecord(favorite.join(", "));

              _this.resetForm();
              _this.unCheckCheckbox();
            }
          })

      },

      reject: function() {

      let _this = this;

        let favorite = [];

        var approve_record = false;
          
          for (i = 0; i < this.receive_records.length; i++) 
            {
              if(this.receive_records[i].id == this.proof_id )
              {
                if(this.receive_records[i].status === "-1")
                {
                  Swal.fire({
                    text: 'Rejected data cannot be rejected again! Please contact Admin or IT staffs.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                  });

                  return;
                }

                if(this.receive_records[i].status === "1")
                {
                  Swal.fire({
                    text: 'Approved data cannot be rejected! Please contact Admin or IT staffs.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                  });

                  return;
                }

                favorite.push(this.receive_records[i].id);
              }
            }

            if (favorite.length < 1) {
              Swal.fire({
                text: 'Please select rows to reject!',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

          

          Swal.fire({
            title: 'Are you sure to reject?',
            text: "Are you sure to reject apply?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
              _this.submit = true;
              _this.rejectReceiveRecord(favorite.join(", "));

              _this.resetForm();
              _this.unCheckCheckbox();
            }
          })

      },

      resetForm: function() {
          
            this.submit = false;
            this.view_detail = false;

          this.receive_records = [];
          this.record = {};

          this.proof_id = 0;
          this.proof_remark = "";

          this.getLeaveCredit();

        },

        shallowCopy(obj) {
          console.log("shallowCopy");
            var result = {};
            for (var i in obj) {
                result[i] = obj[i];
            }
            return result;
        },


  }
});