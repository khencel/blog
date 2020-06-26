<template>
    <div class="container pt-5">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8 pb-5">
                <div class="card">
                    <div class="card-header">Blog</div>

                    <div class="card-body">
                        <div class="text-center">
                                <img class="img-fluid" :src="url == null ? '/storage/img/photo.png' : url" alt="">   
                        </div>
                        <div class="w-100 choose_file">
                            <button type="button" class="btn btn-primary form-control">Choose Image</button>
                            <input type="file" name="img" accept="image/*" v.form="photo" @change="uploadImage"> 
                        </div>
                        <div>
                            <label for="title">Title</label>
                            <input type="text" placeholder="Title here" v-model="form.title" class="form-control">
                            <span class="font-italic font-weight-bold text-danger" v-if="errors.title" v-text="errors.title[0]"></span>
                        </div>
                        <div>
                            <label for="description">Description</label>
                            <textarea placeholder="Description here" v-model="form.description" class="form-control" cols="30" rows="10"></textarea>
                            <span class="font-italic font-weight-bold text-danger" v-if="errors.description" v-text="errors.description[0]"></span>
                        </div>
                        <div class="mt-2 text-right">
                            <button v-show="!editMode" class="btn btn-success" @click="btnSave">Submit</button>
                            <button v-show="editMode" class="btn btn-primary" @click="btnUpdate">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                editMode:false,
                url:null,
                path:'/storage/img/',
                errors:{},
                form:new Form({
                    photo:'',
                    title:'',
                    description:'',
                }),
            }
        },
        methods:{
            uploadImage(e){
                let file = e.target.files[0];
                this.url = URL.createObjectURL(file);
                let reader = new FileReader();
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },

            btnSave(){
                this.form.post('api/blog?api_token='+window.token)
                .then(response => {
                    this.$router.push('home')
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            loadBlogInfo(){
                
                if(this.$route.params.id != null){
                    this.editMode = true;
                    axios.get('/api/blog/'+this.$route.params.id+"?api_token="+window.token)
                    .then(response => {
                        this.form.title = response.data.blog.title;
                        this.form.description = response.data.blog.description;
                        this.form.photo = response.data.blog.image;
                        this.url = this.path + response.data.blog.image;
                    });
                }
            },

            btnUpdate(){
                this.form.put('/api/blog/'+this.$route.params.id+"?api_token="+window.token)
                .then(response => {
                    this.$router.push('../home')
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            }
        },
        mounted() {
            this.loadBlogInfo();
        }
    }
</script>
