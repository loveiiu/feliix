
var app = new Vue({
  el: '#app',
  data:{
    receive_records: [],
  },

  created () {
    this.getRecords();
  },

  computed: {
    displayedRecord () {
      return this.receive_records;
    },
  },

  mounted(){
   
  },

  methods:{
    getRecords: function(keyword) {
        axios.get('api/attendance')
            .then(function(response) {
                console.log(response.data);
                app.receive_records = response.data;

            })
            .catch(function(error) {
                console.log(error);
            });
    },

      reset: function() {
          
            this.today = '';
            this.type = '';
            this.location = '';
            this.remark = '';
            this.time = '';
            this.explanation = '';
            this.err_msg = '';

            this.getLocation();
            this.getToday();
            
        },
 
  }
});