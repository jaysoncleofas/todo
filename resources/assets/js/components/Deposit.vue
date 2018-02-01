<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button @click="initAddDeposit()" class="btn btn-primary btn-xs pull-right">
                        + Add New Deposit
                    </button>
                    My Deposits
                </div>

                <div class="panel-body">
                  <table class="table table-bordered table-striped table-responsive" v-if="deposits.length > 0">
                            <tbody>
                                <tr>
                                    <th>
                                        No.
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                                <tr v-for="(deposit, index) in deposits">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        {{ deposit.deposit }}
                                    </td>
                                    <td>
                                        {{ deposit.description }}
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-xs">Edit</button>
                                        <button class="btn btn-danger btn-xs">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="add_Deposit_model">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Deposit</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger" v-if="errors.length > 0">
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="name">Amount:</label>
                        <input type="text" name="deposit" id="deposit" placeholder="Deposit Amount" class="form-control"
                               v-model="deposit.deposit">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                  placeholder="Deposit Description" v-model="deposit.description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="createDeposit" class="btn btn-primary">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
</template>

<script>
export default {
    data(){
        return {
            deposit: {
                deposit: '',
                description: ''
            },
            errors: [],
            deposits: []
        }
    },
    mounted()
    {
      this.readDeposits();
    },
    methods: {
        initAddDeposit()
        {
            this.errors = [];
            $("#add_Deposit_model").modal("show");
        },
        createDeposit()
        {
            axios.post('/deposit', {
                name: this.deposit.deposit,
                description: this.deposit.description,
            })
                .then(response => {

                    this.reset();
                    this.deposits.push(response.data.deposit);
                    $("#add_deposit_model").modal("hide");

                })
                .catch(error => {
                    this.errors = [];
                    if (error.response.data.errors.name) {
                        this.errors.push(error.response.data.errors.name[0]);
                    }

                    if (error.response.data.errors.description) {
                        this.errors.push(error.response.data.errors.description[0]);
                    }
                });
        },
        reset()
        {
            this.deposit.deposit = '';
            this.deposit.description = '';
        },
        readDeposits()
        {
          axios.get('/deposit')
          .then(response => {

              this.deposits = response.data.deposits;

          });
        }
    }
}
</script>
