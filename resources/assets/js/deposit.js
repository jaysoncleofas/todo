Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-vue',

  data: {
    deposit: [],
    pagination: {
      total: 0,
      per_page: 2,
      from: 1,
      to: 0,
      current_page: 1
    },
    offset: 4,
    formErrors: {},
    formErrorsUpdate: {},
    newDeposit: {
      'amount': '',
      'description': ''
    },
    fillDeposit: {
      'amount': '',
      'description': '',
      'id': ''
    }
  },

  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },

  ready: function() {
    this.getVueDeposits(this.pagination.current_page);
  },

  methods: {

    getVueDeposits: function(page) {
      this.$http.get('/vuedeposits?page=' + page).then((response) => {
        this.$set('deposits', response.data.data.data);
        this.$set('pagination', response.data.pagination);
      });
    },

    createItem: function() {
      var input = this.newDeposit;
      this.$http.post('/vuedeposits', input).then((response) => {
        this.changePage(this.pagination.current_page);
        this.newDeposit = {
          'amount': '',
          'description': ''
        };
        $("#create-deposit").modal('hide');
        toastr.success('Deposit Created Successfully.', 'Success Alert', {
          timeOut: 5000
        });
      }, (response) => {
        this.formErrors = response.data;
      });
    },

    deleteItem: function(deposit) {
      this.$http.delete('/vuedeposits/' + deposit.id).then((response) => {
        this.changePage(this.pagination.current_page);
        toastr.success('Deposit Deleted Successfully.', 'Success Alert', {
          timeOut: 5000
        });
      });
    },

    editItem: function(deposit) {
      this.fillDeposit.amount = deposit.amount;
      this.fillDeposit.id = deposit.id;
      this.fillDeposit.description = deposit.description;
      $("#edit-deposit").modal('show');
    },

    updateItem: function(id) {
      var input = this.fillDeposit;
      this.$http.put('/vuedeposits/' + id, input).then((response) => {
        this.changePage(this.pagination.current_page);
        this.fillDeposit = {
          'amount': '',
          'description': '',
          'id': ''
        };
        $("#edit-deposit").modal('hide');
        toastr.success('Deposit Updated Successfully.', 'Success Alert', {
          timeOut: 5000
        });
      }, (response) => {
        this.formErrorsUpdate = response.data;
      });
    },

    changePage: function(page) {
      this.pagination.current_page = page;
      this.getVueDeposits(page);
    }

  }

});
