
var app = new Vue({
  el: '#app',
  data:{
    name: "",
    month1:'',

    picked:'A',

    submit: false,

    receive_records: [],


  },

  created () {
    this.getLeaveCredit();
    this.getUserName();

  },

  computed: {
    displayedRecord () {
      return this.receive_records;
    },

  },

  mounted(){
   
  },

  watch: {

      month1 () {
        this.getLeaveCredit();
      },

      picked () {
        this.getLeaveCredit();
      },
  },



  methods:{

    
    getLeaveCredit: function() {
      let _this = this;

      if (this.month1 === undefined)
        return;

      if (this.month1 === '')
        return;

        var sdate1 = '';
        var edate1 = '';

      if(this.month1)
      {
        var d1 = new Date(this.month1);
        sdate1 = d1.toISOString().slice(0,10).replace(/-/g,"");
        var newDate1 = new Date(d1.setMonth(d1.getMonth()+1));
        edate1 = newDate1.toISOString().slice(0,10).replace(/-/g,"");
      }

      axios.get('api/leave_record?sdate1=' + sdate1 + '&edate1=' + edate1 + "&type=" + _this.picked)
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

      delReceiveRecord: function(id) {
            let _this = this;
            //targetId = this.record.id;
            var form_Data = new FormData();

            form_Data.append('crud', "del");
            form_Data.append('id', id);

            var params = {
                'id': id
            }

            const token = sessionStorage.getItem('token');

            axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    },
                    url: 'api/leave_record_delete',
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

    apply: function() {

      let _this = this;

        let favorite = [];
          
          for (i = 0; i < this.receive_records.length; i++) 
            {
              if(this.receive_records[i].is_checked == 1)
                favorite.push(this.receive_records[i].id);
            }

            if (favorite.length < 1) {
              Swal.fire({
                text: 'Please select rows to redraw!.',
                icon: 'warning',
                confirmButtonText: 'OK'
              })
                
                //$(window).scrollTop(0);
                return;
            }

          

          Swal.fire({
            title: 'Are you sure to redraw?',
            text: "Are you sure to redraw apply?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
              _this.submit = true;
              _this.delReceiveRecord(favorite.join(", "));

              _this.resetForm();
              _this.unCheckCheckbox();
            }
          })

      },

      resetForm: function() {
          
            this.month1 = '';

            this.submit = false;
            this.picked ='A';

          this.receive_records = [];

        },


  }
});