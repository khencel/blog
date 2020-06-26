<template>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 pt-4">
                <div class="card">
                    <div class="card-header">Deleted Blog</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <th>Title</th>
                                <th>Description</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-if="Object.keys(deletedPost).length == 0">
                                    <td class="text-center" colspan="3">No deleted blog...</td>
                                </tr>
                                <tr v-else v-for="item in deletedPost" :key="item.id">
                                    <td>{{item.title}}</td>
                                    <td>{{item.description}}</td>
                                    <td>
                                        <span style="cursor:pointer" class="badge badge-primary p-2" @click="btnRestore(item.id)">Restore</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                deletedPost:{},
            }
        },
        methods:{
            loadDeletedPost(){
                axios.get('api/deleted?api_token='+window.token)
                .then(response => {
                    this.deletedPost = response.data;
                });
            },
            btnRestore(id){
                axios.get('api/restore/'+id+"?api_token="+window.token)
                .then(response => {
                    this.$router.push('home')
                });
            }
        },
        mounted() {
            this.loadDeletedPost();
        }
    }
</script>
